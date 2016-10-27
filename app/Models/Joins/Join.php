<?php

namespace App\Models\Joins;

use Illuminate\Database\Eloquent\Model;
use App\Models\Joins\Traits\Attribute\JoinAttribute;
use App\Models\Joins\Traits\Relationship\JoinRelationship;

class Join extends Model
{
    use JoinAttribute, JoinRelationship;

    public static function joinFilter($query, $request)
    {
        if ($request->has('id')) {
            $query = $query->where('joins.id', $request->get('id'));
        }

        if ($request->has('username')) {
            $query = $query->where('username', 'like', "%{$request->get('username')}%");
        }

        if ($request->has('companyname')) {
            $query = $query->where('companies.name', 'like', "%{$request->get('companyname')}%");
        }

        if ($request->has('status')) {
            $query = $query->where('joins.status', $request->get('status'));
        }

        if ($request->has('created_from') && !$request->has('created_to')) {
            $query = $query->where('joins.created_at', '>=', $request->get('created_from'));
        }

        if (!$request->has('created_from') && $request->has('created_to')) {
            $query = $query->where('joins.created_at', '<=', $request->get('created_to'));
        }

        if ($request->has('created_from') && $request->has('created_to')) {
            $query = $query->whereBetween('joins.created_at', [$request->get('created_from'),$request->get('created_to')]);
        }

        return $query;
    }
}
