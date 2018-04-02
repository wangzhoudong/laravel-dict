<?php
namespace Wangzd\Tests\Dict;

use PHPUnit\Framework\Assert as PHPUnit;

/**
 *------------------------------------------------------
laravel-dict是一个用于管理系统常用的变量的简单封装.提高代码的扩展性，可以易读性
 *------------------------------------------------------
 *
 * @author    wangzhoudong@foxmail.com
 * @date      2017/05/25 07:34
 * @version   V1.0
 *
 */

class DictTest 
{

    public function testGetArray(){
        PHPUnit::assertEquals('0',Dict::get('global',"bool"));
    }
    public function testGetValue(){
        PHPUnit::assertEquals('否',Dict::get('global',"bool",0));
    }

    public function testValueGet() {
        PHPUnit::assertEquals('0',Dict::get('global',"bool",'no'));
    }

    public function testValueName() {
        PHPUnit::assertEquals('否',Dict::get('global',"bool",'no'));
    }

}