<?php
/**
 * User: Wangzd
 * Time: 上午10:32
 */

namespace Wangzd\Dict\Facades;

use Illuminate\Support\Facades\Facade;
use Wangzd\Dict\Contracts\DictInterface;

class Dict extends Facade {
    /**
     *
     * Get the registered name of the component.
     *
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
//        return 'Receivable';
        return DictInterface::class;
    }
}
