## 数据字典
laravel-dict是一个用于管理系统常用的配置的简单封装.提高代码的扩展性，可以易读性

## 使用

###获取配置数组
```php
    Dict::get("global","bool");// 返回：[0=>'否',1=>'是']
    Dict::get("order","status");// 返回：[0=>'待下单',1=>'待支付',2=>'待发货',3=>'已完成']
```
###获取具体内容    
```php
    Dict::get("global","bool","0");// 返回：否
    Dict::get("order","status","1");// 返回：待支付
    #使用场景
    foreach($orderList as $order) {
        echo '订单是否删除:' . Dict::get("global","bool",$order['is_del']);//否
        echo '订单状态:' . Dict::get("order","status",$order['status']);//待支付
    }
```
###易读的代码判断
```php
    Dict::value("order","status","wait_pay"); //等待支付状态 返回：1
    if($orderStatus == Dict::value("order","status","wait_pay") {
        //如果订单状态是待支付    
    }
    
    Dict::valueName("order","status","wait_pay"); 返回 待支付
```    
###方便的HTML操作
```html
       {{Dict::select("order","status",1,['name'=>'order_status']);}} 
        返回：
        <select name="order_status">
            <option value="0">待下单</option>
            <option value="1" selected>待支付</option>
            <option value="2">待发货</option>
            <option value="3">已完成</option>
        </select>
        
        <select name="order_status">
            {{Dict::option("order","status",1,['name'=>'order_status']);}} 
        </select>
```
###添加/修改/删除
```php
    //建议直接在数据库维护base_dictionary_option表
	#添加
    Dict::add($table_code,$code,$key,$value,$name,$sort=0,$input='');//obj
    Dict::add('global','bool','yes','0','否');//obj
    #修改
    Dict::edit('global','bool',['yes','0','否]);//bool
    #删除
    Dict::delete('global','bool');/bool 
```

    
###手动更新缓存
```php
    //如果在数据库添加，需要单独条用该方法
    Dict::updateCache();
```
## 安装

使用
`composer require "liweijia/laravel-dict:*"`

## 配置

### Laravel应用
1. 注册 `ServiceProvider`:
```php
Wangzd\Dict\DictServiceProvider::class,
```
```

2. 创建配置和迁移文件
```shell
php artisan vendor:publish
```

3. 可以选择修改根目录下的`config/dict.php`中对应的修改设置

4. 执行迁移命令,生成数据表
```shell
php artisan migrate
```

5.添加门面到`config/app.php`中的`aliases`部分:
```php
'Dict' => Wangzd\Dict\Facades\Dict::class
```

### Lumen应用

1. 在`bootstrap/app.php`的 `82` 行左右:
```php
$app->register(LWJ\User\DictServiceProvider::class);
```

2. ENV中支持以下配置
```php
DICT_CACHE_ENABLE
```

3. 如果要使用`config/dict.php`来配置的话,将`vendor/liweijia/dict/src/config.php`拷贝到`config/`,并将文件名改成`dict.php`




## License

MIT
