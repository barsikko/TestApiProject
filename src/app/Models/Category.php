<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory/*, SoftDeletes*/;

    protected $fillable = [
    	'name'
    ];

    protected $table = 'categories';

    public function units()
   {
        return $this->belongsToMany(Unit::class, 'category_units');
   }

}
