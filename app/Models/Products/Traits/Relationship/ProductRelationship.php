<?php

namespace App\Models\Products\Traits\Relationship;

trait ProductRelationship
{
    //用户一对多反向
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }
}