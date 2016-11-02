<?php

namespace App\Api\V1\Transformers;

use App\Models\Area;
use Storage;

class CompanyTransformer extends BaseTransformer
{
    public function transformData($model)
    {
        $area = Area::select('name', 'parent_id')->where('code', $model->address)->first();
        $city = Area::select('name', 'parent_id')->where('code', $area->parent_id)->first();
        $province = Area::select('name')->where('code', $city->parent_id)->first();
        $location = $province->name.$city->name.$area->name;
        return [
            'id' => $model->id,
            'name' => $model->name,
            'address' => $location.$model->addressDetail,
            'telephone' => $model->telephone,
            'photos' => $model->photos,
        ];
    }
}
