<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BloodTypeTransfusionPoint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['transfusion_point_id', 'blood_type_id', 'quantity'];
}
