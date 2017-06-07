<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 17-1-5
 * Time: 上午10:31
 */

namespace Wangzd\Dict;


use Wangzd\Dict\Contracts\DictInterface;
use Wangzd\Dict\Models\BaseDictionaryOptionModel;
use Cache;
class Dict implements DictInterface{

    public $cacheType;

    private $mmCache = 'table_dictionary_option_all';
    private $keyDictCache = 'table_dictionary_key_value';

    private $dict;
    private $keyDict;

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

    public function get($table_code,$code,$val=null) {
        $mKey = Cache::get($this->mmCache);
        if(isset($mKey[$table_code][$code])) {
            $arr =  $mKey[$table_code][$code];
        }else{
            $this->update($table_code,$code);
            if(isset($this->dict[$table_code][$code])) {
                $arr =  $this->dict[$table_code][$code];
            }else{
                $arr = [];
            }
        }
        if(!$arr) {
            return null;
        }
        if($val !== null) {

            if(array_key_exists($val, $arr)) {
                return $arr[$val];
            }else{
                return '';
            }
        }else{
            return $arr;
        }
    }


    /**
     * 根据key获取value
     *
     * @author xmxtc
     *
     * @param string $table_code 数据字典的类型
     * @param string $code 数据字典代码
     * @param string $key 数据字典key字段
     *
     * @return mix  返回数据字典中key对应的value
     *
     *
     */

    public function value($table_code, $code, $key)
    {
        $mKey = Cache::get($this->keyDictCache);

        if(isset($mKey[$table_code][$code][$key])) {
            return $mKey[$table_code][$code][$key];
        }

        $this->update();

        if(isset($this -> keyDict[$table_code][$code][$key])) {
            return  $this -> keyDict[$table_code][$code][$key];
        }
        return '';
    }


    /**
     *
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
    public function select($table_code, $code, $selection=null, $htmlOptions=array()) {
        $selectOption = $htmlOptions;
        unset($selectOption['empty']);
        $html = "<select ";
        foreach($htmlOptions as $key=>$val) {
            $html .= " $key='$val'";
        }
        $html .= ' >';
        if (isset ( $htmlOptions ['empty'] )) {
            $value = "";
            $label = $htmlOptions ['empty'];
            if (is_array ( $label )) {
                $value = array_keys ( $label );
                $value = $value [0];
                $label = array_values ( $label );
                $label = $label [0];
            }
            $html .= '<option value="' . $value . '">' . ($label) . "</option>\n";
        }
        $optionHtml =  $this->option($table_code, $code,$selection);
        $html .= $optionHtml;
        $html .= "</select>";
        return $html;
    }

    public function option($table_code,$code,$selection=null) {
        $data = $this->get($table_code,$code);
        $html = "";
        foreach ($data as $k=>$v) {
            $html .= "<option value='$k'";
            if($k==$selection && $selection!==null) {
                $html .= " selected";
            }
            $html .= ">$v</option>";
        }
        return $html;
    }

    /**
     * 更新对应数据字典，如参数都为空全部更新
     *
     * @author wangzhoudong
     * @param string $table_code 需要更新的类型
     * @param string $code 需要更新的代码
     * @return bool  返回成功失败
     * @throws CException
     *
     */
    public function update() {
        $oData = BaseDictionaryOptionModel::all();
        $dict = $keyDict = array();

        foreach($oData as $key=>$value) {
            $dict[$value->dictionary_table_code][$value->dictionary_code][$value->value] = $value->name;
            $keyDict[$value->dictionary_table_code][$value->dictionary_code][$value->key] = $value->value;
        }

        $this->dict = $dict;
        $this->keyDict = $keyDict;

        Cache::forever($this->mmCache,$this->dict);
        Cache::forever($this->keyDictCache,$this->keyDict);

        return true;
    }

    /**
     * 获取联动数据
     * @param $table_code
     * @param $code
     */
    public function linkageData($table_code, $code)
    {
        $array = [];
        $data = BaseDictionaryOptionModel::
            where("dictionary_table_code", $table_code)
            ->where("dictionary_code", $code)
            ->where("key", "")
            ->orderBy("sort", "DESc")
            ->get()->toArray();
        foreach($data AS $key => $item){
            $array[$key] = $item;
            $array[$key]['childs'] = BaseDictionaryOptionModel::
                 where("dictionary_table_code", $table_code)
                ->where("dictionary_code", $code)
                ->where("key", $item['value'])
                ->orderBy("sort", "DESc")
                ->get()->toArray();
        }
        return $array;
    }

    /**
     * 清除缓存
     */
    public function clear() {
        Cache::forget($this->mmCache);
        Cache::forget($this->keyDictCache);
    }

}
