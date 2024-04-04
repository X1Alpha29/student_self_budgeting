<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'expense_name', 'category', 'amount', 'date', 'notes',
    ];
    use HasFactory;

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}