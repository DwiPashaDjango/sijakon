<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;
    protected $table = 'proyeks';
    protected $guarded = [];

    public function sumber_proyek()
    {
        return $this->belongsTo(SumberProyek::class, 'sumbers_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'districts_id', 'id');
    }
}
