<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Table::insert(
            [
                [
                    'name' => 'Table 1',
                    'pax' => 10,
                    'description' => 'Description Here',
                ],
                [
                    'name' => 'Table 2',
                    'pax' => 10,
                    'description' => 'Description Here',
                ],
                [
                    'name' => 'Table 3',
                    'pax' => 10,
                    'description' => 'Description Here',
                ],
                [
                    'name' => 'Table 4',
                    'pax' => 10,
                    'description' => 'Description Here',
                ],
                [
                    'name' => 'Table 5',
                    'pax' => 10,
                    'description' => 'Description Here',
                ],
            ]
        );
    }
}
