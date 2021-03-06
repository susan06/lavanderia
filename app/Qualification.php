<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'qualifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'quantify'
    ];

     /**
     * Field type
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer'
    ];

    /**
     * Functions
     *
     */
    public function getCreatedAtAttribute($date)
    {
        if($date){
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y G:ia');
        }
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y G:ia');
    }

     /**
     * Relationships
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
