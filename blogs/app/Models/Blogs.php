<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Blogs extends Model
{
    
    protected $table = "blogs";
    use HasApiTokens,HasFactory;

    protected $fillable = [
        'title',
        'content',
        'uniq_id',
        'isActive',
    ];
}
