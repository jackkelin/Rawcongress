<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = ['cid', 'organization_name', 'cycle', 'notice', 'total', 'pacs', 'indivs'];
}
