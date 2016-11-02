<?php

namespace App\Repositories\Backend\Topics;

use App\Exceptions\GeneralException;
use App\Models\Topics\Topic;
use App\Models\Topics\TopicCategory;
use DB;
use Auth;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class TopicRepository implements TopicInterface
{
    public function getForDataTable()
    {
        return Topic::select('topics.*', 'categories_topics.name as category', 'users.username as username')
        ->leftJoin('categories_topics', 'categories_topics.id', 'topics.category_id')
        ->leftJoin('users', 'users.id', 'topics.user_id');
    }

    public function create($input)
    {
        $topic = new Topic;
        $topic->title = $input['title'];
        //$topic->slug = $input['slug'];
        $topic->excerpt = $input['excerpt'];
        $topic->content = $input['content'];
        $topic->user_id = $input['user_id'];
        $topic->category_id = $input['category_id'];
        $topic->is_excellent = $input['is_excellent'];
        $topic->is_blocked = $input['is_blocked'];
        $topic->view_count = $input['view_count'];
        $topic->reply_count = $input['reply_count'];
        $topic->vote_count = $input['vote_count'];

        DB::transaction(function () use ($topic) {
            if ($topic->save()) {
                return true;
            }

            throw new GeneralException("添加失败");
        });
    }

    public function update(Topic $topic, $input)
    {
        $topic->title = $input['title'];
        //$topic->slug = $input['slug'];
        $topic->excerpt = $input['excerpt'];
        $topic->content = $input['content'];
        $topic->user_id = $input['user_id'];
        $topic->category_id = $input['category_id'];
        $topic->is_excellent = $input['is_excellent'];
        $topic->is_blocked = $input['is_blocked'];
        $topic->view_count = $input['view_count'];
        $topic->reply_count = $input['reply_count'];
        $topic->vote_count = $input['vote_count'];

        DB::transaction(function () use ($topic) {
            if ($topic->update()) {
                return true;
            }

            throw new GeneralException("更新失败");
        });
    }

    public function destroy($id)
    {
        $topic = $this->findOrThrowException($id);
        if ($topic->delete()) {
            return true;
        }
        throw new GeneralException('删除失败！');
    }

    public function restore($id)
    {
        $topic = $this->findOrThrowException($id);
        if ($topic->restore()) {
            return true;
        }
        throw new GeneralException('返回失败！');
    }

    public function delete($id)
    {
        $topic = $this->findOrThrowException($id);
        if ($topic->forceDelete()) {
            return true;
        }
        throw new GeneralException('删除失败！');
    }

    public function findOrThrowException($id)
    {
        $demand = Topic::withTrashed()->find($id);

        if (!is_null($demand)) {
            return $demand;
        }

        throw new GeneralException('未找到需求信息');
    }
}