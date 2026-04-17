<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentGeneration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content_type',
        'topic',
        'keywords',
        'audience',
        'tone',
        'instructions',
        'generated_content',
        'word_count',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getExcerptAttribute(): string
    {
        return \Str::limit(strip_tags($this->generated_content), 150);
    }
}