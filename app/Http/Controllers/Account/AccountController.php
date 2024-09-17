<?php

namespace App\Http\Controllers\Account;

use App\DTO\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\LoginRequest;
use App\Http\Requests\Account\RegistrationRequest;
use App\Http\Requests\Account\TelegramRequest;
use App\Services\Account\AccountService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccountController extends Controller
{
    public function __construct(private AccountService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (!auth()->attempt($data)) {
            return response()->json(['message' => 'authorization failed'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->service->login($data);
    }
    public function register(RegistrationRequest $request)
    {
        $data = $request->validated();

        return $this->service->register($data);
    }


    public function isUserExists(TelegramRequest $request)
    {
        $data = $request->validated();

        $isUserExists = $this->service->isUserExists($data['telegram_id']);

        return response()->json(['is_user_exists' => $isUserExists], Response::HTTP_OK);
    }

    public function refresh(Request $request)
    {
        return $this->service->refresh($request);
    }

    public function logout()
    {
        $this->service->logout();

        return response()->noContent();
    }
}
