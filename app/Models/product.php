<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = [
        'brand',        // huruf kecil
        'name',
        'price',
        'description',
        'ingredients',
        'link',
    ];
    public function feedbacks()
    {
        return $this->hasMany(feedback_system::class);
    }
}
