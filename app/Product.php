<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //Mass Assigment

    protected $fillable = ['imagePath','title','description','price'];
}
