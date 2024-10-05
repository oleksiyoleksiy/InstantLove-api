<?php

namespace App\Services\Profile;

use App\Models\Profile;
use App\Services\ProfileImage\ProfileImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function __construct(private ProfileImageService $imageService) {}

    public function index()
    {
        return auth()->user()->profile;
    }

    public function store(array $data)
    {
        $profile = auth()->user()->profile()->create([
            'name' => $data['name'],
            'age' => $data['age'],
            'location' => $data['location'],
            'gender' => $data['gender']
        ]);


        $this->imageService->store($profile, $data['images']);

        return $profile;
    }

    public function update(Profile $profile, array $data)
    {
        $profile->update([
            'name' => $data['name'],
            'age' => $data['age'],
            'location' => $data['location'],
            'gender' => $data['gender']
        ]);

        return $profile->fresh();
    }

    // private function storeImages(array $images)
    // {
    //     $imagePaths = array_map(fn($image) => $image->store('images'), $images);
    //     $imageNames = array_map(fn($path) => explode('/', $path)[1], $imagePaths);
    //     return implode(',', $imageNames);
    // }
}
