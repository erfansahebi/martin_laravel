<?php

namespace App\Services;

use App\Exceptions\User\UserNotFoundException;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthService
{

    const TOKEN_NAME = 'UserToken';

    public function __construct ( private readonly \RolePermissionService $rolePermissionService )
    {
    }

    public function login ( string $phoneNumber, string $password ): array
    {
        $user = User::where( 'phone_number', $phoneNumber )->first();
        if ( empty( $user ) || ! $this->checkPassword( password: $password, hashedPassword: $user->password ) )
            throw new UserNotFoundException();

        return [
            'user'  => $user,
            'token' => $user->createToken( self::TOKEN_NAME ),
        ];
    }

    public function logout ( User $user ): bool
    {
        return $user->token()->revoke();
    }

    public function tokenFormatter( PersonalAccessTokenResult $token ): array
    {
        return [
            'accessToken' => $token->accessToken,
            'expires_at'  => $token->token->expires_at,
        ];
    }

    protected function checkPassword ( string $password, string $hashedPassword ): bool
    {
        return \Hash::check( value: $password, hashedValue: $hashedPassword );
    }

}
