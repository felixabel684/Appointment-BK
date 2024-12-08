<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExaminationDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'examinations_id', 'medicines_id',
    ];

    protected $hidden = [

    ];

    public function examination_detail()
    {
        return $this->hasMany(Examination::class, 'examinations_id', 'id');
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class, 'medicines_id', 'id');
    }

    // use HasFactory;
}
