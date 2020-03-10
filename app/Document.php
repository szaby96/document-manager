<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function updatedBy(){
        return $this->belongsTo('App\User');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'category_user')->withPivot('update', 'download');
    }
}
