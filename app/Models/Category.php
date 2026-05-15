<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $table = 'categories';

    // Allowed Fields: Kolom yang diizinkan untuk diisi (Poin 2 UTS)
    protected $fillable = [
        'name', 
        'image'
    ];
}