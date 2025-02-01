<?php

namespace App\Jobs;

use App\Models\SalesOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SalesOrderTrackingJob implements ShouldQueue
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


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sales_order_id = $this->sales_order_id;
        $sales_order = SalesOrder::find($sales_order_id);
    }
}
