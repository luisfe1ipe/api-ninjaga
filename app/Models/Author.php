<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'avatar',
        'wallpaper',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'author_project');
    }
}
