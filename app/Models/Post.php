<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content',
        'media',
        'category',
        'user_id',
    ];

    protected $casts = [
        'category' => 'string',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
