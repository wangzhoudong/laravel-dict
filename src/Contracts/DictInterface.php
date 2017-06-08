<?php
/**
 * User: Wangzd
 * Time: 上午10:32
 */

namespace Wangzd\Dict\Contracts;


interface DictInterface
{

    /*
         * 添加一条数据
         */
    public function add($table_code,$code,$key,$value,$name,$sort=0,$input='');
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
    /**
     * 根据key获取value
     * Dict::value('global','bool','no') 返回 “0”
     * @author wangzd
     *
     * @param string $table_code 数据字典的类型
     * @param string $code 数据字典代码
     * @param string $key 数据字典key字段
     *
     * @return mix  返回数据字典中key对应的value
     *
     *
     */
    public function value($table_code, $code, $key);
    /**
     * 根据KEy获取名称
     * Dict::valueName('global','bool','no') 返回 “否”
     * @param $table_code
     * @param $code
     * @param $key
     * @return string
     */
    public function valueName($table_code, $code, $key);

    /**
     * 根据数据字典生产HTML的select
     * @param string $table_code 数据字典的类型
     * @param string $code 数据字典代码
     * @param string $selection 被选中的值。
     * @param array $htmlOptions  额外的HTML属性。如name='cate' ,id='cate'下面两个特定的属性是被认可：
     * 						      empty: 字符串，指定空选项的文本，它的值为空。
     * 							       'empty'选项也可以是一个值-标签对形式的数组。
     * 							                  在一开始每个对都会用于渲染一个列表的选项。注意，
     *  							       文本标签不会被HTML编码。
     *
     *
     */
    public function select($table_code, $code, $selection=null, $htmlOptions=array());
    /**
     * 根据数据字典生产HTML的option
     * @param $table_code
     * @param $code
     * @param null $selection  选中的值
     * @return string
     */
    public function option($table_code,$code,$selection=null);

    /**
     *  更新缓存
     *
     * @author wangzhoudong
     * @return bool  返回成功失败
     * @throws CException
     */
    public function updateCache();
}