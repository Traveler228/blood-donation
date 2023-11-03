<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransfusionPoint extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = false;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'transfusion_point_users', 'transfusion_point_id', 'user_id');
    }

    public function bloodTypes(): BelongsToMany
    {
        return $this->belongsToMany(BloodType::class, 'blood_type_transfusion_points', 'transfusion_point_id', 'blood_type_id');
    }

}
