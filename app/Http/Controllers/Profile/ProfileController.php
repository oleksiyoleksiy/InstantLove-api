<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileRequest;
use App\Http\Requests\Profile\StoreRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Services\Profile\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $service) {}

    public function index()
    {
        return $this->service->index()
            ? ProfileResource::make($this->service->index())
            : response()->json(['message' => 'user profile not found'], Response::HTTP_NOT_FOUND);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        return ProfileResource::make($this->service->store($data));
    }

    public function update(UpdateRequest $request, Profile $profile)
    {
        $data = $request->validated();

        return ProfileResource::make($this->service->update($profile, $data));
    }
}
