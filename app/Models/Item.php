<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
   public $timestamps = false;
   
   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
       'scrape_id',
       '_id'
   ];
}
