<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class VehicleType extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vechileTypes';

    use HasFactory;
}
