<?php
/**
 * Created by PhpStorm.
 * User: wangzd
 * Time: 上午10:32
 */

namespace Wangzd\Dict\Contracts;


interface DictInterface
{


    /**
     * 取得数据字典对应数据
     *
     * @author wangzhoudong
     * @param string $table_code 数据字典的类型
     * @param string $code 数据字典代码
     * @param string $val 数据字典数据对应下标
     * @return array  返回数据字典数组
     * @throws CException  $table_code,$code 不能为空
     *
     */
    public function get($table_code,$code,$val=null) ;


}