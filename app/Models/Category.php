<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'duration', 'amount', 'from_date', 'to_date',];
    use HasFactory;

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function finance()
    {
        return $this->belongsTo(Finance::class);
    }

}
