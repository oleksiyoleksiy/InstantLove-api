<?php

namespace App\Http\Controllers\ProfileImage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ProfileResource;
use App\Models\Image;
use App\Models\Profile;
use App\Services\ProfileImage\ProfileImageService;
use Illuminate\Http\Request;

class ProfileImageController extends Controller
{
    public function __construct(private ProfileImageService $service) {}


    public function store(ImageRequest $request, Profile $profile)
    {
        $data = $request->validated();

        return ProfileResource::make($this->service->store($profile, $data['images']));
    }


    public function destroy(Profile $profile, Image $image)
    {
        return ProfileResource::make($this->service->delete($profile, $image));
    }
}
