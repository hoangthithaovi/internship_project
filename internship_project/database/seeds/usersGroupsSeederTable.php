<?php

use Illuminate\Database\Seeder;

class usersGroupsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users_groups')->get()->count() == 0) {
            $users_groups = [
                [
                	'user_id' 	   => '1',
                	'group_id'     => '3',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'user_id'      => '4',
                	'group_id'     => '2',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'user_id'      => '3',
                	'group_id'     => '2',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ]
            ]; 
            DB::table('users_groups')->insert($users_groups);
        }
    }
}
