<?php

namespace App\Export;

use App\Models\SalesOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SalesOrderExport
{
  public static function export_pdf($request)
  {
    $start_date = $request->start_date;
    $end_date = $request->end_date;

    $query = SalesOrder::select(
      'user_details.nama_lengkap',
      'sales_orders.*'
    );
    $query->leftJoinUser();
    $query->leftJoinUserDetail();
    $query->when(($start_date && $end_date), function ($query) use ($start_date, $end_date) {
      $query->whereBetween('order_date', [$start_date, $end_date]);
    });
    $query->orderBy('created_at', 'DESC');
    $results = $query->get();

    $pdf = Pdf::loadView('content.reportsalesorder.export_pdf', ['data' => $results]);
    return $pdf->download('sales-order.pdf');
    // return $pdf->stream('sales-order.pdf');
    // return response()->streamDownload(function () use ($pdf) {
    //   echo $pdf->output();
    // }, 'document.pdf');
  }

  public static function export_excel($request)
  {
    $start_date = $request->start_date;
    $end_date = $request->end_date;

    $query = SalesOrder::select(
      'user_details.nama_lengkap',
      'sales_orders.*'
    );
    $query->leftJoinUser();
    $query->leftJoinUserDetail();
    $query->when(($start_date && $end_date), function ($query) use ($start_date, $end_date) {
      $query->whereBetween('order_date', [$start_date, $end_date]);
    });
    $query->orderBy('created_at', 'DESC');
    $results = $query->get();

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

    $sheet->setCellValue('A1', 'Invoice');
    $sheet->setCellValue('B1', 'Member');
    $sheet->setCellValue('C1', 'Tanggal Pembelian');
    $sheet->setCellValue('D1', 'Total');

    $row_number = 2;
    $grand_total = 0;
    foreach ($results as $row) {
      $sheet->setCellValue('A' . $row_number, $row->invoice);
      $sheet->setCellValue('B' . $row_number, $row->nama_lengkap);
      $sheet->setCellValue('C' . $row_number, $row->order_date);
      $sheet->setCellValue('D' . $row_number, $row->grand_total);

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
      $grand_total += $row->grand_total;
    }

    $object->getActiveSheet()->getStyle('D')
      ->getNumberFormat()
      ->setFormatCode('#,##0.00');

    $object->getActiveSheet()->getStyle("A$row_number:D$row_number")->applyFromArray(array(
      'borders' => array(
        'outline' => array(
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => array('argb' => '000000'),
        ),
      ),
    ));
    $sheet->setCellValue('D' . $row_number, $grand_total);

    foreach (range('A', 'D') as $columnID) {
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
    if (count($results) > 0) {
      return response()->json([
        'status'     => true,
        'code'       => 200,
        'name'       => 'laporan-pembelian-' . date('d-m-Y') . '.xlsx',
        'message'    => "Berhasil Download Data Laporan Pembelian",
        'file'         => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($export)
      ], 200);
    } else {
      return response()->json([
        'status'     => false,
        'message'    => "Data tidak ditemukan",
      ], 200);
    }
  }
}
