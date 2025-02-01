<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateRaporSiswaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $institution_id, $kelas_id;

    /**
     * Create a new job instance.
     */
    public function __construct($institution_id, $kelas_id)
    {
        $this->institution_id = $institution_id;
        $this->kelas_id = $kelas_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
