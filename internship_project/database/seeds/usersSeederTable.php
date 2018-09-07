<?php

use Illuminate\Database\Seeder;

class usersSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->get()->count() == 0) {
            $users = [
                    [
                    'username'       => 'quyen.nguyen',
                    'email'          => 'quyen.nguyen@student.passerellesnumeriques.org',
                    'password'       => bcrypt('quyen.nguyen'),
                    'is_delete'      => '0',
                    'remember_token' => 'wdBkzLIeQKSyesZjnJLMolVcCLAJKVHHzsOYN4ERqqfd7nWb0LK7VCZXgQ1a',
                    'provider'       => 'google',
                    'provider_id'    => '123',
                    'role'           => 1,
                    'created_at'     => DB::raw('now()'),
                    'updated_at'     => DB::raw('now()'),
                ],[
                    'username'       => 'vi.hoang',
                    'email'          => 'vi.hoang@student.passerellesnumeriques.org',
                    'password'       => bcrypt('vi.hoang'),
                    'is_delete'      => '0',
                    'remember_token' => 'qgLEgQLnQhD6IzmFF0LrHxPIZPR2kDZ26r9iWhu1ilKXCwTtAODP5Ca1Tbnt',
                    'provider'       => 'google1',
                    'provider_id'    => '1234',
                    'role'           => 1,
                    'created_at'     => DB::raw('now()'),
                    'updated_at'     => DB::raw('now()'),
                ],[
                    'username'       => 'anh.nguyen',
                    'email'          => 'anh.nguyen@student.passerellesnumeriques.org',
                    'password'       => bcrypt('anh.nguyen'),
                    'is_delete'      => '0',
                    'remember_token' => 'jxRzQV514khc7GejsQjjm7Joo68WvyLBVfxWVO16RbWAYl0gAjgeXopqTvgb',
                    'provider'       => 'google2',
                    'provider_id'    => '1235',
                    'role'           => 0,
                    'created_at'     => DB::raw('now()'),
                    'updated_at'     => DB::raw('now()'),
                ],[
                    'username'       => 'admin',
                    'email'          => 'anhbaole@unitech.vn',
                    'password'       => bcrypt('bao.le'),
                    'is_delete'      => '0',
                    'remember_token' => 'Iq2mIKCYPAa0tHQBLH2NNvD16HRP30EszDnPZaoinySncwSME8iddh4gjKLF',
                    'provider'       => 'google6',
                    'provider_id'    => '1236',
                    'role'           => 1,
                    'created_at'     => DB::raw('now()'),
                    'updated_at'     => DB::raw('now()'),
                ]
            ];
            DB::table('users')->insert($users);
        }
    }
}
