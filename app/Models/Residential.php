<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residential extends Model
{
    use HasFactory;
    protected $fillable = [    
        'image',
        'location',
        'type',
        'size',
        'description',
        'no_of_rooms',
        'price',
        'agent_id'
    ];

    public function agent() {
        return $this->belongsTo('App\Models\Agent');
    }

}
