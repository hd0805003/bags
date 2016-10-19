<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * 自定义验证规则(只能由小写字母组成且首字母必须大写！)
         */
        Validator::extend('alpha_dash_upr_first', function ($attribute, $value, $parameters) {
            if (!preg_match('/^[A-Z]+[a-z]*$/', $value)) {
                return false;
            }
            return true;
        });

        /**
         * 自定义验证规则(只能由小写字母、横杠组成)
         */
        Validator::extend('alpha_dash_except_num', function ($attribute, $value, $parameters) {
            if (!preg_match('/^[a-z\-]*$/', $value)) {
                return false;
            }
            return true;
        });

        /**
         * 自定义验证规则(手机)
         */
        Validator::extend('is_mobile', function ($attribute, $value, $parameters) {
            if (!preg_match('/^(\+?0?86\-?)?((13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7})$/', $value)) {
                return false;
            }
            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        
        /**
         * 新闻
         */
        $this->app->bind(
            \App\Repositories\Backend\News\NewsInterface::class,
            \App\Repositories\Backend\News\NewsRepository::class
        );

        /**
         * 新闻分类
         */
        $this->app->bind(
            \App\Repositories\Backend\News\CategoryInterface::class,
            \App\Repositories\Backend\News\CategoryRepository::class
        );

        /**
         * 标签
         */
        $this->app->bind(
            \App\Repositories\Backend\Tags\TagsInterface::class,
            \App\Repositories\Backend\Tags\TagsRepository::class
        );

        /**
         * 公司
         */
        $this->app->bind(
            \App\Repositories\Backend\Companies\CompaniesInterface::class,
            \App\Repositories\Backend\Companies\CompaniesRepository::class
        );

        /**
         * 公司分类
         */
        $this->app->bind(
            \App\Repositories\Backend\Companies\CategoryInterface::class,
            \App\Repositories\Backend\Companies\CategoryRepository::class
        );
    }
}