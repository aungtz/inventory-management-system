<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Columns allowed for mass insert/update
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'description',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
