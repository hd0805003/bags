<?php

namespace App\Models\Users\Traits\Relationship;

trait UserRelationship
{
    public function roles()
    {
        return $this->belongsToMany(config('entrust.role'), config('entrust.role_user_table'), config('entrust.user_foreign_key'), config('entrust.role_foreign_key'));
    }

    public function news()
    {
        return $this->hasMany('App\Models\News\News');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\News\News');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Jobs\Job');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Products\Product');
    }

    public function company()
    {
        return $this->hasOne('App\Models\Companies\Company');
    }

    public function detachCompany($company)
    {
        if (is_object($company)) {
            $company = $company->getKey();
        }

        if (is_array($company)) {
            $company = $company['id'];
        }

        $this->company()->detach($company);
    }
}
