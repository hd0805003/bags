<?php

namespace App\Models\News;

use App\Models\Access\User\User;
use App\Models\News\Traits\Attribute\NewsAttribute;
use App\Models\News\Traits\Relationship\NewsRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes, NewsRelationship, NewsAttribute;
    /**
     * 默认数据库
     * @var string
     */
    protected $table = 'news';

    /**
     * 参数黑名单
     * @var array
     */
    protected $guard = [
        'user_id',
    ];

    public static function newsFilter($query, $request)
    {
        if ($request->has('id')) {
            $query = $query->where('id', '=', $request->get('id'));
        }

        if ($request->has('title')) {
            $query = $query->where('title', 'like', "%{$request->get('title')}%");
        }

        if ($request->has('author')) {
            $user = User::where('name', $request->get('author'))->first();
            $user_id = $user ? $user->id : '';
            $query = $query->where('user_id', $user_id);
        }

        /**
         * 使用 whereHas 和 orWhereHas 方法来在 has 查询中插入 where 子句。这些方法允许你为关联进行自定义的约束查询。
         */
        if ($request->has('categories')) {
            $query = $query->whereHas('categories', function ($query) use ($request) {
                $query->where('category_new.category_id', $request->get('categories'));
            });
        }

        if ($request->has('tags')) {
            $query = $query->whereHas('tags', function ($query) use ($request) {
                $query->where('tags.name', $request->get('tags'));
            });
        }

        if ($request->has('published_from') && !$request->has('published_to')) {
            $query = $query->where('published_at', '>=', $request->get('published_from'));
        }

        if (!$request->has('published_from') && $request->has('published_to')) {
            $query = $query->where('published_at', '<=', $request->get('published_to'));
        }

        if ($request->has('published_from') && $request->has('published_to')) {
            $query = $query->whereBetween('published_at', [$request->get('published_from'),$request->get('published_to')]);
        }

        return $query;
    }
}
