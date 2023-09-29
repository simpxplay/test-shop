<?php

namespace App\Traits;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ProductRelationTrait
{
    public function file(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
