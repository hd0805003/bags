#### Http Code 说明
````
200 OK - [GET]：服务器成功返回用户请求的数据。
201 Created - [POST/PUT/PATCH]：用户新建或修改数据成功。
202 Accepted - [*]：表示一个请求已经进入后台排队（异步任务）
204 No Content - [DELETE]：用户删除数据成功。
304 Not Modified - [GET]：如果客户端发送了一个带条件的 GET 请求且该请求已被允许，而文档的内容（自上次访问以来或者根据请求的条件）
并没有改变，则服务器应当返回这个状态码。
400 Bad Request - [POST/PUT/PATCH]：用户发出的请求有错误，服务器没有进行新建或修改数据的操作。
401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
403 Forbidden - [*] 表示用户得到授权（与401错误相对），但是访问是被禁止的。
404 Not Found - [*]：用户发出的请求针对的是不存在的记录，服务器没有进行操作。
406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。
410 Gone -[GET]：用户请求的资源被永久删除，且不会再得到的。
422 Unprocessable Entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
500 Internal Server Error - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。
````

#### 权限说明
权限: 无-------则不需要登录。  
权限: 认证----则需要登录。

#### 公司类型
http://www.xxx.com/api/companies/role/:id  
:id为0则列表公司为（采购商）和（供应商）  
:id为1则列表公司为（采购商）  
:id为2则列表公司为（供应商）  
:id为3则列表公司为（机构/单位）  


#### 申请加盟和申请认证的状态  
status=0 已驳回  
status=1 待审核(待处理)  
status=2 已通过  

#### Unit单位
['1'=>'只', '2'=>'个', '3'=>'扎', '4'=>'袋', '5'=>'箱']

#### 分享说明
分享App链接 http://m.51hbjjd.com  
新闻链接 http://m.51hbjjd.com/news/:id  
公司链接 http://m.51hbjjd.com/companies/:id  
展会链接 http://m.51hbjjd.com/exhibitions/:id  
论坛链接 http://m.51hbjjd.com/topics/:id/:token  
产品链接 http://m.51hbjjd.com/products/:id  
需求链接 http://m.51hbjjd.com/demands/:id  
供应链接 http://m.51hbjjd.com/supplies/:id  


#### 消息说明
##### 互动消息
id - 话题ID  
'type' => 'App\Models\Topic' - 论坛话题  
接口请求地址 get http://stone.dev/api/topics/:id
##### 系统消息
'notification_type' => 'App\Models\News' - 资讯  
接口请求地址 get http://stone.dev/api/news/:id //:id为notification_id  
'notification_type' => 'App\Models\Exhibition' - 展会  
接口请求地址 get http://stone.dev/api/news/:id //:id为notification_id  
'notification_type' => 'App\Models\Join' - 申请加盟  
接口请求地址 get http://stone.dev/api/users/joins  
'notification_type' => 'App\Models\Certification' - 申请认证  
接口请求地址 get http://stone.dev/api/users/certifications  
'notification_type' => 'App\Models\Topic' - 论坛话题    
接口请求地址 get http://stone.dev/api/topics/:id //:id为notification_id  
'notification_type' => 'App\Models\Reply' - 话题回复  
接口请求地址 get http://stone.dev/api/topics/:id //:id为notification_id  



#### meta说明

````
    "meta": {
        "pagination": {
            "total": 195,
            "count": 15,
            "per_page": 15,
            "current_page": 2,
            "total_pages": 13,
            "links": {
                "previous": "http://www.xxx.com/topics?page=1",
                "next": "http://www.xxx.com/topics?page=3"
            }
        }
    }
````
以上代码在列表中会出现，主要是数据统计，信息总条数，一页多少条，当前页码，总共多少页，links包含上一页、下一页等数据。