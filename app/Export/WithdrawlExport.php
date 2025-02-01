<?php

namespace App\Export;

use App\Models\CommissionHistory;
use App\Models\Withdraw;
use App\Models\WithdrawlAdmin;
use Barryvdh\DomPDF\Facade\Pdf;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WithdrawlExport
{

  public static function export_pdf($request)
  {
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    $data = self::getData($start_date, $end_date);

    $pdf = Pdf::loadView('content.withdraw.export_pdf', ['data' => $data]);
    return $pdf->download('laporan-withdrawl.pdf');
  }

  public static function export_excel($request)
  {
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    $data = self::getData($start_date, $end_date);

    $object     = new Spreadsheet();
    $object->getProperties()->setCreator(strtoupper('Withdrawl'));
    $object->setActiveSheetIndex(0);
    $sheet = $object->getActiveSheet();
    $sheet->setTitle('Laporan Withdrawl');

    $styleArray = array(
      'borders' => array(
        'outline' => array(
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => array('argb' => '000000'),
        ),
      ),
    );

    $object->getActiveSheet()->getStyle('A1:D1')->applyFromArray(array(
      'borders' => array(
        'outline' => array(
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => array('argb' => '000000'),
        ),
      ),
    ));

    $sheet->setCellValue('A1', 'Tanggal');
    $sheet->setCellValue('B1', 'Nama Pengajuan');
    $sheet->setCellValue('C1', 'Rekening');
    $sheet->setCellValue('D1', 'Atas Nama');
    $sheet->setCellValue('E1', 'Tipe Pengajuan');
    $sheet->setCellValue('F1', 'Nominal');

    $row_number = 2;
    $grand_total = 0;
    foreach ($data as $row) {
      $sheet->setCellValue('A' . $row_number, $row->created_at);
      $sheet->setCellValue('B' . $row_number, $row->user_submission);
      $sheet->setCellValue('C' . $row_number, "$row->rekening_withdraw");
      $sheet->setCellValue('D' . $row_number, $row->atas_nama);
      $sheet->setCellValue('E' . $row_number, $row->nominal_withdraw);
      $sheet->setCellValue('F' . $row_number, $row->type_submission);

      $object->getActiveSheet()->getStyle('A2:E' . $row_number)->applyFromArray(array(
        'borders' => array(
          'outline' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => '000000'),
          ),
        ),
      ));
      $object->getActiveSheet()->getStyle('D' . $row_number)
        ->getNumberFormat()
        ->setFormatCode('#,##0.00');
      $row_number++;
      $grand_total += $row->nominal_withdraw;
    }

    $object->getActiveSheet()->getStyle('E')
      ->getNumberFormat()
      ->setFormatCode('#,##0.00');

    $object->getActiveSheet()->getStyle("A$row_number:F$row_number")->applyFromArray(array(
      'borders' => array(
        'outline' => array(
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => array('argb' => '000000'),
        ),
      ),
    ));
    $sheet->setCellValue('F' . $row_number, $grand_total);

    foreach (range('A', 'F') as $columnID) {
      $object->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
    }

    $sheet->getPageSetup()->setFitToWidth(1);
    $objWriter = new Xlsx($object);
    ob_start();
    $objWriter->save('php://output');
    $export = ob_get_contents();
    ob_end_clean();
    header('Content-Type: application/json');
    if (count($data) > 0) {
      return response()->json([
        'status'     => true,
        'code'       => 200,
        'name'       => 'laporan-komisi-withdrawl-' . date('d-m-Y') . '.xlsx',
        'message'    => "Berhasil Download Data Laporan",
        'file'         => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($export)
      ], 200);
    } else {
      return response()->json([
        'status'     => false,
        'message'    => "Data tidak ditemukan",
      ], 200);
    }
  }

  public static function getData($startDate, $endDate)
  {
    $withdrawl_member = Withdraw::select(
      'users.name AS user_submission',
      'users.id AS user_submission_id',
      'withdraws.id AS withdraw_id',
      'withdraws.*',
    );
    $withdrawl_member->leftJoinUser();
    $withdrawl_member->leftJoin(
      'user_details',
      'users.id',
      'user_details.user_id'
    );
    $withdrawl_member->when(($startDate && $endDate), function ($query) use ($startDate, $endDate) {
      $query->whereBetween('withdraws.created_at', [$startDate, $endDate]);
    });
    $withdrawl_member->where('status_withdraw', 'selesai');
    $withdrawl_member->addSelect(DB::raw("'member' AS type_submission"));

    // ! Withdrawl admin
    $withdrawl_admin = WithdrawlAdmin::select(
      'admins.name as user_submission',
      'admins.id as user_submission_id',
      'withdrawl_admins.id AS withdraw_id',
      'withdrawl_admins.*',
    );
    $withdrawl_admin->leftJoinAdmin();
    $withdrawl_admin->leftJoinAdminDetail();
    $withdrawl_admin->when(($startDate && $endDate), function ($query) use ($startDate, $endDate) {
      $query->whereBetween('withdrawl_admins.created_at', [$startDate, $endDate]);
    });
    $withdrawl_admin->where('status_withdraw', 'selesai');
    $withdrawl_admin->addSelect(DB::raw("'editor' AS type_submission"));

    return $withdrawl_admin->union($withdrawl_member)
      ->get();
  }
}
