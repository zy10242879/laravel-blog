<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //-------要填充哪个表，要通过以下方法调用种子文件---------
        $this->call(LinksTableSeeder::class);
    }
}
