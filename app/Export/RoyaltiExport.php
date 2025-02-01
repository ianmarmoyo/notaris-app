<?php

namespace App\Export;

use App\Models\AffiliateRewards;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RoyaltiExport
{
  public static function export_pdf($request)
  {
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    $data = self::getData($start_date, $end_date);
    // return $data;
    $pdf = Pdf::loadView('content.reportroyalti.export_pdf', ['data' => $data])
      ->setPaper('a4', 'landscape')
      ->setWarnings(false);
    return $pdf->download('laporan-royalti.pdf');
  }

  public static function export_excel($request)
  {
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    $data = self::getData($start_date, $end_date);

    $object     = new Spreadsheet();
    $object->getProperties()->setCreator(strtoupper('Royalti'));
    $object->setActiveSheetIndex(0);
    $sheet = $object->getActiveSheet();
    $sheet->setTitle('Laporan Royalti');

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
    $sheet->setCellValue('C1', 'Penulis Buku');
    $sheet->setCellValue('D1', 'Tanggal Komisi');
    $sheet->setCellValue('E1', 'Total');

    $row_number = 2;
    $grand_total = 0;
    foreach ($data as $row) {
      $sheet->setCellValue('A' . $row_number, $row->reference_order);
      // $sheet->setCellValue('B' . $row_number, $row->judul_buku);

      if ($row->sales_order) {

        $first_row = $row_number;
        foreach ($row->sales_order->sales_order_items as $key => $item) {
          $sheet->setCellValue('B' . $row_number, $item->book->judul_buku);
          $sheet->setCellValue('C' . $row_number, $item->book->penulis_buku);
          // $row_number++;
        }
        $last_row = $row_number;

        $object->getActiveSheet()->mergeCells('A' . $first_row . ':' . 'A' . $last_row);
        $object->getActiveSheet()->mergeCells('D' . $first_row . ':' . 'D' . $last_row);
        $object->getActiveSheet()->mergeCells('E' . $first_row . ':' . 'E' . $last_row);
      }

      // dd($row_number - 1);
      $sheet->setCellValue('D' . $row_number - 1, $row->date_rewards);
      $sheet->setCellValue('E' . $row_number - 1, $row->total);

      $object->getActiveSheet()->getStyle('A2:E' . $row_number)->applyFromArray(array(
        'borders' => array(
          'outline' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => '000000'),
          ),
        ),
      ));
      $object->getActiveSheet()->getStyle('E' . $row_number)
        ->getNumberFormat()
        ->setFormatCode('#,##0.00');
      $row_number++;
      $grand_total += $row->total;
    }

    $object->getActiveSheet()->getStyle('E')
      ->getNumberFormat()
      ->setFormatCode('#,##0.00');

    $sheet->getStyle('A1:' . 'E' . $sheet->getHighestRow())
      ->getBorders()
      ->getAllBorders()
      ->setBorderStyle(Border::BORDER_THIN);

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
        'name'       => 'laporan-royalti-' . date('d-m-Y') . '.xlsx',
        'message'    => "Berhasil Download Data Laporan Royalti",
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
    $query = AffiliateRewards::with('sales_order', 'order_bab_manual.detail_book.book')->select(
      'sales_orders.order_no',
      'order_bab_manuals.invoice',
      'user_details.nama_lengkap',
      'affiliate_rewards.*',
      DB::raw("(
        SELECT
        SUM(amount)
        FROM
        affiliate_rewards_details
        WHERE affiliate_rewards_id = affiliate_rewards.id
      ) as total")
    );
    $query->leftJoinSalesOrder();
    $query->leftJoin(
      'sales_order_items',
      'sales_orders.id',
      'sales_order_items.sales_order_id'
    );
    $query->leftJoin(
      'books',
      'sales_order_items.book_id',
      'books.id'
    );
    $query->leftJoinUser();
    $query->leftJoinUserDetail();
    $query->leftJoin(
      'order_bab_manuals',
      'affiliate_rewards.reference_order',
      'order_bab_manuals.invoice'
    );
    $query->leftJoin(
      'book_details',
      'order_bab_manuals.book_detail_id',
      'book_details.id'
    );
    $query->leftJoin(
      'books as books2',
      'book_details.book_id',
      'books2.id'
    );
    $query->when(($startDate && $endDate), function ($query) use ($startDate, $endDate) {
      $query->whereBetween('affiliate_rewards.date_rewards', [$startDate, $endDate]);
    });
    $query->whereHas('affiliate_reward_details', function ($q) {
      $q->where('reward_for', 'penulis');
    });
    $query->groupBy(
      // 'affiliate_rewards.order_no'
      'affiliate_rewards.id',
      'affiliate_rewards.reference_order',
      'affiliate_rewards.date_rewards',
      'affiliate_rewards.created_at',
      'affiliate_rewards.updated_at',
      'sales_orders.order_no',
      'order_bab_manuals.invoice',
      'user_details.nama_lengkap'
    );
    return $query->get();
  }
}
