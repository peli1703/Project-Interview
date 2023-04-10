<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
  
    protected $fillable =[
        'interview_id',
        'status',
        'date',
    ];

    public function Interview ()
    {
        //belongsto : disambungkan dengan table nama(PKnya ada dimaana)
        // table yang berperan sebagai FK
        // nama fungsi == nama model PK
        return $this->belongsTo
        (Interview::class);
    }
}
