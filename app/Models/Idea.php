<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'improvement', 'benefits',
        'is_published', 'is_featured', 'featured_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured'  => 'boolean',
        'featured_at'  => 'datetime',
    ];

    public function attachments()
    {
        return $this->hasMany(IdeaAttachment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
