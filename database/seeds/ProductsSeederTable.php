<?php

use Illuminate\Database\Seeder;

class ProductsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $count = 100;
        factory(\App\Product::class, $count)->create();
    }
}
