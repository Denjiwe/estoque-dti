<?php

namespace Database\Seeders;

use App\Models\LocalImpressora;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalImpressoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LocalImpressora::factory()->count(50)->create();
    }
}
