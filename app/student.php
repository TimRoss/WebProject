<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $fillable = [
        'c',
        'java',
        'python',
        'teamStyle',
        'requestedTeamMember1',
        'requestedTeamMember2'
    ];
}
