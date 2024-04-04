<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_type',
        'expected_date',
        'status',
        'amount',
        'notes',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
