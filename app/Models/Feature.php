<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function plans()
    {
        $this->belongsToMany(Plan::class)->withPivot(['max_amount']);
    }
}
