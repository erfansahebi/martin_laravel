<?php

namespace Database\Seeders;

use App\Models\Corporate;
use App\Models\CourierLocation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run (): void
    {
        $employee = User::create( [
            'name'         => 'Erfan Sahebi Employee',
            'phone_number' => normalize_phone_number( '09351326358' ),
            'password'     => \Hash::make( '123456789' ),
        ] );
        $employee->Corporates()->sync( Corporate::first() );
        $employee->assignRole( Role::EMPLOYEE );

        $courier = User::create( [
            'name'         => 'Erfan Sahebi Courier',
            'phone_number' => normalize_phone_number( '09853623153' ),
            'password'     => \Hash::make( '123456789' ),
        ] );
        $courier->assignRole( Role::COURIER );
        CourierLocation::create( [
            'lat'             => 35.5501,
            'long'            => 51.5150,
            'courier_user_id' => $courier->id,
        ] );
    }
}
