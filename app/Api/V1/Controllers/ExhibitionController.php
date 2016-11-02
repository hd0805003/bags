<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Transformers\BannerTransformer;
use App\Api\V1\Transformers\CategoryTransformer;
use App\Api\V1\Transformers\ExhibitionTransformer;
use App\Models\Banners\Image;
use App\Models\Exhibitions\CategoriesExhibitions;
use App\Models\Exhibitions\Exhibition;

class ExhibitionController extends BaseController
{

    /**
     * @apiDefine Exhibition 展会
     */

    /**
     * @api {get} /exhibitions/banner 展会轮播图
     * @apiDescription 展会轮播图
     * @apiGroup Exhibition
     * @apiPermission 无
     * @apiVersion 1.0.0
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 5,
                "title": "我是展会轮播",
                "image_url": "/storage/banners/f53014b75d5d55c2509a462581f49433.png",
                "order": 5,
                "published_from": "2016-11-30 17:48:21",
                "published_to": "2016-12-31 17:48:21"
            },
            {
                "id": 6,
                "title": "我是展会轮播2",
                "image_url": "/storage/banners/a766a4fb33a03664caaad1017937f404.png",
                "order": 6,
                "published_from": "2016-11-30 17:48:42",
                "published_to": "2016-12-31 17:48:42"
            }
        ]
    }
     * @apiSampleRequest /api/exhibitions/banner
     */
    public function banner()
    {
        $images = Image::where('banner_id', 3)->get();
        return $this->response->collection($images, new BannerTransformer());
    }

    /**
     * @api {get} /exhibitions 展会列表
     * @apiDescription 展会列表
     * @apiGroup Exhibition
     * @apiPermission 无
     * @apiVersion 1.0.0
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *
    {
        "data": [
            {
                "id": 1,
                "title": "有一个展会",
                "subtitle": "展会简单描述",
                "address": "xiamen",
                "telephone": "05925910000",
                "image": "/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg",
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
     * @apiSampleRequest /api/exhibitions
     */
    public function index()
    {
        $exhibition = Exhibition::paginate();
        return $this->response()->paginator($exhibition, new ExhibitionTransformer());
    }

    /**
     * @api {get} /exhibitions/categories 展会分类
     * @apiDescription 展会分类
     * @apiGroup Exhibition
     * @apiPermission 无
     * @apiVersion 1.0.0
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 1,
                "name": "原料"
            },
            {
                "id": 2,
                "name": "设备"
            },
            {
                "id": 3,
                "name": "成品"
            },
            {
                "id": 4,
                "name": "添加剂"
            },
            {
                "id": 5,
                "name": "检测"
            },
            {
                "id": 6,
                "name": "其他"
            }
        ]
    }
     * @apiSampleRequest /api/exhibitions/categories
     */
    public function categories()
    {
        //激活的分类
        $categories = CategoriesExhibitions::where('is_active', 1)->get();
        return $this->response()->collection($categories, new CategoryTransformer());
    }

    /**
     * @api {get} /exhibitions/:id 展会详情
     * @apiDescription 展会详情
     * @apiGroup Exhibition
     * @apiPermission 无
     * @apiVersion 1.0.0
     * @apiParam {Number} id     展会ID
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": {
            "id": 1,
            "title": "有一个展会",
            "address": "xiamen",
            "telephone": "05925910000",
            "content": "<h2 style=\"box-sizing: border-box; -webkit-font-smoothing: antialiased; font-size: 30px; font-weight: 400; margin-top: 55px; position: relative; color: rgb(82, 82, 82); font-family: \" source=\"\" sans=\"\" white-space:=\"\" background-color:=\"\"><a href=\"http://docs.larastars.cn/zh/5.3/routing#route-model-binding\" style=\"box-sizing: border-box; background-color: transparent; color: rgb(82, 82, 82); text-decoration: none;\">路由模型绑定</a></h2><p style=\"box-sizing: border-box; line-height: 1.7; margin-top: 10px; margin-bottom: 20px; font-size: 14.5px; color: rgb(82, 82, 82); font-family: \" source=\"\" sans=\"\" white-space:=\"\" background-color:=\"\">当注入模型的 ID 到路由或控制器动作时，你经常会需要查询检索出相应 ID 的模型。Laravel 路由模型绑定提供了一种便利的方式去注入模型实例到路由中，比如，你可以通过传递 ID，来注入匹配 ID 的用户的整个模型实例到路由中。</p><p style=\"box-sizing: border-box; line-height: 1.7; margin-top: 10px; margin-bottom: 20px; font-size: 14.5px; color: rgb(82, 82, 82); font-family: \" source=\"\" sans=\"\" white-space:=\"\" background-color:=\"\"><a style=\"box-sizing: border-box; background-color: transparent; color: rgb(244, 100, 95); text-decoration: underline;\" name=\"implicit-binding\"></a></p><h3 style=\"box-sizing: border-box; -webkit-font-smoothing: antialiased; font-size: 24px; font-weight: 400; margin-top: 45px; color: rgb(82, 82, 82); font-family: \" source=\"\" sans=\"\" white-space:=\"\" background-color:=\"\">隐式绑定</h3><p style=\"box-sizing: border-box; line-height: 1.7; margin-top: 10px; margin-bottom: 20px; font-size: 14.5px; color: rgb(82, 82, 82); font-family: \" source=\"\" sans=\"\" white-space:=\"\" background-color:=\"\">Laravel 会自动的解析定义在路由或者控制器中具有类型提示的&nbsp;<code class=\" language-php\" style=\"box-sizing: border-box; font-family: Consolas, Monaco, \" andale=\"\" font-size:=\"\" background:=\"\" color:=\"\" padding:=\"\" 1px=\"\" border-radius:=\"\" text-shadow:=\"\" white=\"\" 0px=\"\" direction:=\"\" white-space:=\"\" word-spacing:=\"\" word-break:=\"\" line-height:=\"\" tab-size:=\"\" box-shadow:=\"\" vertical-align:=\"\">Eloquent</code>&nbsp;模型，它会根据变量名与参数名匹配，比如&nbsp;<code class=\" language-php\" style=\"box-sizing: border-box; font-family: Consolas, Monaco, \" andale=\"\" font-size:=\"\" background:=\"\" color:=\"\" padding:=\"\" 1px=\"\" border-radius:=\"\" text-shadow:=\"\" white=\"\" 0px=\"\" direction:=\"\" white-space:=\"\" word-spacing:=\"\" word-break:=\"\" line-height:=\"\" tab-size:=\"\" box-shadow:=\"\" vertical-align:=\"\">api<span class=\"token operator\" style=\"box-sizing: border-box; color: rgb(85, 85, 85);\">/</span>users<span class=\"token operator\" style=\"box-sizing: border-box; color: rgb(85, 85, 85);\">/</span><span class=\"token punctuation\" style=\"box-sizing: border-box; color: rgb(153, 153, 153);\">{</span>user<span class=\"token punctuation\" style=\"box-sizing: border-box; color: rgb(153, 153, 153);\">}</span></code>&nbsp;匹配&nbsp;<code class=\" language-php\" style=\"box-sizing: border-box; font-family: Consolas, Monaco, \" andale=\"\" font-size:=\"\" background:=\"\" color:=\"\" padding:=\"\" 1px=\"\" border-radius:=\"\" text-shadow:=\"\" white=\"\" 0px=\"\" direction:=\"\" white-space:=\"\" word-spacing:=\"\" word-break:=\"\" line-height:=\"\" tab-size:=\"\" box-shadow:=\"\" vertical-align:=\"\"><span class=\"token variable\" style=\"box-sizing: border-box; color: rgb(78, 161, 223);\">$user</span></code>&nbsp;变量：</p><pre class=\" language-php\" style=\"box-sizing: border-box; overflow: auto; font-family: Consolas, Monaco, \" andale=\"\" font-size:=\"\" text-shadow:=\"\" white=\"\" 0px=\"\" direction:=\"\" word-break:=\"\" line-height:=\"\" tab-size:=\"\" padding:=\"\" margin-top:=\"\" margin-bottom:=\"\" background-color:=\"\" border-radius:=\"\" box-shadow:=\"\" 1px=\"\" vertical-align:=\"\">Route::get(&#39;api/users/{user}&#39;,&nbsp;function&nbsp;(App\\User&nbsp;$user)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$user-&gt;email;});</pre><p><br/></p>",
            "image": "/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg",
            "published_at": "2016-11-30 17:30:52",
            "created_at": "2016-11-01 17:32:43"
        }
    }
     * @apiSampleRequest /api/exhibitions/1
     */
    public function show(Exhibition $exhibition)
    {
        $exhibition->increment('view_count', 1);
        return $this->response->item($exhibition, new ExhibitionShowTransformer());
    }
}