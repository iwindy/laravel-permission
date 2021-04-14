
## 发布资源
~~~
php artisan vendor:publish --provider="Iwindy\LaravelPermission\PermissionServiceProvider"
~~~

## 数据迁移
~~~
php artisan migrate
~~~

## 设置路由权限名称
~~~php
Route::get('home', 'Home@index')->auth('首页');
Route::post('system', 'SystemController@seting')->auth('系统', '设置');

// 资源路由
Route::resource('users', App\Http\Controllers\UserController::class)->auth('用户管理');
Route::resource('users', App\Http\Controllers\UserController::class)->auth('User',[
    'index' => '用户列表',
    'create' => '创建用户',
]);
~~~

## 获取权限节点
~~~php
    use Iwindy\LaravelPermission\Facade\Permission;
    
    // 获取树状权限节点
    Permission::getAuthNodesTree();
    // 获取完整的权限节点
    Permission::generateFullNodes();
    // 获取所有路由的权限节点
    Permission::getNodes();
~~~
