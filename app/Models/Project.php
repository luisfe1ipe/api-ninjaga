<?php

namespace App\Models;

use App\Enums\StatusProjectEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'synopsis',
        'image',
        'published_at',
        'views',
        'rating',
        'status',
        'type_id',
    ];

    protected function casts():array
    {
        return [
            'status' => StatusProjectEnum::class,
        ];
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_project');
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_project');
    }

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'artist_project');
    }

    public function volumes(): HasMany
    {
        return $this->hasMany(Volume::class);
    }
}
