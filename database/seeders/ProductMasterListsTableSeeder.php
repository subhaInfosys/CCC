<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductMasterListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();

        $products = [
            [
                'ProductID'  => 4450,
                'Types'      => 'Smartphone',
                'Brand'      => 'Apple',
                'Model'      => 'Phone SE',
                'Capacity'   => '2GB/16GB',
                'Quantity'   => 13,
                'created_at' => $dateNow,
                'updated_at' => $dateNow
            ],
            [
                'ProductID'  => 4768,
                'Types'      => 'Smartphone',
                'Brand'      => 'Apple',
                'Model'      => 'Phone SE',
                'Capacity'   => '2GB/32GB',
                'Quantity'   => 30,
                'created_at' => $dateNow,
                'updated_at' => $dateNow
            ],
            [
                'ProductID'  => 4451,
                'Types'      => 'Smartphone',
                'Brand'      => 'Apple',
                'Model'      => 'Phone SE',
                'Capacity'   => '2GB/64GB',
                'Quantity'   => 20,
                'created_at' => $dateNow,
                'updated_at' => $dateNow
            ],
            [
                'ProductID'  => 4574,
                'Types'      => 'Smartphone',
                'Brand'      => 'Apple',
                'Model'      => 'Phone SE',
                'Capacity'   => '2GB/128GB',
                'Quantity'   => 16,
                'created_at' => $dateNow,
                'updated_at' => $dateNow
            ],
            [
                'ProductID'  => 6039,
                'Types'      => 'Smartphone',
                'Brand'      => 'Apple',
                'Model'      => 'Phone SE (2020)',
                'Capacity'   => '3GB/64GB',
                'Quantity'   => 18,
                'created_at' => $dateNow,
                'updated_at' => $dateNow
            ]
        ];

        Product::insert($products);
    }
}