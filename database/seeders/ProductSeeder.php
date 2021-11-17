<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // removes key checks, it will cause an error during table reset
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        DB::table('products')->delete();

        // reset auto increment to zero
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1;');

        $now = now();

        DB::table('products')
            ->insert(array (
                    [
                        'name' => 'Lazada One',
                        'available_stock' => '100',
                        'created_at' => $now,
                        'updated_at' => $now
                    ],
                    [
                        'name' => 'Lazada Two',
                        'available_stock' => '200',
                        'created_at' => $now,
                        'updated_at' => $now
                    ],
                    [
                        'name' => 'Lazada Three',
                        'available_stock' => '300',
                        'created_at' => $now,
                        'updated_at' => $now
                    ],
                    [
                        'name' => 'Lazada Four',
                        'available_stock' => '400',
                        'created_at' => $now,
                        'updated_at' => $now
                    ],
                    [
                        'name' => 'Lazada Five',
                        'available_stock' => '500',
                        'created_at' => $now,
                        'updated_at' => $now
                    ],
                )
            );

        // enable key checks again
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
