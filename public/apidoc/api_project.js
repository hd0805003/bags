define({
  "name": "Stone Api",
  "version": "1.0.0",
  "description": "接口文档",
  "title": "接口文档",
  "url": "http://stone.dev/api",
  "header": {
    "title": "接口说明",
    "content": "<h4>Http Code 说明</h4>\n<pre><code>200 OK - [GET]：服务器成功返回用户请求的数据。\n201 Created - [POST/PUT/PATCH]：用户新建或修改数据成功。\n202 Accepted - [*]：表示一个请求已经进入后台排队（异步任务）\n204 No Content - [DELETE]：用户删除数据成功。\n304 Not Modified - [GET]：如果客户端发送了一个带条件的 GET 请求且该请求已被允许，而文档的内容（自上次访问以来或者根据请求的条件）\n并没有改变，则服务器应当返回这个状态码。\n400 Bad Request - [POST/PUT/PATCH]：用户发出的请求有错误，服务器没有进行新建或修改数据的操作。\n401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。\n403 Forbidden - [*] 表示用户得到授权（与401错误相对），但是访问是被禁止的。\n404 Not Found - [*]：用户发出的请求针对的是不存在的记录，服务器没有进行操作。\n406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。\n410 Gone -[GET]：用户请求的资源被永久删除，且不会再得到的。\n422 Unprocessable Entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。\n500 Internal Server Error - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。\n</code></pre>\n<h4>权限说明</h4>\n<p>权限: 无-------则不需要登录。<br>\n权限: 认证----则需要登录。</p>\n<h4>公司类型</h4>\n<p>http://www.xxx.com/api/companies/role/:id<br>\n:id为0则列表公司为（采购商）和（供应商）<br>\n:id为1则列表公司为（采购商）<br>\n:id为2则列表公司为（供应商）<br>\n:id为3则列表公司为（机构/单位）</p>\n<h4>申请加盟和申请认证的状态</h4>\n<p>status=0 已驳回<br>\nstatus=1 待审核(待处理)<br>\nstatus=2 已通过</p>\n<h4>Unit单位</h4>\n<p>['1'=&gt;'只', '2'=&gt;'个', '3'=&gt;'扎', '4'=&gt;'袋', '5'=&gt;'箱']</p>\n<h4>分享说明</h4>\n<p>分享App链接 http://m.51hbjjd.com<br>\n新闻链接 http://m.51hbjjd.com/news/:id<br>\n公司链接 http://m.51hbjjd.com/companies/:id<br>\n展会链接 http://m.51hbjjd.com/exhibitions/:id<br>\n论坛链接 http://m.51hbjjd.com/topics/:id/:token<br>\n产品链接 http://m.51hbjjd.com/products/:id<br>\n需求链接 http://m.51hbjjd.com/demands/:id<br>\n供应链接 http://m.51hbjjd.com/supplies/:id</p>\n<h4>消息说明</h4>\n<h5>互动消息</h5>\n<p>id - 话题ID<br>\n'type' =&gt; 'App\\Models\\Topic' - 论坛话题<br>\n接口请求地址 get http://stone.dev/api/topics/:id</p>\n<h5>系统消息</h5>\n<p>'notification_type' =&gt; 'App\\Models\\News' - 资讯<br>\n接口请求地址 get http://stone.dev/api/news/:id //:id为notification_id<br>\n'notification_type' =&gt; 'App\\Models\\Exhibition' - 展会<br>\n接口请求地址 get http://stone.dev/api/news/:id //:id为notification_id<br>\n'notification_type' =&gt; 'App\\Models\\Join' - 申请加盟<br>\n接口请求地址 get http://stone.dev/api/users/joins<br>\n'notification_type' =&gt; 'App\\Models\\Certification' - 申请认证<br>\n接口请求地址 get http://stone.dev/api/users/certifications<br>\n'notification_type' =&gt; 'App\\Models\\Topic' - 论坛话题<br>\n接口请求地址 get http://stone.dev/api/topics/:id //:id为notification_id<br>\n'notification_type' =&gt; 'App\\Models\\Reply' - 话题回复<br>\n接口请求地址 get http://stone.dev/api/topics/:id //:id为notification_id</p>\n<h4>meta说明</h4>\n<pre><code>    &quot;meta&quot;: {\n        &quot;pagination&quot;: {\n            &quot;total&quot;: 195,\n            &quot;count&quot;: 15,\n            &quot;per_page&quot;: 15,\n            &quot;current_page&quot;: 2,\n            &quot;total_pages&quot;: 13,\n            &quot;links&quot;: {\n                &quot;previous&quot;: &quot;http://www.xxx.com/topics?page=1&quot;,\n                &quot;next&quot;: &quot;http://www.xxx.com/topics?page=3&quot;\n            }\n        }\n    }\n</code></pre>\n<p>以上代码在列表中会出现，主要是数据统计，信息总条数，一页多少条，当前页码，总共多少页，links包含上一页、下一页等数据。</p>\n"
  },
  "order": [
    "Homepage",
    "Auth",
    "Notify",
    "Favorite",
    "Company",
    "News",
    "Exhibition",
    "Topic",
    "Product",
    "Demand",
    "Supply",
    "Area",
    "Upload"
  ],
  "template": {
    "withCompare": true,
    "withGenerator": true
  },
  "sampleUrl": false,
  "apidoc": "0.2.0",
  "generator": {
    "name": "apidoc",
    "time": "2017-01-06T03:12:05.495Z",
    "url": "http://apidocjs.com",
    "version": "0.16.1"
  }
});
