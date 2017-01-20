<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  //php artisan make:seeder LinksTableSeeder(创建种子文件)
  //php artisan db:seed　来进行数据的填充
  //--------注意：修改DatabaseSeeder.php文件中调用种子文件的方法
  //--------------种子文件的格式写法------------
    public function run()
    {
      $data = [
        [
          'link_name' => '新浪网',
          'link_title' => '国内最大的门户网站',
          'link_url' => 'http://www.sina.com.cn',
          'link_order' => 1,
        ],
        [
          'link_name' => 'hao123',
          'link_title' => '最大网站导航',
          'link_url' => 'http://www.hao123.com',
          'link_order' => 2,
        ],
      ];
        DB::table('links')->insert($data);
    }
    //------------------------------------------
}
