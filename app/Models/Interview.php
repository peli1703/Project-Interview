<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Response;

class Interview extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'age',
        'phone_number',
        'last_education',
        'education_name',
        'cv_file',
    ];

    public function response()
    {
        return $this->hasOne
        (Response::class);
    }
}
