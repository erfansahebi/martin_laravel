<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition (): array
    {
        return [
            'name'         => fake()->name(),
            'phone_number' => $this->generatePhoneNumber(),
            'password'     => \Hash::make( value: '123456789' ),
        ];
    }

    public function configure (): Factory|UserFactory
    {
        return $this->afterCreating( function ( User $user ) {

        } );
    }

    private function generatePhoneNumber (): string
    {
        $phone_number = '09';
        for ( $i = 0; $i <= 9; $i ++ )
        {
            $phone_number .= rand( min: 0, max: 9 );
        }

        return normalize_phone_number( phone_number: $phone_number );
    }

}
