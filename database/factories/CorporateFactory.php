<?php

namespace Database\Factories;

use App\Models\Corporate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Corporate>
 */
class CorporateFactory extends Factory
{
    protected $model = Corporate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition (): array
    {
        $company_name = fake()->unique()->company();

        return [
            'name'             => $company_name,
            'web_hook_address' => $this->generateWebHookAddress( companyName: $company_name ),
        ];
    }

    private function generateWebHookAddress ( string $companyName ): string
    {
        return sprintf( 'http://127.0.0.1/web-hook/%s', strtolower( str_replace( search: '--', replace: '-', subject: str_replace( search: [
            ' ',
            "'",
            ','
        ], replace: '-', subject: $companyName ) ) ) );
    }

}
