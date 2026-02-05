<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'library_type',
        'name',
    ];

    /**
     * Scope a query to only include tags of a given library type.
     */
    public function scopeByLibraryType($query, $libraryType)
    {
        return $query->where('library_type', $libraryType);
    }

    /**
     * Get the images for the tag.
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class);
    }
}
