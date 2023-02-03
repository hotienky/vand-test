<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::create([
            "store_name" =>  "Store Bình Thạnh",
            "address" =>  "Bình thạnh, tp.hcm",
            "images" =>  "https://www.google.com/url?sa=i&url=https%3A%2F%2Fvietnambiz.vn%2Fhinh-anh-cua-cua-hang-store-image-trong-hanh-vi-khach-hang-la-gi-20191002162851789.htm&psig=AOvVaw3vrRhiBGAjkuyj9eYuLN2W&ust=1675522978575000&source=images&cd=vfe&ved=0CA8QjRxqFwoTCPCAuNHP-fwCFQAAAAAdAAAAABAE"
        ]);

    }
}
