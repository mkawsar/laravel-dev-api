<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    public $incrementing = false;

    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'creator_id');
    }


}
