<?php

namespace App\GraphQL\Mutations;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;
use DanielDeWit\LighthouseSanctum\Exceptions\HasApiTokensException;
use DanielDeWit\LighthouseSanctum\Traits\HasUserModel;

/**
 * Override the original class because that always expects an email & password combination
 * Shoutz0r however uses a username & password combination
 */
class Login extends \DanielDeWit\LighthouseSanctum\GraphQL\Mutations\Login
{
    use HasUserModel;

    /**
     * @param mixed $_
     * @param array<string, string> $args
     * @return string[]
     * @throws Exception
     */
    public function __invoke($_, array $args): array
    {
        $userProvider = $this->createUserProvider();

        $user = $userProvider->retrieveByCredentials([
            'username' => $args['username'],
            'password' => $args['password'],
        ]);

        if (!$user || !$userProvider->validateCredentials($user, $args)) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            throw new AuthenticationException('Your email address is not verified.');
        }

        if (!$user instanceof HasApiTokens) {
            throw new HasApiTokensException($user);
        }

        return [
            'userId' => $this->getModelFromUser($user)->id,
            'token' => $user->createToken('default')->plainTextToken,
        ];
    }

}
