<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    use softDeletes;
    protected $fillable = ['title', 'sub_title', 'description', 'active'];

    // protected static function boot(){
    //     parent::boot();
    //     static::creating(function($model){
    //         if(Auth::check()){
    //             $model->created_by = Auth::id();
    //         }
    //     });

    //     static::updating(function($model){
    //         if(Auth::check()){
    //             $model->updated_by = Auth::id();
    //         }
    //     });

    //     static::deleting(function($model){
    //         if(Auth::check()){
    //             $model->deleted_by = Auth::id();
    //             $model->save();
    //         }
    //     });
    // }
}
