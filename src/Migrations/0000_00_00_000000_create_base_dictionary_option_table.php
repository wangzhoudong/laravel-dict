<?php
/**
 * User: Wangzd
 * Time: 上午10:32
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseDictionaryOptionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('base_dictionary_option', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('dictionary_table_code', '32')->comment('数据字典表');
            $table->char('dictionary_code', '32')->comment('数据字典代码');
            $table->char('key', '32')->comment('程序中使用，数据库使用value');
            $table->char('value', '32')->comment('编码');
            $table->string('name', '256')->comment('名称');
            $table->string('input', '256')->default('')->comment('输入码，通常用于保留拼音');
            $table->integer('sort')->default(0)->comment('排序');
            $table->nullableTimestamps();
            $table->softDeletes();
//            $table->primary('id');
            $table->index('deleted_at');
            $table->index(['dictionary_table_code', 'dictionary_code'],'idx_tablecode_code');
        });
        //加入测试数据
        \DB::table('base_dictionary_option')->insert(['dictionary_table_code'=>'global','dictionary_code'=>'bool','key'=>'no','value'=>'0','name'=>'否','sort'=>1,'input'=>'N']);
        \DB::table('base_dictionary_option')->insert(['dictionary_table_code'=>'global','dictionary_code'=>'bool','key'=>'yes','value'=>'1','name'=>'是','sort'=>2,'input'=>'Y']);
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('base_dictionary_option');
    }
}
