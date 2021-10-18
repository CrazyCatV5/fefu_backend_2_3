<?php

namespace Database\Seeders;
use App\Models\News1;
use Illuminate\Database\Seeder;

class News1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        News1::query()->delete();
        News1::factory(rand(10, 25))->create();
    }
}
