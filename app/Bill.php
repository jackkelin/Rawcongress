<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model {
    protected $fillable = [
    'bill_number', 
    'bill_uri',
    'title', 
    'introduced_date', 
    'cosponsors', 
    'committees', 
    'latest_major_action_date', 
    'latest_major_action'
    ];
}
