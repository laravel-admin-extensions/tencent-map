<?php

namespace Jxlwqq\TencentMap;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;

class TencentMapServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Extension $extension)
    {
        if (! Extension::boot()) {
            return ;
        }

        $this->loadViewsFrom($extension->views(), 'laravel-admin-tencent-map');

        Admin::booting(function () {
            Form::extend('tencentMap', TencentMap::class);
        });
    }
}
