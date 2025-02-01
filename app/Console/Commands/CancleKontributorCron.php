<?php

namespace App\Console\Commands;

use App\Actions\OrderBabRefundAction;
use App\Enums\StatusOrderKontributorEnum;
use App\Models\OrderBabManual;
use App\Models\OrderBabRefund;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CancleKontributorCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kontributor:cancle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
        Jika kontributo tidak mengirimkan file, 
        hingga deadline maka cancel, 
        dan bisa order kontributor lagi
    ';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info("Schedule Kontributor cancel" . date('Y-m-d H:i:s'));

        // *jika file masih kosong sampai dengan masa deadline maka cancel
        $kontributor = OrderBabManual::with('detail_book', 'user.user_detail')
            ->whereHas('detail_book', function ($query) {
                $query->where(function ($query) {
                    $query->whereNull('file_detail')
                        ->orWhere('file_detail', '');
                })
                    ->orWhere(function ($query) {
                        $query->whereNull('file_turtini')
                            ->orWhere('file_turtini', '');
                    });
            })
            ->where(function ($query) {
                $query->where('status_order', 'verified')
                    ->where('tgl_selesai_bab', '<=', Carbon::now());
            })
            ->first();

        if ($kontributor) {
            $kontributor->update([
                'status_order' => StatusOrderKontributorEnum::CANCEL
            ]);
            $kontributor->detail_book->update([
                'user_id' => null
            ]);

            (new OrderBabRefundAction)::handle($kontributor);
        }

        // * Jika pesanan belum dibayar sampai jatu tempo
        $payment_is_duedate = OrderBabManual::with('detail_book')->where('status_order', 'pending')
            ->where('tgl_checkout_akhir', '<=', Carbon::now())
            ->first();
        if ($payment_is_duedate) {
            $payment_is_duedate->update([
                'status_order' => StatusOrderKontributorEnum::CANCEL
            ]);
            $payment_is_duedate->detail_book->update([
                'user_id' => null
            ]);
        }
    }
}
