<?php

namespace App\Jobs;

use App\Models\AffiliateRewards;
use App\Models\AffiliateRewardsDetail;
use App\Models\BookDetail;
use App\Models\OrderBabManual;
use App\Models\UserDetail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RewardKontributorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order_bab_manual_id;

    /**
     * Create a new job instance.
     */
    public function __construct($order_bab_manual_id)
    {
        $this->order_bab_manual_id = $order_bab_manual_id;
    }

    /**
     * Execute the job.
     * Ebook 100rb
     * Affiliate 
     * A = 10%, 10rb
     * penulis 20%, 20rb
     * 20rb dibagi jumlah penulis mas. Kalau ada 5 penulis
     * Berrti 20rb:5 penulis.
     * Masing" dapat 4rb
     */

    //      Ebook 100rb

    // Affiliate 
    // A = 10%, 10rb

    // penulis 20%, 20rb
    // B = 20% x 20rb
    // C = 20% x 20rb
    // D = 20% x 20rb

    public function handle(): void
    {
        $order_bab_manual_id = $this->order_bab_manual_id;
        $order_bab_manual = OrderBabManual::with(
            'user.user_detail',
            'detail_book'
        )->find($order_bab_manual_id);

        DB::beginTransaction();
        try {
            //! Insert Rewards untuk affilate
            $kode_affiliate = $order_bab_manual->user->user_detail->referal_from;
            $getUserAffiliate = UserDetail::with('tier_affiliate')
                ->whereRaw('BINARY `kode_referal` = ?', [$kode_affiliate])
                ->first();
            Log::info('REWARD KONTRIBUTOR JIB', [$kode_affiliate, $getUserAffiliate, $order_bab_manual_id]);
            if ($getUserAffiliate) {
                // insert data affiliate rewards
                $AffiliateRewards = AffiliateRewards::create([
                    'reference_order' => $order_bab_manual->invoice,
                ]);

                $percentage_reward = $getUserAffiliate->tier_affiliate->percentage ?? config('enums.persentage_rewards_affiliate');
                $amount_rewards = ($percentage_reward / 100) * ($order_bab_manual->total_amount_order - $order_bab_manual->total_discount);
                $insertAffiliateRewardsDetail = [
                    'affiliate_rewards_id' => $AffiliateRewards->id,
                    'user_id' => $getUserAffiliate->user_id,
                    'amount' => $amount_rewards,
                    'note' => 'Ini komisi untuk affiliate',
                    'reward_for' => 'affiliate'
                ];
                // * Update Saldo wallet to user
                $getUserAffiliate->update([
                    'saldo_wallet' => DB::raw("saldo_wallet + $amount_rewards")
                ]);
                $affiliate = AffiliateRewardsDetail::create($insertAffiliateRewardsDetail);
                if (!$affiliate) {
                    Log::channel('affiliate_rewards')->info('ISSUE REWARD KONTRIBUTOR===', [$affiliate]);
                }
            }

            // ! Reward untuk penulis/kontributor
            // $book_id = $order_bab_manual->detail_book->book_id;
            // $getKontributor = BookDetail::with('user', 'order_bab_manual')
            //     ->whereHas('order_bab_manual', function ($query) {
            //         $query->where('status_order', 'verified');
            //     })
            //     ->where('book_id', $book_id)
            //     ->get();

            // if (count($getKontributor) > 0) {
            //     $amount_rewards_kontributor = 0;
            //     foreach ($getKontributor as $kontributor) {

            //         $percentage_reward_kontributor = $kontributor->user->user_detail->tier_affiliate->percentage ?? config('enums.persentage_rewards_kontributor');

            //         $amount_rewards_kontributor = ($percentage_reward_kontributor / 100) * ($order_bab_manual->total_amount_order - $order_bab_manual->total_discount);

            //         $amount_rewards_kontributor = $amount_rewards_kontributor / count($getKontributor);

            //         $insertKontributorRewardsDetail = [
            //             'affiliate_rewards_id' => $AffiliateRewards->id,
            //             'user_id' => $kontributor->user_id,
            //             'amount' => $amount_rewards_kontributor,
            //             'note' => 'Ini komisi untuk kontributor',
            //             'reward_for' => 'penulis'
            //         ];
            //         // * Update Saldo wallet to user
            //         $kontributor->user->user_detail->update([
            //             'saldo_wallet' => DB::raw("saldo_wallet + $amount_rewards_kontributor")
            //         ]);
            //         $affiliate_detail = AffiliateRewardsDetail::create($insertKontributorRewardsDetail);
            //         if (!$affiliate_detail) {
            //             Log::channel('affiliate_detail_rewards')->info('ISSUE REWARD KONTRIBUTOR===', [$affiliate]);
            //         }
            //     }
            // }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::channel('affiliate_rewards')->info('ISSUE REWARD KONTRIBUTOR===', [$e->getMessage()]);
        }
    }
}
