<?php

use Illuminate\Database\Seeder;

class likesSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('likes')->get()->count() == 0) {
            $likes = [
                [
                	'type_object'   => '1', //0: comment
                    'object_id'     => '1', //id_event của comment
                	'user_id'       => '4',
                	'is_delete'     => '0',
                    'created_at'    => DB::raw('now()'),
                    'updated_at'    => DB::raw('now()'),
                ],[
                	'type_object'   => '0', //1: like
                    'object_id'     => '2',
                	'user_id'       => '4',
                	'is_delete'     => '0',
                    'created_at'    => DB::raw('now()'),
                    'updated_at'    => DB::raw('now()'),
                ],[
                	'type_object'   => '1',
                    'object_id'     => '3',
                	'user_id'       => '3',
                	'is_delete'     => '0',
                    'created_at'    => DB::raw('now()'),
                    'updated_at'    => DB::raw('now()'),
                ],[
                	'type_object'   => '0',
                    'object_id'     => '4',
                	'user_id'       => '2',
                	'is_delete'     => '0',
                    'created_at'    => DB::raw('now()'),
                    'updated_at'    => DB::raw('now()'),
                ],[
                	'type_object'   => '0',
                    'object_id'     => '1',
                	'user_id'       => '4',
                	'is_delete'     => '0',
                    'created_at'    => DB::raw('now()'),
                    'updated_at'    => DB::raw('now()'),
                ]
            ]; 
            DB::table('likes')->insert($likes);
        }


        
    }
}
