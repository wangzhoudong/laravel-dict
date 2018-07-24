<?php
/**
 *------------------------------------------------------
 * laravel-dict是一个用于管理系统常用的变量的简单封装.提高代码的扩展性，可以易读性
 *------------------------------------------------------
 *
 * @author    wangzhoudong@foxmail.com
 * @date      2017/05/25 07:34
 * @version   V1.0
 *
 */

namespace Wangzd\Dict;


use Wangzd\Dict\Contracts\DictInterface;
use Wangzd\Dict\Models\BaseDictionaryOptionModel;

class Dict implements DictInterface
{

    public $cacheType;

    /**
     * @param $table_code 数据字典表
     * @param $code 数据字典代码
     * @param $key 程序中使用，数据库使用value
     * @param $value 编码
     * @param $name 名称
     * @param int $sort 排序
     * @param string $input 输入码，通常用于保留拼音
     * @return mixed
     */
    public function add($table_code, $code, $key, $value, $name, $sort = 0, $input = '')
    {
        $data = ['dictionary_table_code' => $table_code, 'dictionary_code' => $code, 'key' => $key, 'value' => $value, 'name' => $name, 'sort' => $sort, 'input' => $input];
        $obj = BaseDictionaryOptionModel::create($data);
        $this->updateCache();
        return $obj;
    }

    /**
     * 修改
     * @param $table_code 数据字典表
     * @param $code 数据字典代码
     * @param $edit
     * @return mixed
     */
    public function edit($table_code, $code, $edit)
    {
        $obj = BaseDictionaryOptionModel::where('dictionary_table_code', $table_code)->where('code', $code)->update($edit);
        $this->updateCache();
        return $obj;
    }

    /**
     * 删除
     * @param $table_code 数据字典表
     * @param $code 数据字典代码
     * @param $edit
     * @return mixed
     */
    public function delete($table_code, $code)
    {
        $obj = BaseDictionaryOptionModel::where('dictionary_table_code', $table_code)->where('code', $code)->delete();
        $this->updateCache();
        return $obj;
    }


    /**
     * 取得数据字典对应数据
     * 如：Dict::get("global","bool") 返回：[0=>'否',1=>'是']
     * 如：Dict::get("global","bool","0") 返回：否
     *
     * @author wangzhoudong
     * @param string $table_code 数据字典的类型
     * @param string $code 数据字典代码
     * @param string $val 数据字典数据对应下标
     * @return array|string  返回数据字典数组
     * @throws CException  $table_code,$code 不能为空
     *
     */

    public function get($table_code, $code, $val = null)
    {
        $data = DictCache::get('get');
        if (isset($data[$table_code][$code])) {
            $arr = $data[$table_code][$code];
        } else {
            return null;
        }
        if ($val !== null) {
            if (array_key_exists($val, $arr)) {
                return $arr[$val];
            } else {
                return null;
            }
        }
        return $arr;
    }


    public function getKey($table_code, $code, $val = null)
    {
        $data = DictCache::get('valueKey');
        if (isset($data[$table_code][$code])) {
            $arr = $data[$table_code][$code];
        } else {
            return null;
        }
        if ($val !== null) {
            if (array_key_exists($val, $arr)) {
                return $arr[$val];
            } else {
                return null;
            }
        }
        return $arr;
    }

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
    public function value($table_code, $code, $key = null)
    {
        $data = DictCache::get('value');

        $arr = isset($data[$table_code][$code]) ? $data[$table_code][$code] : null;

        if ($key !== null) {
            return isset($arr[$key]) ? $arr[$key]['value'] : null;
        }

        return $arr;
    }

    /**
     * 根据KEy获取名称
     * Dict::valueName('global','bool','no') 返回 “否”
     * @param $table_code
     * @param $code
     * @param $key
     * @return string
     */
    public function valueName($table_code, $code, $key)
    {
        $data = DictCache::get('value');
        if (isset($data[$table_code][$code][$key])) {
            return $data[$table_code][$code][$key]['name'];
        }
        return null;
    }




    /**
     * 根据数据字典生产HTML的select
     * @param string $table_code 数据字典的类型
     * @param string $code 数据字典代码
     * @param string $selection 被选中的值。
     * @param array $htmlOptions 额外的HTML属性。如name='cate' ,id='cate'下面两个特定的属性是被认可：
     *                              empty: 字符串，指定空选项的文本，它的值为空。
     *                                   'empty'选项也可以是一个值-标签对形式的数组。
     *                                              在一开始每个对都会用于渲染一个列表的选项。注意，
     *                                   文本标签不会被HTML编码。
     *
     *
     */
    public function select($table_code, $code, $selection = null, $htmlOptions = array())
    {
        $selectOption = $htmlOptions;
        unset($selectOption['empty']);
        $html = "<select ";
        foreach ($htmlOptions as $key => $val) {
            $html .= " $key='$val'";
        }
        $html .= ' >';
        if (isset ($htmlOptions ['empty'])) {
            $value = "";
            $label = $htmlOptions ['empty'];
            if (is_array($label)) {
                $value = array_keys($label);
                $value = $value [0];
                $label = array_values($label);
                $label = $label [0];
            }
            $html .= '<option value="' . $value . '">' . ($label) . "</option>\n";
        }
        $optionHtml = $this->option($table_code, $code, $selection);
        $html .= $optionHtml;
        $html .= "</select>";
        return $html;
    }

    /**
     * 根据数据字典生产HTML的option
     * @param $table_code
     * @param $code
     * @param null $selection 选中的值
     * @return string
     */
    public function option($table_code, $code, $selection = null)
    {
        $data = $this->get($table_code, $code);
        $html = "";
        foreach ($data as $k => $v) {
            $html .= "<option value='$k'";
            if ($k == $selection && $selection !== null) {
                $html .= " selected";
            }
            $html .= ">$v</option>";
        }
        return $html;
    }

    /**
     *  更新缓存
     *
     * @author wangzhoudong
     * @return bool  返回成功失败
     * @throws CException
     */
    public function updateCache()
    {
        return DictCache::update();
    }

}
