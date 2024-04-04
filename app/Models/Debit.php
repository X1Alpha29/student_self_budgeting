<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'details', 'category', 'amount', 'reoccurance_date', 'user_id'];

    protected $dates = ['reoccurance_date'];
}
