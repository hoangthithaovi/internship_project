<?php

use Illuminate\Database\Seeder;

class userActionSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('user_actions')->get()->count() == 0) {
            $user_actions = [
                [
                'user_id'     => '1',
                'action_id'    => '3',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '1',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '2',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '3',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '4',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '5',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '6',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '7',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '8',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '9',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '10',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '11',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '12',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '13',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '14',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '15',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '16',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '17',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '18',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '19',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '20',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '21',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '22',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '23',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '24',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '25',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '26',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '27',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '28',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '4',
                'action_id'    => '29',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ],[
                'user_id'      => '3',
                'action_id'    => '7',
                'is_delete'    => '0',
                'created_at'   => DB::raw('now()'),
                'updated_at'   => DB::raw('now()'),
                ]
            ]; 
            DB::table('user_actions')->insert($user_actions);
        }
    }
}