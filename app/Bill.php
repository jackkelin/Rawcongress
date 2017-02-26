<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model {
    protected $fillable = [
        'bill_num',
        'bill_uri',
        'bill_title',
        'bill_intro_date',
        'bill_cosponsors',
        'bill_sponsor_id',
        'bill_committees',
        'bill_latest_major_action_date',
        'bill_latest_major_action',
        'bill_congress_term',
        'bill_chamber'
    ];
}
