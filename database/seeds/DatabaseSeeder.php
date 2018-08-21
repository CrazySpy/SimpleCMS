<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
	{
		DB::table('Role')->insert([
			'id' => 1,
			'name' => '超级管理员',
			'status' => 1,
        ]);

		DB::table('Admin')->insert([
			'id' => 1,
            'username' => 'admin',
			'password' => Hash::make('admin'),
			'Role_id' => 1,
			'status' => 1,
			'createTime' => date('Y-m-d h:i:s'),
			'updateTime' => date('Y-m-d h:i:s'),
		]);

		DB::table('Node')->insert([
			'id' => 1,
			'name' => '后台管理',
			'sort' => 0,
			'pid' => 0,
			'status' => 1,
		]);

		DB::table('Node')->insert([
			'name' => '菜单管理',
			'accessTag' => 'NodeController',
			'uri' => '/CmsManage/node/index',
			'sort' => 0,
			'pid' => 1,
			'status' => 1,
        ]);

		DB::table('Node')->insert([
			'name' => '用户管理',
			'accessTag' => 'AdminController',
			'uri' => '/CmsManage/admin/index',
			'sort' => 1,
			'pid' => 1,
			'status' => 1,
        ]);
		
		DB::table('Node')->insert([
			'name' => '角色管理',
			'accessTag' => 'RoleController',
			'uri' => '/CmsManage/role/index',
			'sort' => 2,
			'pid' => 1,
			'status' => 1,
        ]);


    }
}
