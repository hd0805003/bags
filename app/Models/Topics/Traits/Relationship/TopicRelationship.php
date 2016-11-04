<?php

namespace App\Models\Topics\Traits\Relationship;

trait TopicRelationship
{
    //分类一对一
    public function category()
    {
        return $this->belongsTo('App\Models\Topics\CategoriesTopics', 'category_id');
    }

    //用户一对多反向
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    //评论一对多
    public function replies()
    {
        return $this->hasMany('App\Models\Topics\Repliy');
    }

    public function lastReplyUser()
    {
        return $this->belongsTo('App\Models\Users\User', 'last_reply_user_id');
    }

    public function votes()
    {
        return $this->morphMany('App\Models\Topics\Vote', 'votable');
    }

    public function voteby()
    {
        $user_ids = Vote::where('votable_type', 'Topic')
                        ->where('votable_id', $this->id)
                        ->where('is', 'upvote')
                        ->lists('user_id')
                        ->toArray();
        return User::whereIn('id', $user_ids)->get();
    }

    public function generateLastReplyUserInfo()
    {
        $lastReply = $this->replies()->recent()->first();

        $this->last_reply_user_id = $lastReply ? $lastReply->user_id : 0;
        $this->save();
    }

    public function getRepliesWithLimit($limit = 30)
    {
        $pageName = 'page';

        // Default display the latest reply
        $latest_page = is_null(\Input::get($pageName)) ? ceil($this->reply_count / $limit) : 1;

        return $this->replies()
                    ->orderBy('created_at', 'asc')
                    ->with('user')
                    ->paginate($limit, ['*'], $pageName, $latest_page);
    }

    public static function makeExcerpt($body)
    {
        $html = $body;
        $excerpt = trim(preg_replace('/\s\s+/', ' ', strip_tags($html)));
        return str_limit($excerpt, 200);
    }

    public function scopeByWhom($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
