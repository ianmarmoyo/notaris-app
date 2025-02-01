<?php

namespace App\Export;

use App\Models\OrderBabManual;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KolaborasiExport
{
  public static function export_pdf($request)
  {
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    $data = self::getData($start_date, $end_date);
    // dd($data);
    $pdf = Pdf::loadView('content.reportkolaborasi.export_pdf', ['data' => $data])
      ->setPaper('a4', 'landscape')
      ->setWarnings(false);
    return $pdf->download('laporan-kontibutor.pdf');
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

    $sheet->setCellValue('A1', 'No Penjualan');
    $sheet->setCellValue('B1', 'Judul Buku');
    $sheet->setCellValue('C1', 'Bagian Bab');
    $sheet->setCellValue('D1', 'Judul Bab');
    $sheet->setCellValue('E1', 'Penulis Buku');
    $sheet->setCellValue('F1', 'Tanggal Pembelian');
    $sheet->setCellValue('G1', 'Total');

    $row_number = 2;
    $grand_total = 0;
    foreach ($data as $row) {
      $sheet->setCellValue('A' . $row_number, $row->invoice);
      $sheet->setCellValue('B' . $row_number, $row->judul_buku);
      $sheet->setCellValue('C' . $row_number, $row->bagian_detail);
      $sheet->setCellValue('D' . $row_number, $row->judul_detail);
      $sheet->setCellValue('E' . $row_number, $row->penulis_buku);
      $sheet->setCellValue('F' . $row_number, $row->tgl_checkout);
      $sheet->setCellValue('G' . $row_number, $row->total_bayar);

      $object->getActiveSheet()->getStyle('A2:G' . $row_number)->applyFromArray(array(
        'borders' => array(
          'outline' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => '000000'),
          ),
        ),
      ));
      $object->getActiveSheet()->getStyle('G' . $row_number)
        ->getNumberFormat()
        ->setFormatCode('#,##0.00');
      $row_number++;
      $grand_total += $row->total_bayar;
    }

    $object->getActiveSheet()->getStyle('G')
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
    $sheet->setCellValue('G' . $row_number, $grand_total);

    foreach (range('A', 'G') as $columnID) {
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
        'name'       => 'laporan-kolaborasi-' . date('d-m-Y') . '.xlsx',
        'message'    => "Berhasil Download Data Laporan Kolaborasi",
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
    $query = OrderBabManual::select(
      'order_bab_manuals.id AS order_bab_menual_id',
      'order_bab_manuals.*',
      'book_details.*',
      'user_details.nama_lengkap',
      'books.judul_buku',
      'books.foto_buku',
      'books.penulis_buku',
    );
    $query->leftJoinUser();
    $query->leftJoinUserDetail();
    $query->leftJoinBookDetail();
    $query->leftJoinBook();
    $query->when(($startDate && $endDate), function ($query) use ($startDate, $endDate) {
      $query->whereBetween('order_bab_manuals.created_at', [$startDate, $endDate]);
    });
    $query->where('order_bab_manuals.status_order', 'verified');
    $query->orderBy('order_bab_manuals.created_at', 'DESC');
    return $query->get();
  }
}
