## 数据字典

laravel-dict是一个用于管理系统常用的变量的简单封装.

## 安装

使用
`composer require "liweijia/laravel-dict:*"`

## 配置

### Laravel应用
1. 注册 `ServiceProvider`:
```php
LWJ\Dict\DictServiceProvider::class,
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
'Dict' => LWJ\WoodFinance\Facades\Dict::class,
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

## 使用

### Api列表



## License

MIT
