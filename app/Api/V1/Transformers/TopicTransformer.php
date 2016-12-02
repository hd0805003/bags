<?php

namespace App\Api\V1\Transformers;

class TopicTransformer extends BaseTransformer
{
    protected $availableIncludes = ['user', 'last_reply_user', 'replies', 'category'];

    protected $defaultIncludes = ['user','replies'];

    public function transformData($model)
    {
        return [
            "id" => $model->id,
            "category_id" => $model->category_id,
            "title" => $model->title,
            "content" => $model->content,
            "reply_count" => $model->reply_count,
            "view_count" => $model->view_count,
            "vote_count" => $model->vote_count,
            'is_excellent' => $model->is_excellent == 'yes' ? 1 : 0,
            "created_at" => $model->created_at->toDateTimeString()
        ];
    }

    public function includeUser($model)
    {
        return $this->item($model->user, new UserTransformer());
    }

    public function includeLastReplyUser($model)
    {
        return $this->item($model->lastReplyUser ?: $model->user, new UserTransformer());
    }

    public function includeReplies($model)
    {
        return $this->collection($model->replies, new ReplyTransformer());
    }

    public function includeCategory($model)
    {
        return $this->item($model->category, new CategoryTransformer());
    }
}
