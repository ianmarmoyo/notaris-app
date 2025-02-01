<?php

namespace App\Jobs;

use App\Models\AffiliateRewards;
use App\Models\AffiliateRewardsDetail;
use App\Models\BookDetail;
use App\Models\OrderBabManual;
use App\Models\SalesOrder;
use App\Models\UserDetail;
use App\Models\WalletBalanceMovement;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesAffiliateRewardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sales_order_id;

    /**
     * Create a new job instance.
     */
    public function __construct($sales_order_id)
    {
        $this->sales_order_id = $sales_order_id;
    }

    public function handle(): void
    {
        $sales_order_id = $this->sales_order_id;
        $sales_order = SalesOrder::find($sales_order_id);

        $amount_rewards = 0;
        DB::beginTransaction();
        try {
            /**
             * jika user (ian) 'pembeli', memiliki kode refereal dari user lain (adi),
             * maka user (adi) dapat reward dari pembelian user (ian)
             * 
             */
            //! Insert Rewards untuk affilate
            $kode_affiliate = $sales_order->user->user_detail->referal_from;
            $getUserAffiliate = UserDetail::with('tier_affiliate')
                ->whereRaw('BINARY `kode_referal` = ?', [$kode_affiliate])
                ->first();
            if ($getUserAffiliate) {
                //* insert data affiliate rewards
                $AffiliateRewards = AffiliateRewards::create([
                    'reference_order' => $sales_order->order_no,
                ]);

                $percentage_reward = $getUserAffiliate->tier_affiliate->percentage ?? config('enums.persentage_rewards_affiliate');
                $amount_rewards = ($percentage_reward / 100) * ($sales_order->total_amount_order - $sales_order->total_discounts);
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
                AffiliateRewardsDetail::create($insertAffiliateRewardsDetail);
                WalletBalanceMovement::create([
                    'type_user' => 'member',
                    'unique_user' => $getUserAffiliate->user_id,
                    'amount' => $amount_rewards,
                    'note' => "Komisi untuk affiliate (#$sales_order->order_no)",
                    'type_balance' => 'in'
                ]);
            }

            // ! Reward untuk penulis/kontributor
            $book_ids = $sales_order->sales_order_items->pluck('book_id')->toArray();
            $getKontributor = BookDetail::with('user', 'order_bab_manual')
                ->whereHas('order_bab_manual', function ($query) {
                    $query->where('status_order', 'verified');
                })
                ->whereIn('book_id', $book_ids)
                ->get();

            if (count($getKontributor) > 0) {
                /**
                 * 
                 * jika user ian melakukan pembelian buku, dan buku tersebut memiliki penulis/kontributor 
                 * maka semua penulis dapat reward
                 */
                // * Jika Affiliate tidak ada
                if (!$getUserAffiliate) {
                    $AffiliateRewards = AffiliateRewards::create([
                        'reference_order' => $sales_order->order_no,
                    ]);
                }

                $amount_rewards_kontributor = 0;
                foreach ($getKontributor as $kontributor) {

                    $percentage_reward_kontributor = config('enums.persentage_rewards_kontributor');

                    $amount_rewards_kontributor = ($percentage_reward_kontributor / 100) * ($sales_order->total_amount_order - $sales_order->total_discounts);

                    $amount_rewards_kontributor = $amount_rewards_kontributor / count($getKontributor);

                    $insertKontributorRewardsDetail = [
                        'affiliate_rewards_id' => $AffiliateRewards->id,
                        'user_id' => $kontributor->user_id,
                        'amount' => $amount_rewards_kontributor,
                        'note' => 'Royalti',
                        'reward_for' => 'penulis'
                    ];
                    // * Update Saldo wallet to user
                    $kontributor->user->user_detail->update([
                        'saldo_wallet' => DB::raw("saldo_wallet + $amount_rewards_kontributor")
                    ]);
                    AffiliateRewardsDetail::create($insertKontributorRewardsDetail);

                    WalletBalanceMovement::create([
                        'type_user' => 'member',
                        'unique_user' => $kontributor->user_id,
                        'amount' => $amount_rewards_kontributor,
                        'note' => "Komisi untuk kontributor (#$sales_order->order_no)",
                        'type_balance' => 'in'
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::channel('affiliate_rewards')->info($e->getMessage());
        }
    }
}
