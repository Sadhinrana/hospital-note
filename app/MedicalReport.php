<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The user that that owns the report.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
