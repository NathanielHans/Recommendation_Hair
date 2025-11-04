<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feedback_system extends Model
{
    /** @use HasFactory<\Database\Factories\FeedbackSystemFactory> */
    use HasFactory;
    protected $fillable = ['precision'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
