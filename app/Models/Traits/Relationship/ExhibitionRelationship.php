<?php

namespace App\Models\Traits\Relationship;

trait ExhibitionRelationship
{

    //分类多对多
    public function categories()
    {
        return $this->belongsToMany('App\Models\CategoriesExhibitions', 'category_exhibition', 'exhibition_id', 'category_id');
    }

    //用户一对多反向
    public function user()
    {
        return $this->belongsTo('App\Models\Admin');
    }

    public function favorites()
    {
        return $this->morphMany('App\Models\Favorite', 'favorite');
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
