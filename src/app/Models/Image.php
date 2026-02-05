<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'library_type',
        'genre_id',
        'memo',
        'original_path',
        'display_path',
        'thumb_path',
        'original_name',
        'mime_type',
        'width',
        'height',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
    ];

    /**
     * Scope a query to only include images of a given library type.
     */
    public function scopeByLibraryType($query, $libraryType)
    {
        return $query->where('library_type', $libraryType);
    }

    /**
     * Get the genre that owns the image.
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Get the tags for the image.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
