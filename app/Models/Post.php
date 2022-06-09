<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'author_id',
        'title',
        'description',
        'tags',
        'post_date'
    ];

    protected $casts = [
        'tags' => 'array',
        'post_date' => 'date',
    ];

    public function comments(){
        return $this->hasMany(Comment::class)->orderBy('created_at','DESC');
    }

    public function user(){
        return $this->belongsTo(User::class,'author_id','id');
    }
}
