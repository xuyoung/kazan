<?php
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'user_account' => 'admin',
            'user_name'    => '系统管理员',
            'password'     => crypt('', null),
            'user_name_py' => 'xitongguanliyuan',
            'user_name_zm' => 'xtgly',
        ]);
    }
}
