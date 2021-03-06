<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description', 'removable'
    ];

     /**
     * Field type
     *
     * @var array
     */
    protected $casts = [
        'removable' => 'boolean'
    ];

     /**
     * Relationships
     *
     */
    public function user()
    {
        return $this->hasOne(User::class, 'role_id');
    }

}
