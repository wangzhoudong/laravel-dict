<?php
return [
    //是否使用缓存,0为不启用,其他值为启用(尚未实现)
    'cache_enable' => env('USER_CACHE_ENABLE', 0),
    //状态
    'status' => [

        //审核失败
        'audit_fail' => '-1',

        //待审核
        'wait_audit' => '1',

        //已审核
        'audit_success' => '2'

    ],
];