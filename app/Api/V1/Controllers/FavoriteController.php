<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Transformers\CompanyFavoriteTransformer;
use App\Api\V1\Transformers\DemandFavoriteTransformer;
use App\Api\V1\Transformers\ExhibitionFavoriteTransformer;
use App\Api\V1\Transformers\JobFavoriteTransformer;
use App\Api\V1\Transformers\NewsFavoriteTransformer;
use App\Api\V1\Transformers\ProductFavoriteTransformer;
use App\Api\V1\Transformers\SupplyFavoriteTransformer;
use App\Api\V1\Transformers\TopicFavoriteTransformer;
use App\Models\Company;
use App\Models\Demand;
use App\Models\Exhibition;
use App\Models\Favorite;
use App\Models\Job;
use App\Models\News;
use App\Models\Product;
use App\Models\Supply;
use App\Models\Topic;
use App\Repositories\Backend\Favorites\FavoriteRepository;
use Auth;
use Illuminate\Http\Request;

class FavoriteController extends BaseController
{
    private $favorites;

    public function __construct(FavoriteRepository $favorites)
    {
        $this->favorites = $favorites;
    }


    /**
     * @apiDefine Favorite 收藏
     */

    /**
     * @api {get} /favorites/companies/role/:id 收藏的公司
     * @apiDescription 收藏的公司 :id 1//为采购商 2//为供应商 3//为机构/单位
     * @apiGroup Favorite
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 112,
                "company_id": 1,
                "name": "航运城测试",
                "province": "福建省",
                "city": "厦门市",
                "area": "思明区",
                "addressDetail": "HK排比哈哈哈哈他JJ他拒绝离开过来了来了太可怜了啦啦啦啦",
                "telephone": "0592-5928529",
                "role": 1,
                "photos": [
                    "http://117.29.170.226:8000/storage/companies/2016/12/092247GL7n.png"
                ],
                "is_validate": 1,
                "is_excellent": 0
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
     * @apiSampleRequest /api/favorites/companies/role/1
     */
    public function indexForCompanyRole($id)
    {
        $companys = Favorite::where('user_id', Auth::id())->where('favorite_type', 'App\Models\Company')->with('favorite')->orderBy('created_at', 'DESC')->paginate();
        foreach ($companys as $key => $company) {
            $favorite = $company->getRelation('favorite');
            if ($favorite->role != $id || !$favorite) {
                unset($companys[$key]);
                continue;
            }
            $favorite->company_id = $company->favorite_id;
            $favorite->id = $company->id;
            $companys[$key] = $favorite;
        }
        return $this->response()->paginator($companys, new CompanyFavoriteTransformer());
    }

    /**
     * @api {get} /favorites/exhibitions 收藏的展会
     * @apiDescription 收藏的展会
     * @apiGroup Favorite
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 1,
                "exhibitions_id": 2,
                "title": "有一个展会",
                "address": "xiamen",
                "telephone": "05925910000",
                "image": "/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg"
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
     * @apiSampleRequest /api/favorites/exhibitions
     */
    public function indexForExhibition()
    {
        $exhibitions = Favorite::where('user_id', Auth::id())->where('favorite_type', 'App\Models\Exhibition')->with('favorite')->orderBy('created_at', 'DESC')->paginate();
        foreach ($exhibitions as $key => $exhibition) {
            $favorite = $exhibition->getRelation('favorite');
            if (!$favorite) {
                unset($exhibitions[$key]);
                continue;
            }
            $favorite->exhibition_id = $exhibition->favorite_id;
            $favorite->id = $exhibition->id;
            $exhibitions[$key] = $favorite;
        }
        return $this->response()->paginator($exhibitions, new ExhibitionFavoriteTransformer());
    }

    /**
     * @api {get} /favorites/news 收藏的新闻
     * @apiDescription 收藏的新闻
     * @apiGroup Favorite
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 1,
                "news_id": 2,
                "title": "sed vel asperiores",
                "subtitle": "nisi consectetur ea",
                "image": "/storage/images/00425874a34ae1fd522f96c753ee2b2b.jpg",
                "updated_at": "2016-11-07 08:23:10",
                "categories": {
                    "data": [
                        {
                            "id": 1,
                            "name": "可降解知识"
                        }
                    ]
                }
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
     * @apiSampleRequest /api/favorites/news
     */
    public function indexForNews()
    {
        $news = Favorite::where('user_id', Auth::id())->where('favorite_type', 'App\Models\News')->with('favorite')->orderBy('created_at', 'DESC')->paginate();
        foreach ($news as $key => $new) {
            $favorite = $new->getRelation('favorite');
            if (!$favorite) {
                unset($news[$key]);
                continue;
            }
            $favorite->news_id = $new->favorite_id;
            $favorite->id = $new->id;
            $news[$key] = $favorite;
        }
        return $this->response()->paginator($news, new NewsFavoriteTransformer());
    }

    /**
     * @api {get} /favorites/products 收藏的产品
     * @apiDescription 收藏的产品
     * @apiGroup Favorite
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 1,
                "product_id": 1,
                "title": "产品标题",
                "price": 1.2,
                "unit": 1,
                "content": "<p>产品很好很好产品很好很好产品很好很好产品很好很好</p>",
                "images": [
                    "/uploads/products/2016/11/092739rqKq.png"
                ]
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
     * @apiSampleRequest /api/favorites/products
     */
    public function indexForProduct()
    {
        $products = Favorite::where('user_id', Auth::id())->where('favorite_type', 'App\Models\Product')->with('favorite')->orderBy('created_at', 'DESC')->paginate();
        foreach ($products as $key => $product) {
            $favorite = $product->getRelation('favorite');
            if (!$favorite) {
                unset($products[$key]);
                continue;
            }
            $favorite->product_id = $product->favorite_id;
            $favorite->id = $product->id;
            $products[$key] = $favorite;
        }
        return $this->response()->paginator($products, new ProductFavoriteTransformer());
    }

    /**
     * @api {get} /favorites/jobs 收藏的招聘
     * @apiDescription 收藏的招聘
     * @apiGroup Favorite
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 1,
                "company_id": 2,
                "job": "销售代表",
                "total": "10人",
                "education": "本科大学",
                "experience": "2-3年",
                "minsalary": "50000",
                "content": "<p>要求就是不要命</p>"
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
     * @apiSampleRequest /api/favorites/jobs
     */
    public function indexForJob()
    {
        $jobs = Favorite::where('user_id', Auth::id())->where('favorite_type', 'App\Models\Job')->with('favorite')->orderBy('created_at', 'DESC')->paginate();
        foreach ($jobs as $key => $job) {
            $favorite = $job->getRelation('favorite');
            if (!$favorite) {
                unset($jobs[$key]);
                continue;
            }
            $company = $favorite->company;
            $favorite->job_id = $job->favorite_id;
            $favorite->company_id = $company->id;
            $favorite->id = $job->id;
            $jobs[$key] = $favorite;
        }
        return $this->response()->paginator($jobs, new JobFavoriteTransformer());
    }

    /**
     * @api {get} /favorites/topics 收藏的帖子
     * @apiDescription 收藏的帖子
     * @apiGroup Favorite
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 1,
                "topic_id": 2,
                "category_id": 2,
                "title": "Laravel 5.3 中文文档翻译完成",
                "content": "<p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; line-height: 30px; color: rgb(82, 82, 82); font-family: NotoSansHans-Regular, AvenirNext-Regular, arial, \" hiragino=\"\" sans=\"\" microsoft=\"\" wenquanyi=\"\" micro=\"\" white-space:=\"\" background-color:=\"\"><img src=\"https://dn-phphub.qbox.me/uploads/images/201608/24/1/IEQ4Xir8sH.jpg\" alt=\"\" data-type=\"image\" style=\"box-sizing: border-box; border: 1px solid rgb(221, 221, 221); vertical-align: middle; max-width: 100%; box-shadow: rgb(204, 204, 204) 0px 0px 30px; margin-bottom: 30px; margin-top: 10px;\"/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; line-height: 30px; color: rgb(82, 82, 82); font-family: NotoSansHans-Regular, AvenirNext-Regular, arial, \" hiragino=\"\" sans=\"\" microsoft=\"\" wenquanyi=\"\" micro=\"\" white-space:=\"\" background-color:=\"\">文档地址在此：<a href=\"https://laravel-china.org/docs/5.3\" style=\"box-sizing: border-box; background: transparent; color: rgb(5, 161, 162); text-decoration: none;\">https://laravel-china.org/docs/5.3</a></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; line-height: 30px; color: rgb(82, 82, 82); font-family: NotoSansHans-Regular, AvenirNext-Regular, arial, \" hiragino=\"\" sans=\"\" microsoft=\"\" wenquanyi=\"\" micro=\"\" white-space:=\"\" background-color:=\"\">翻译的召集帖：<a href=\"https://laravel-china.org/topics/2752\" style=\"box-sizing: border-box; background: transparent; color: rgb(5, 161, 162); text-decoration: none;\">https://laravel-china.org/topics/2752</a></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; line-height: 30px; color: rgb(82, 82, 82); font-family: NotoSansHans-Regular, AvenirNext-Regular, arial, \" hiragino=\"\" sans=\"\" microsoft=\"\" wenquanyi=\"\" micro=\"\" white-space:=\"\" background-color:=\"\">参与人员列表：<a href=\"https://laravel-china.org/roles/7\" style=\"box-sizing: border-box; background: transparent; color: rgb(5, 161, 162); text-decoration: none;\">Laravel 5.3 译者</a></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; line-height: 30px; color: rgb(82, 82, 82); font-family: NotoSansHans-Regular, AvenirNext-Regular, arial, \" hiragino=\"\" sans=\"\" microsoft=\"\" wenquanyi=\"\" micro=\"\" white-space:=\"\" background-color:=\"\">项目托管在 Github 上，欢迎提交反馈：<a href=\"https://github.com/laravel-china/laravel-docs\" style=\"box-sizing: border-box; background: transparent; color: rgb(5, 161, 162); text-decoration: none;\">https://github.com/laravel-china/laravel-docs</a></p><blockquote style=\"box-sizing: border-box; padding: 6px 8px; border-left: 4px solid rgb(221, 221, 221); line-height: 30px; color: rgb(119, 119, 119); background-color: rgb(247, 247, 247); font-family: NotoSansHans-Regular, AvenirNext-Regular, arial, \" hiragino=\"\" sans=\"\" microsoft=\"\" wenquanyi=\"\" micro=\"\" white-space:=\"\" margin:=\"\" 20px=\"\" 0px=\"\"><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; line-height: 30px;\">我代表 Laravel 中文文档的受益者对 可爱的&nbsp;<a href=\"https://laravel-china.org/roles/7\" style=\"box-sizing: border-box; background: transparent; color: rgb(5, 161, 162); text-decoration: none;\">Laravel 5.3 译者</a>&nbsp;表示感谢&nbsp;<img title=\":beer:\" alt=\":beer:\" class=\"emoji\" src=\"https://dn-phphub.qbox.me/assets/images/emoji/beer.png\" align=\"absmiddle\" style=\"box-sizing: border-box; border: 0px; vertical-align: middle; width: 1.6em; display: inline-block; margin-bottom: 0px; margin-top: -5px; margin-left: 5px; max-width: 100%;\"/>&nbsp;<img title=\":metal:\" alt=\":metal:\" class=\"emoji\" src=\"https://dn-phphub.qbox.me/assets/images/emoji/metal.png\" align=\"absmiddle\" style=\"box-sizing: border-box; border: 0px; vertical-align: middle; width: 1.6em; display: inline-block; margin-bottom: 0px; margin-top: -5px; margin-left: 5px; max-width: 100%;\"/></p></blockquote><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; line-height: 30px; color: rgb(82, 82, 82); font-family: NotoSansHans-Regular, AvenirNext-Regular, arial, \" hiragino=\"\" sans=\"\" microsoft=\"\" wenquanyi=\"\" micro=\"\" white-space:=\"\" background-color:=\"\"><img src=\"https://dn-phphub.qbox.me/uploads/images/201610/19/1/F9kV4goXoU.png\" alt=\"\" data-type=\"image\" style=\"box-sizing: border-box; border: 1px solid rgb(221, 221, 221); vertical-align: middle; max-width: 100%; box-shadow: rgb(204, 204, 204) 0px 0px 30px; margin-bottom: 30px; margin-top: 10px;\"/></p><p><br/></p>",
                "reply_count": 4,
                "vote_count": 5,
                "vote_up": 0,
                "vote_down": 0,
                "updated_at": "2016-11-07",
                "user": {
                    "data": {
                        "id": 2,
                        "username": "user",
                        "mobile": "13113113111",
                        "email": "user@user.com",
                        "avatar": "http://stone.dev/uploads/avatars/default/medium.png",
                        "created_at": "2016-11-02 15:57:24"
                    }
                }
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
     * @apiSampleRequest /api/favorites/topics
     */
    public function indexForTopic()
    {
        $topics = Favorite::where('user_id', Auth::id())->where('favorite_type', 'App\Models\Topic')->with('favorite')->orderBy('created_at', 'DESC')->paginate();
        foreach ($topics as $key => $topic) {
            $favorite = $topic->getRelation('favorite');
            if (!$favorite) {
                unset($topics[$key]);
                continue;
            }
            $favorite->topic_id = $topic->favorite_id;
            $favorite->id = $topic->id;
            $topics[$key] = $favorite;
        }
        return $this->response()->paginator($topics, new TopicFavoriteTransformer());
    }

    /**
     * @api {get} /favorites/demands 收藏的需求
     * @apiDescription 收藏的需求
     * @apiGroup Favorite
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 113,
                "demand_id": 1,
                "title": "我需求质量好的袋子",
                "quantity": 1000,
                "unit": 5,
                "images": [
                    "http://stone.dev/uploads/products/2016/11/165305Y37a.png"
                ],
                "is_excellent": 0
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
     * @apiSampleRequest /api/favorites/demands
     */
    public function indexForDemand()
    {
        $demands = Favorite::where('user_id', Auth::id())->where('favorite_type', 'App\Models\Demand')->with('favorite')->orderBy('created_at', 'DESC')->paginate();
        foreach ($demands as $key => $demand) {
            $favorite = $demand->getRelation('favorite');
            if (!$favorite) {
                unset($demands[$key]);
                continue;
            }
            $favorite->demand_id = $demand->favorite_id;
            $favorite->id = $demand->id;
            $demands[$key] = $favorite;
        }
        return $this->response()->paginator($demands, new DemandFavoriteTransformer());
    }

    /**
     * @api {get} /favorites/supplies 收藏的供应
     * @apiDescription 收藏的供应
     * @apiGroup Favorite
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
    {
        "data": [
            {
                "id": 105,
                "supply_id": 30,
                "title": "一盒白糖",
                "price": 50,
                "unit": 5,
                "images": [
                    "http://117.29.170.226:8000/storage/companies/2016/12/062736s8QD.png"
                ],
                "content": "这是一箱白糖",
                "is_excellent": 0
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
     * @apiSampleRequest /api/favorites/supplies
     */
    public function indexForSupply()
    {
        $supplies = Favorite::where('user_id', Auth::id())->where('favorite_type', 'App\Models\Supply')->with('favorite')->orderBy('created_at', 'DESC')->paginate();
        foreach ($supplies as $key => $supply) {
            $favorite = $supply->getRelation('favorite');
            if (!$favorite) {
                unset($supplies[$key]);
                continue;
            }
            $favorite->supply_id = $supply->favorite_id;
            $favorite->id = $supply->id;
            $supplies[$key] = $favorite;
        }
        return $this->response()->paginator($supplies, new SupplyFavoriteTransformer());
    }

    /**
     * @api {delete} /favorites 删除收藏
     * @apiDescription 删除收藏
     * @apiGroup Favorite
     * @apiPermission 认证
     * @apiVersion 1.0.0
     * @apiParam {Number} favorite_id 模型ID
     * @apiParam {String="news","product","topic","demand","supply","company","exhibition","job"} favorite_type 模型
     * @apiHeader Authorization Bearer {access_token}
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 204 No Content
     */
    public function destroy(Request $request)
    {
        $this->favorites->destroyFavorite($request);
        return $this->response->noContent();
    }
}
