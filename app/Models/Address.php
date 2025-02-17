<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'street',
        'number',
        'neighborhood',
        'complement',
        'zip_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
