<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BloodType extends Model
{
    use HasFactory, SoftDeletes;

    public function transfusionPoints(): BelongsToMany
    {
        return $this->belongsToMany(TransfusionPoint::class, 'blood_type_transfusion_points', 'blood_type_id', 'transfusion_point_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'blood_id', 'id');
    }
}
