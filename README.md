# Dcat Admin Extension


### 通过 composer 安装扩展
```shell
  composer require ake/multilevel
```


### 发布静态资源
```shell
  php artisan vendor:publish --tag=weiwait.dcat-distpicker
```

```php
$this->multilevel(['prov_id', 'city_id', 'dist_id'], '省市区') 
    // 第一个参数是多级联动的字段名，第二个字段文字显示
    ->load(['api/getArea'], 0) 
    //联动请求url  第一个参数默认使用第一个，如果需要不同的链接，则一一对应即可（获取city_id列，填在一个元素；dist_id列，填在第二个元素），
    //第二个参数是否是使用函数admin_url()生成链接
    ->options(['1', 2,3]) 
    //第一列数据
    ->required();
```
       