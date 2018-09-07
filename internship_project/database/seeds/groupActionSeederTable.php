<?php

use Illuminate\Database\Seeder;

class groupActionSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('group_actions')->get()->count() == 0) {
            $group_actions = [
                [
                	'group_id' 	   => '4',
                	'action_id'    => '4',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'group_id'     => '4',
                	'action_id'    => '5',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'group_id'     => '4',
                	'action_id'    => '6',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ]
            ]; 
            DB::table('group_actions')->insert($group_actions);
        }
    }
}
