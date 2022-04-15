<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    //新規登録する際の情報 null可の項目はいれない
    protected $fillable = [
        'user_id',
        'event_id',
        'max_people',
        'number_of_people',
    ];

}
