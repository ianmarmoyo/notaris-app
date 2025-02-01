<?php

namespace Database\Seeders;

use App\Models\MasterWorkOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterWorkOrderSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $wo = json_decode(file_get_contents(database_path('datas/master_wo.json')));
    foreach ($wo as $data) {
      DB::beginTransaction();
      $wo = MasterWorkOrder::updateOrCreate([
        'slug' => isset($data->slug) ? $data->slug : Str::slug(strtolower($data->nama), '_')
      ], [
        'nama' => $data->nama,
        'slug' => isset($data->slug) ? $data->slug : Str::slug(strtolower($data->nama), '_')
      ]);
      if (!$wo) {
        DB::rollBack();
      }
      DB::commit();
    }
  }
}
