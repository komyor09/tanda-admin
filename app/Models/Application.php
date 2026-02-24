<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'institution_id',
        'name',
        'phone',
        'email',
        'message',
        'status',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
