<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'amount', 'date', 'payback_deadline', 'notes', 'user_id'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function finance()
    {
        return $this->belongsTo(Finance::class);
    }

}
