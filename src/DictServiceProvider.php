<?php

namespace LWJ\Dict;

use Illuminate\Support\ServiceProvider;
use LWJ\Dict\Contracts\DictInterface;


class DictServiceProvider extends ServiceProvider
{
    /**
     * 服务提供者是否延迟加载
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                //配置文件
                __DIR__ . '/config.php'                                                             => config_path(
                    'dict.php'),
                //迁移文件
                __DIR__.'/Migrations/0000_00_00_000000_create_base_dictionary_option_table.php' => database_path(
                    'migrations/0000_00_00_000000_create_base_dictionary_option_table.php'
                ),
            ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(DictInterface::class, Dict::class);
        $this->mergeConfigFrom(__DIR__.'/config.php', 'financeReceivable');
    }

    /**
     * 获取由提供者提供的服务.
     * @return array
     */
    public function provides()
    {
        return [DictInterface::class];
    }
}
