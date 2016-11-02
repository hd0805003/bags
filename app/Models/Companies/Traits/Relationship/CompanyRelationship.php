<?php

namespace App\Models\Companies\Traits\Relationship;

trait CompanyRelationship
{

    //分类多对多
    public function categories()
    {
        return $this->belongsToMany('App\Models\Companies\CategoryCompany', 'category_company', 'company_id', 'category_id');
    }

    //用户一对多反向
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    //产品一对多
    public function products()
    {
        return $this->hasMany('App\Models\Products\Product', 'user_id');
    }

    //添加分类数据到中间表
    public function attachCategory($Category)
    {
        if (is_object($Category)) {
            $Category = $Category->getKey();
        }

        if (is_array($Category)) {
            $Category = $Category['id'];
        }

        $this->Categories()->attach($Category);
    }

    //添加分类数据到中间表
    public function attachCategories($Categories)
    {
        foreach ($Categories as $Category) {
            $this->attachCategory($Category);
        }
    }

    //更新分类数据到中间表
    public function syncCategories($Categories)
    {
        $this->Categories()->sync($Categories);
    }
}
