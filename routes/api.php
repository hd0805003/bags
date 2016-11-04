<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = Api::router();

$api->version('v1', ['namespace' => 'App\Api\V1\Controllers',
        'middleware' => ['api', 'bindings'],
        'limit'      => config('api.rate_limits.access.limits'),
        'expires'    => config('api.rate_limits.access.expires'),
], function ($api) {
    /**
     * 主页
     */
    $api->get('banners', 'HomepageController@banner');


    /**
     * 地区
     */
    $api->get('areas', 'AreaController@index');
    $api->get('areas/{area}', 'AreaController@show');
    $api->get('childrens/{area}', 'AreaController@children');
    $api->get('provinces', 'AreaController@province');
    $api->get('citys', 'AreaController@city');


    /**
     * 新闻
     */
    $api->get('news', 'NewsController@index');
    $api->get('news/categories/{news}', 'NewsController@indexByCategories');
    $api->get('news/banner', 'NewsController@banner');
    $api->get('news/categories', 'NewsController@categories');
    $api->get('news/{news}', 'NewsController@show');

    /**
     * 展会
     */
    $api->get('exhibitions', 'ExhibitionController@index');
    $api->get('exhibitions/banner', 'ExhibitionController@banner');
    $api->get('exhibitions/categories', 'ExhibitionController@categories');
    $api->get('exhibitions/{exhibition}', 'ExhibitionController@show');

    /**
     * 公司
     */
    $api->get('companies/role/{role}', 'CompanyController@index');
    $api->get('companies/banner', 'CompanyController@banner');
    $api->get('companies/categories/{category}', 'CompanyController@categories');
    $api->get('companies/{company}', 'CompanyController@show');
    $api->get('companies/{company}/jobs', 'CompanyController@job');
    $api->get('companies/{company}/products', 'CompanyController@product');

    /**
     * 需求
     */
    $api->get('demands', 'DemandController@index');
    $api->get('demands/{demand}', 'DemandController@show');

    /**
     * 供应
     */
    $api->get('supplies', 'SupplyController@index');
    $api->get('supplies/{supply}', 'SupplyController@show');

    /**
     * 论坛
     */
    $api->get('topics/categories', 'TopicController@categories');
    $api->get('topics/categories/{id}', 'TopicController@index');
    $api->get('topics/{topic}', 'TopicController@show');

    /**
     * 产品
     */
    $api->get('products/{product}', 'ProductController@show');

    //收藏
    $api->resource('/favorites', 'FavoriteController', ['except' => 'index']);

    /**
     * 用户
     */
    $api->post('login', 'AuthController@authenticate');
    $api->post('register', 'AuthController@register');
    $api->get('users', 'AuthController@index');
    //单个用户
    $api->put('password/reset', 'AuthController@reset');
    //单个用户
    $api->get('users/{user}', 'AuthController@userInfo');
    //发送验证码
    $api->post('verifycode', 'AuthController@verifyCode');
    //获取用户话题
    $api->get('users/{user}/topics', 'TopicController@indexByUserId');
    //获取用户点赞
    $api->get('users/{id}/votes', 'TopicController@indexByUserVotes');

    //需要认证权限
    $api->group(['middleware' => 'passport:api'], function ($api) {
        //登录用户信息
        $api->get('users/me', 'AuthController@me');
        //更新个人信息
        $api->patch('users', 'AuthController@update');
        //修改密码
        $api->put('users/password', 'AuthController@editPassword');
        //评论
        $api->post('news/{id}/comment', 'CommentController@store');
        //加盟
        $api->get('companies/{company}/join-certification', 'CompanyController@joinAndCertification');
        $api->post('companies/{company}/joins', 'CompanyController@joinStore');
        $api->post('companies/{company}/certifications', 'CompanyController@certificationStore');
        //需求
        $api->resource('demands', 'DemandController', ['except' => ['index', 'create', 'show']]);
        $api->get('users/demands', 'DemandController@indexByUser');
        //供应
        $api->resource('supplies', 'SupplyController', ['except' => ['index', 'create', 'show']]);
        $api->get('users/supplies', 'SupplyController@indexByUser');
        //话题
        $api->resource('topics', 'TopicController', ['except' => ['index', 'create', 'show']]);
        $api->get('users/topics', 'TopicController@indexByUser');
        //点赞和取消赞
        $api->post('topics/{topic}/vote-up', 'TopicController@voteUp');
        $api->post('topics/{topic}/vote-down', 'TopicController@voteDown');
        //产品
        $api->resource('products', 'ProductController', ['except' => ['create', 'show']]);
    });
});
