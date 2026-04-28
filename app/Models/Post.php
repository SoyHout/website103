<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
class Post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title','sub_title','description','content','image','active',
    ];

    // protected static function booted(){
    //     static::creating(function($model){
    //         if(Auth::check()){
    //             $model->created_by = Auth::id();
    //         }
    //     });
    //     static::creating(function($model){
    //         if(Auth::check()){
    //             $model->created_by = Auth::id();
    //         }
    //     });
    //     static::creating(function($model){
    //         if(Auth::check()){
    //             $model->created_by = Auth::id();
    //         }
    //     });
    // }
}
