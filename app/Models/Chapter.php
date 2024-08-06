<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter',
        'volume_id'
    ];

    public function volume(): BelongsTo
    {
        return $this->belongsTo(Volume::class);
    }
}
