<?php

namespace App\Services\ProfileImage;

use App\Models\Image;
use App\Models\Profile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileImageService
{
    public function store(Profile $profile, array $images)
    {
        collect($images)->each(function (UploadedFile $image) use ($profile) {
            $path = $image->store('images');
            $profile->images()->create(['path' => explode('/', $path)[1]]);
        });

        return $profile;
    }

    public function delete(Profile $profile, Image $image)
    {
        Storage::delete("/images/$image->path");

        $image->delete();

        return $profile;
    }
}
