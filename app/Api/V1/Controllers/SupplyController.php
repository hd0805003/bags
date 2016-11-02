<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\SupplyStoreOrUpdateRequest;
use App\Api\V1\Transformers\SupplyShowTransformer;
use App\Api\V1\Transformers\SupplyTransformer;
use App\Models\Supplies\Supply;
use App\Repositories\Backend\Supplies\SupplyInterface;

class SupplyController extends BaseController
{
    protected $supplies;

    public function __construct(SupplyInterface $supplies)
    {
        $this->supplies = $supplies;
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
     * @apiSampleRequest /api/supplies
     */
    public function index()
    {
        $supplies = Supply::paginate();
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
                "/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg"
            ],
            "user": {
                "data": [
                    {
                        "id": 1,
                        "username": "admin",
                        "mobile": "13111111111",
                        "email": "admin@admin.com",
                        "avatar": "http://stone.dev/uploads/avatars/default/medium.png",
                        "created_at": "2016-11-02 15:57:24"
                    }
                ]
            },
            "company": {
                "data": [
                    {
                        "id": 3,
                        "name": "测试公司",
                        "address": "北京市北京市石景山区",
                        "telephone": "0592-5928529",
                        "photos": [
                            "/storage/companies/2016/11/192330UhMQ.png"
                        ]
                    }
                ]
            }
        }
    }
     * @apiSampleRequest /api/supplies/1
     */
    public function show(Supply $supply)
    {
        $supply->user = $supply->user()->first();
        $supply->company= $supply->company()->first();
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
        $user = $request->user();
        $request->merge(['user_id' => $user->id]);
        $this->supplies->create($request);
        return $this->response->created();
    }
}
