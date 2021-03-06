<?php

namespace App\Api\V1\Transformers;

use Storage;

class JobFavoriteTransformer extends BaseTransformer
{
    public function transformData($model)
    {
        return [
            'id' => $model->id,
            'job_id' => $model->job_id,
            'company_id' => $model->company_id,
            'job' => $model->job,
            'total' => $model->total,
            'education' => $model->education,
            'experience' => $model->experience,
            'minsalary' => $model->minsalary,
            'content' => $model->content,
        ];
    }
}
