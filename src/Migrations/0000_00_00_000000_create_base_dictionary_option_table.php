<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseDictionaryOption extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('base_dictionary_option', function (Blueprint $table) {
            $table->increments('id');
            $table->char('dictionary_table_code', '32')->comment('数据字典表');
            $table->char('dictionary_code', '32')->comment('数据字典代码');
            $table->char('key', '32')->comment('程序中使用，数据库使用value');
            $table->char('value', '32')->comment('编码');
            $table->string('name', '256')->comment('名称');
            $table->string('input', '256')->comment('输入码，通常用于保留拼音');
            $table->integer('sort')->comment('排序');
            $table->nullableTimestamps();
            $table->softDeletes();
            $table->primary(['id']);
            $table->index('deleted_at');
            $table->index(['dictionary_table_code', 'dictionary_code']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('logistics_area');
    }
}
