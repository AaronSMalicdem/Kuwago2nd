<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            'order_no' => 0,
            'receipt_no' => 0,
            'tin_no' => "0000-0000-0000-0000",
        ]);
    }
}
