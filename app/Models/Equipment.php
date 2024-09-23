<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'equipment';
    protected $guarded = [];

    public function sumber_data()
    {
        return $this->belongsTo(SumberData::class, 'sumbers_id', 'id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuans_id', 'id');
    }
}
