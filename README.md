# Tencent Map with search for Laravel-admin


这个扩展用来帮助你在 form 表单中通过使用腾讯地图搜索地址和点击地图来获取经纬度。


## 截图

<img width="916" alt="搜索地址" src="https://user-images.githubusercontent.com/2421068/53468061-ab4c0400-3a93-11e9-8a41-4c320733af3d.png">

## 安装

```bash
composer require jxlwqq/tencent-map
```

## 配置

打开config/admin.php，按照你的情况在extensions部分加上如下的配置：

```
    'extensions' => [
        'tencent-map' => [
            'enable' => true,
            'api_key' => env('TENCENT_MAP_API_KEY')
        ]
    ]
```

api_key 在 [腾讯位置服务控制台 -> key管理](https://lbs.qq.com/dev/console/key/manage) 创建。

## 使用

假设你的表中有两个字段`latitude`和`longitude`分别表示纬度和经度，那么在表单中使用如下：

```php
$form->tencentMap('latitude', 'longitude', '经纬度');

// 设置地图高度
$form->tencentMap('latitude', 'longitude', '经纬度')->height(500);

// 设置地图缩放
$form->tencentMap('latitude', 'longitude', '经纬度')->zoom(13);

// 设置默认值
$form->tencentMap('latitude', 'longitude', '经纬度')->default(['lat' => 90, 'lng' => 90]);
```

## License

Licensed under [The MIT License (MIT)](LICENSE).
