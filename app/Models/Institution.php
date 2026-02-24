<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'slug',
        'city',
        'address',
        'work_hours',
        'format',
        'price_month',
        'description',
        'short_description',
        'languages',
        'photos',
        'status',
        'featured',
        'contact_whatsapp',
        'contact_email',
        'website',
        'lat',
        'lng',
    ];

    protected $casts = [
        'languages' => 'array',
        'photos' => 'array',
        'status' => 'boolean',
        'featured' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
