<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function children(){
        return $this->hasMany('App\Category', 'parent_category_id', 'id');
    }

    public function documents(){
        return $this->hasMany('App\Document');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'category_user')->withPivot('update', 'download');
    }
}
