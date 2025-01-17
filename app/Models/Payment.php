<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'imagePayment',
        'status',
        'examinations_id',
    ];

    protected $hidden = [];

    public function payment()
    {
        return $this->belongsTo(Examination::class, 'examinations_id', 'id');
    }

    // use HasFactory;
}
