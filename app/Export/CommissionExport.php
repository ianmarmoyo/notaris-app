<?php

namespace App\Export;

use App\Models\CommissionHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use GPBMetadata\Google\Api\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class CommissionExport
{
  public static function export_pdf($request)
  {
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    $data = self::getData($start_date, $end_date);

    $pdf = Pdf::loadView('content.commission.export_pdf', ['data' => $data]);
    return $pdf->download('laporan-komisi-editor.pdf');
  }

  public static function export_excel($request)
  {
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    $data = self::getData($start_date, $end_date);

    $object     = new Spreadsheet();
    $object->getProperties()->setCreator(strtoupper('Penjualan'));
    $object->setActiveSheetIndex(0);
    $sheet = $object->getActiveSheet();
    $sheet->setTitle('Laporan Penjualan');

    // $sheet->getColumnDimension('A')->setWidth(100);
    // $sheet->getColumnDimension('B')->setWidth(15);
    // $sheet->getColumnDimension('D')->setWidth(10);

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

    $sheet->setCellValue('A1', 'Nama');
    $sheet->setCellValue('B1', 'Detail buku');
    $sheet->setCellValue('C1', 'Tanggal Komisi');
    $sheet->setCellValue('D1', 'Total');

    $row_number = 2;
    $grand_total = 0;
    foreach ($data as $row) {
      $sheet->setCellValue('A' . $row_number, $row->name);
      $sheet->setCellValue('B' . $row_number, "$row->judul_buku \n $row->penulis_buku");
      $sheet->getStyle('B' . $row_number)->getAlignment()->setWrapText(true);
      $sheet->setCellValue('C' . $row_number, $row->date);
      $sheet->setCellValue('D' . $row_number, $row->amount);

      $object->getActiveSheet()->getStyle('A2:D' . $row_number)->applyFromArray(array(
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
      $grand_total += $row->amount;
    }

    $object->getActiveSheet()->getStyle('E')
      ->getNumberFormat()
      ->setFormatCode('#,##0.00');

    $object->getActiveSheet()->getStyle("A$row_number:E$row_number")->applyFromArray(array(
      'borders' => array(
        'outline' => array(
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => array('argb' => '000000'),
        ),
      ),
    ));
    $sheet->setCellValue('E' . $row_number, $grand_total);

    foreach (range('A', 'E') as $columnID) {
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
        'name'       => 'laporan-komisi-editor-' . date('d-m-Y') . '.xlsx',
        'message'    => "Berhasil Download Data Laporan Komisi Editor",
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
    $roles = auth()->user()->hasRole(['superadmin']);
    $admin_id = !$roles ? (Auth::guard('admin')->user()->id ?? false) : false;

    $query = CommissionHistory::select(
      'admins.*',
      'commission_histories.*',
      'books.judul_buku',
      'books.penulis_buku'
    );
    $query->leftJoinEditor();
    $query->leftJoinEditorBook();
    $query->leftJoinAdmin();
    $query->leftJoinAdminDetail();
    $query->when(($startDate && $endDate), function ($query) use ($startDate, $endDate) {
      $query->whereBetween('commission_histories.created_at', [$startDate, $endDate]);
    });
    $query->when($admin_id, function ($query) use ($admin_id) {
      return $query->where('commission_histories.admin_id', $admin_id);
    });
    return $query->get();
  }
}
