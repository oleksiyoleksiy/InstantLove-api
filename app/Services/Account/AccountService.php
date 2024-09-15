<?php

namespace App\Services\Account;

use App\Enums\TokenAbility;
use App\Http\Requests\Account\RegistrationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;

class AccountService
{
    public function login(array $data)
    {

        $user = User::firstOrCreate(
            ['telegram_id' => $data['id']]
        );


        return $this->createToken($user);
    }

    public function isUserExists(string $telegramId): bool
    {
        return User::where('telegram_id', $telegramId)->exists();
    }

    public function register(array $data)
    {
        $user = User::create($data);

        return $this->createToken($user);
    }

    public function refresh(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());

        $user = $token->tokenable;

        return $this->createToken($user);
    }


    public function createToken(User $user)
    {
        $user->tokens()->delete();

        $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
        $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

        return response()->json([
            'accessToken' => $accessToken->plainTextToken,
            'refreshToken' => $refreshToken->plainTextToken,
        ], Response::HTTP_OK);
    }
}
