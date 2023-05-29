<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $guarded = [];

    // treat chnages field as an array when read from database ckonver to an array
    protected $casts =[
        'changes' => 'array'
    ];

    public function subject(){
        return $this->morphTo();
    }

        /**
     * Get the user who triggered the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
