<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/6/8
 * Time: 10:39
 */
namespace Wangzd\Dict;


use Wangzd\Dict\Models\BaseDictionaryOptionModel;
use Cache;
class DictCache {
    public static function update() {
        $oData = BaseDictionaryOptionModel::all();
        $dict = $keyDict = $keyNameDict = array();

        foreach($oData as $key=>$value) {
            $dict[$value->dictionary_table_code][$value->dictionary_code][$value->value] = $value->name;
            $keyDict[$value->dictionary_table_code][$value->dictionary_code][$value->key] = ['value'=>$value->value,'name'=>$value->name];
        }
        Cache::forever(config("dict.cache_key"),['get'=>$dict,'value'=>$keyDict]);
        return true;
    }

    public static function get($type='get') {
        if(!Cache::has(config("dict.cache_key"))) {
            self::update();
        }
        $data = Cache::get(config("dict.cache_key"));
        if(isset($data[$type])) {
            return $data[$type];
        }
        return null;
    }
}