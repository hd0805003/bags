<?php

namespace App\Api\V1\Transformers;

class SupplyShowTransformer extends BaseTransformer
{
    protected $defaultIncludes = ['user', 'company'];

    public function transformData($model)
    {
        return [
            'id' => $model->id,
            'title' => $model->title,
            'price' => $model->price,
            'unit' => $model->unit,
            'content' => $model->content,
            'images' => $model->images
        ];
    }

    public function includeUser($model)
    {
        return $this->item($model->user, new UserTransformer);
    }

    public function includeCompany($model)
    {
        return $this->item($model->company, new CompanyTransformer);
    }
}
