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

class DictCache
{
    private static $tagName = 'wangzd-dict-cache';

    public static function update()
    {
        $oData = BaseDictionaryOptionModel::all();
        $dict = $keyDict = $keyNameDict = array();

        foreach ($oData as $key => $value) {
            $dict[$value->dictionary_table_code][$value->dictionary_code][$value->value] = $value->name;
            $valueKey[$value->dictionary_table_code][$value->dictionary_code][$value->value] = $value->key;
            $keyDict[$value->dictionary_table_code][$value->dictionary_code][$value->key] = ['value' => $value->value, 'name' => $value->name];
        }
        self::cache()->forever(config("dict.cache_key"), ['get' => $dict, 'value' => $keyDict, 'valueKey' => $valueKey]);
        return true;
    }

    private static function cache()
    {
        $cacheDriver = config('cache.default');
        if (in_array($cacheDriver, ['file', 'database']))
            return Cache::store();
        else
            return Cache::tags(self::$tagName);
    }

    public static function get($type = 'get')
    {
        if (!self::cache()->has(config("dict.cache_key"))) {
            self::update();
        }
        $data = self::cache()->get(config("dict.cache_key"));
        if (isset($data[$type])) {
            return $data[$type];
        }
        return null;
    }
}
