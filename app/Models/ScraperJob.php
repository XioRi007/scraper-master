<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
class ScraperJob extends Model
{
    use HasFactory;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $collection = 'jobs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_time',
        'params',
        'pod_count',
        'status',
        'pods',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'scrape_id', '_id');
    }
    
}
