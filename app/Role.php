<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
