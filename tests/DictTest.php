<?php
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

class DictTest extends PHPUnit_Framework_TestCase
{

    public function testGetArray(){
        $this->assertArrayHasKey('0',Dict::get('global',"bool"));
    }
    public function testGetValue(){
        $this->assertEquals('否',Dict::get('global',"bool",0));
    }

    public function testValueGet() {
        $this->assertEquals('0',Dict::get('global',"bool",'no'));
    }

    public function testValueName() {
        $this->assertEquals('否',Dict::get('global',"bool",'no'));
    }

}