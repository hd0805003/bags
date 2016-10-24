<?php

namespace App\Models\Tags\Traits\Relationship;

trait TagsRelationship
{


    //所属标签的新闻多对多的多态关联反向
    public function news()
    {
        return $this->morphedByMany('App\Models\News\News', 'taggable');
    }
}
