<?php

use Illuminate\Database\Seeder;

class typeEventEventsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('type_event_events')->get()->count() == 0){
        	$type_event_events = [
        		[
        			'event_id'          => '1' ,
        			'type_event_id'     => '1',
                    'is_delete'         => '0',
        			'created_at'        => DB::raw('now()'),
        			'updated_at'        => DB::raw('now()'),
        		],[
        			'event_id'          => '2',
                    'type_event_id'     => '2' ,
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
        		],[
        			'event_id' 	        => '1',
                    'type_event_id'     => '2',
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
        		],[
        			'event_id'          => '5',
                    'type_event_id'     =>' 3',
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
        		],[
        			'event_id'          => '4',
                    'type_event_id'     => '3',
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
        		],[
        			'event_id'          => '4',
                    'type_event_id'     => '2',
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
        		],[
        			'event_id'          => '5',
                    'type_event_id'     => '4',
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
        		],[
                    'event_id'          => '5',
                    'type_event_id'     => '2',
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
                ],[
                    'event_id'          => '3',
                    'type_event_id'     => '3',
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
                ],[
                    'event_id'          => '6',
                    'type_event_id'     => '2',
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
                ],[
                    'event_id'          => '5',
                    'type_event_id'     => '3',
                    'is_delete'         => '0',
                    'created_at'        => DB::raw('now()'),
                    'updated_at'        => DB::raw('now()'),
                ]
        	];
        	DB::table('type_event_events')->insert($type_event_events);
        }
    }
}
