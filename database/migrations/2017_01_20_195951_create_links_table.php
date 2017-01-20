<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *添加
     * @return void
     */
    //------------------------------注意-------------------------------------------
    //注意：当使用php artisan migrate 来创建表的时候，要将文件夹中的其它文件移出，不然会一起运行
    public function up()
    {
      Schema::create('links', function (Blueprint $table) {
        //默认生成InnoDB引擎的表，以下为修改方式
        $table->engine = 'MyISAM';
        $table->increments('link_id');
        $table->string('link_name')->default('')->comment('//名称');
        $table->string('link_title')->default('')->comment('//标题');
        $table->string('link_url')->default('')->comment('//链接');
        $table->integer('link_order')->default(0)->comment('//排序');
      });
    }

    /**
     * Reverse the migrations.
     *删除
     * @return void
     */
    public function down()
    {
      Schema::drop('links');
    }
}
