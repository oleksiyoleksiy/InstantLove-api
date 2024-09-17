<?php

namespace App\Services\Profile;

use App\Models\Profile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function index()
    {
        return auth()->user()->profile;
    }

    public function store(array $data)
    {
        $imagePaths = array_map(fn($image) => $image->store(), $data['images']);

        $images = implode(',', $imagePaths);

        $profile = auth()->user()->profile()->create([
            'name' => $data['name'],
            'age' => $data['age'],
            'location' => $data['location'],
            'images' => $images,
            'gender' => $data['gender']
        ]);

        return $profile;
    }

    public function update(array $data, Profile $profile)
    {
        if (isset($data['images'])) {
            $oldImages = explode(',', $profile->images);
            foreach ($oldImages as $oldImage) {
                Storage::delete($oldImage);
            }

            $imagePaths = array_map(fn($image) => $image->store(), $data['images']);
            $images = implode(',', $imagePaths);
        } else {
            $images = $profile->images;
        }

        $profile->update([
            'name' => $data['name'],
            'age' => $data['age'],
            'location' => $data['location'],
            'images' => $images,
            'gender' => $data['gender']
        ]);

        return $profile;
    }
}
