<?php

namespace App\Services\Preference;

use App\Models\Preference;

class PreferenceService
{
  public function index()
  {
    return auth()->user()->preference;
  }

  public function store(array $data)
  {
    $this->cleanData($data);

    return auth()->user()->preference()->create($data);
  }

  public function update(Preference $preference, array $data)
  {
    $this->cleanData($data);

    auth()->user()->preference()->update($data);

    return $preference->fresh();
  }

  private function cleanData(array &$data)
  {
    if (isset($data['age'])) {
      $data['max_age'] = null;
      $data['min_age'] = null;
    } else {
      $data['age'] = null;
    }
  }
}
