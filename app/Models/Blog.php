<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['title','excerpt','content','cover_path','published_at'];
    protected $casts = [
        'published_at' => 'date',
    ];
}