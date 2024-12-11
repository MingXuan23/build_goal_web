<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    protected $dates = ['datetime_created' ,'transaction_balance_id'];

}