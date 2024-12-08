<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medicineName',
        'packaging',
        'price',
    ];

    protected $hidden = [];

    public function medicine_examination()
    {
        return $this->belongsToMany(Examination::class, 'examination_details', 'medicines_id', 'examinations_id')->withTimestamps();
    }

    // use HasFactory;
}
