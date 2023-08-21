<?php

namespace Database\Seeders;

use App\Models\Corporate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorporateSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run (): void
    {
        Corporate::create( [
            'name'             => 'Sample Company',
            'web_hook_address' => 'http://127.0.0.1/web-hook/sample-company',
        ] );

        Corporate::factory()->count( 100 )->create();
    }
}
