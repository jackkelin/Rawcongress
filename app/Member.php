<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['first_name', 'last_name', 'middle_name', 'party', 'state', 'next_election'];
}
