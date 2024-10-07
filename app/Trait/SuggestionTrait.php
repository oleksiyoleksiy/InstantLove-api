<?php

namespace App\Trait;

use App\Models\Profile;
use Illuminate\Support\Collection;

trait SuggestionTrait
{
    public function suggestions(): Collection
    {
        $user = $this;
        $preferences = $user->preference->fresh();
        $profile = $user->profile;
        $query = Profile::whereNot('user_id', auth()->id())
            ->where('location', $profile->location);

        if ($preferences->gender !== 'all') {
            $query->where('gender', $preferences->gender);
        }

        if ($preferences->age) {
            $query->where('age', $preferences->age);
        }

        if ($preferences->min_age && $preferences->max_age) {
            $query->whereBetween('age', [$preferences->min_age, $preferences->max_age]);
        }

        return $query->get();
    }
}
