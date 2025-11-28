<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'requires_certification',
        'default_shift_hours',
        'is_active',
    ];

    protected $casts = [
        'requires_certification' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function volunteerOpenings()
    {
        return $this->hasMany(VolunteerOpening::class);
    }
}
