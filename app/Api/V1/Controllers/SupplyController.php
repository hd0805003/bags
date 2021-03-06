<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\SupplyStoreOrUpdateRequest;
use App\Api\V1\Transformers\SupplyShowTransformer;
use App\Api\V1\Transformers\SupplyTransformer;
use App\Models\Supply;
use App\Repositories\Backend\Supplies\SupplyRepository;
use App\Repositories\Backend\Favorites\FavoriteRepository;
use Auth;
use Illuminate\Http\Request;

class SupplyController extends BaseController
{
    protected $supplies;
    protected $favorites;

    public function __construct(SupplyRepository $supplies, FavoriteRepository $favorites)
    {
        $this->supplies = $supplies;
        $this->favorites = $favorites;
    }

    /**
     * @apiDefine Supply 供应
     */

    /**
     * @api {get} /supplies 供应列表
     * @apiDescription 供应列表
     * @apiGroup Supply
     * @apiPermission 无
     * @apiVersion 1.0.0
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 1,
                "title": "我有100袋包装袋",
                "images": [
                    "http://stone.dev/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg"
                ],
                "content": "<p>我就有这么多包装袋</p>",
                "is_excellent": 0
            },
            {
                "id": 2,
                "title": "我需求100袋包装袋",
                "images": [
                    "http://stone.dev/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg"
                ],
                "content": "我就需要这么多包装袋",
                "is_excellent": 1
            }
        ],
        "meta": {
            "pagination": {
                "total": 2,
                "count": 2,
                "per_page": 15,
                "current_page": 1,
                "total_pages": 1,
                "links": []
            }
        }
    }
     * @apiSampleRequest /api/supplies
     */
    public function index()
    {
        $supplies = $this->supplies->index();
        return $this->response()->paginator($supplies, new SupplyTransformer());
    }
    /**
     * @api {get} /users/supplies 供应列表
     * @apiDescription 供应列表
     * @apiGroup Auth
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 1,
                "title": "我有100袋包装袋",
                "images": [
                    "/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg"
                ],
                "content": "我就需要这么多包装袋"
            }
        ],
        "meta": {
            "pagination": {
                "total": 1,
                "count": 1,
                "per_page": 15,
                "current_page": 1,
                "total_pages": 1,
                "links": []
            }
        }
    }
     * @apiSampleRequest /api/users/supplies
     */
    public function indexByUser()
    {
        $supplies = $this->supplies->indexByUser();
        return $this->response()->paginator($supplies, new SupplyTransformer());
    }

    /**
     * @api {get} /supplies/:id 供应详情
     * @apiDescription 供应详情 :id 供应ID user会员信息 company 公司信息
     * @apiGroup Supply
     * @apiPermission 无
     * @apiVersion 1.0.0
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": {
            "id": 1,
            "title": "我有100袋包装袋",
            "price": 100,
            "unit": 1,
            "content": "<p>我就有这么多包装袋</p>",
            "images": [
                "http://stone.dev/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg"
            ],
            "is_excellent": 0,
            "province": "北京市",
            "city": "北京市",
            "area": "石景山区",
            "addressDetail": "",
            "user": {
                "data": {
                    "id": 2,
                    "username": "user",
                    "name": "name",
                    "mobile": "13113113111",
                    "email": "user@user.com",
                    "avatar": {
                        "_default": "",
                        "small": "",
                        "medium": "",
                        "large": ""
                    },
                    "created_at": "2016-11-02 07:57:24"
                }
            }
        }
    }
     * @apiSampleRequest /api/supplies/1
     */
    public function show(Supply $supply)
    {
        $supply->user = $supply->user()->first();
        $company = $supply->company()->first();
        $supply->address = $company->address;
        $supply->addressDetail = $company->addressDetail;
        $supply->is_favorite = $this->favorites->userIsFavorite('supply', $supply->id, Auth::id());
        return $this->response->item($supply, new SupplyShowTransformer());
    }

    /**
     * @api {post} /supplies 发布供应
     * @apiDescription 发布供应 unit代表的单位见顶部(接口说明)
     * @apiGroup Supply
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiParam {String} title 标题
     * @apiParam {Number} price 价格 Number(10,2)
     * @apiParam {Number=1,2,3,4,5} unit 单位
     * @apiParam {String[]} images[] 图片
     * @apiParam {String} content 内容
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 201 Created
     * @apiSampleRequest /api/supplies
     */
    public function store(SupplyStoreOrUpdateRequest $request)
    {
        $user = Auth::user();
        if (!$user->company) {
            return $this->response->errorBadRequest('请先完善公司信息！');
        }
        $request->merge(['user_id' => $user->id]);
        $request->images = relative_url($request->images);
        $this->supplies->create($request);
        return $this->response->created();
    }

    /**
     * @api {PATCH} /supplies/:id 更新供应
     * @apiDescription 更新供应 :id为供应ID
     * @apiGroup Supply
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiParam {String} title 标题
     * @apiParam {Number} price 价格 Number(10,2)
     * @apiParam {Number=1,2,3,4,5} unit 单位
     * @apiParam {String[]} images[] 图片
     * @apiParam {String} content 内容
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     * @apiSampleRequest /api/supplies/1
     */
    public function update(Supply $supply, SupplyStoreOrUpdateRequest $request)
    {
        $user = Auth::user();

        if (!$user->can('update', $supply)) {
            return $this->response->errorForbidden();
        }

        $request->images = relative_url($request->images);
        $this->supplies->update($supply, $request->all());
        return $this->response->item($supply, new SupplyShowTransformer());
    }

    /**
     * @api {delete} /supplies/:id 删除供应
     * @apiDescription 删除供应 :id 需要删除供应的ID
     * @apiGroup Supply
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 204 No Content
     */
    public function destroy(Supply $supply)
    {
        $user = Auth::user();

        if (!$user->can('delete', $supply)) {
            return $this->response->errorForbidden();
        }

        $this->supplies->destroy($supply);
        return $this->response->noContent();
    }

    /**
     * @api {post} /supplies/:id/favorites 供应收藏
     * @apiDescription 供应收藏
     * @apiGroup Supply
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 201 Created
     */
    public function favorite(Supply $supply)
    {
        $this->supplies->createFavorite($supply);
        return $this->response->created();
    }

    /**
     * @api {get} /supplies/search 供应搜索
     * @apiDescription 供应搜索
     * @apiGroup Supply
     * @apiPermission 无
     * @apiVersion 1.0.0
     * @apiParam {String} q 搜索关键字
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 2,
                "title": "我需求100袋包装袋",
                "images": [
                    "http://stone.dev/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg"
                ],
                "content": "我就需要这么多包装袋",
                "is_excellent": 1
            }
        ],
        "meta": {
            "pagination": {
                "total": 1,
                "count": 1,
                "per_page": 15,
                "current_page": 1,
                "total_pages": 1,
                "links": []
            }
        }
    }
     * @apiSampleRequest /api/supplies/search
     */
    public function search(Request $request)
    {
        $supplies = $this->supplies->search($request);
        return $this->response->paginator($supplies, new SupplyTransformer());
    }

    /**
     * @api {get} /users/supplies/search 供应搜索
     * @apiDescription 供应搜索
     * @apiGroup Auth
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiParam {String} q 搜索关键字
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 2,
                "title": "我需求100袋包装袋",
                "images": [
                    "http://stone.dev/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg"
                ],
                "content": "我就需要这么多包装袋",
                "is_excellent": 1
            }
        ],
        "meta": {
            "pagination": {
                "total": 1,
                "count": 1,
                "per_page": 15,
                "current_page": 1,
                "total_pages": 1,
                "links": []
            }
        }
    }
     * @apiSampleRequest /api/users/supplies/search
     */
    public function searchWithUser(Request $request)
    {
        $supplies = $this->supplies->searchWithUser($request);
        return $this->response->paginator($supplies, new SupplyTransformer());
    }
}
