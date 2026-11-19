<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItem extends Model
{
    use HasFactory;
    protected $fillable = ["foto"];

    use SoftDeletes;

    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_master_item');
    }
}
