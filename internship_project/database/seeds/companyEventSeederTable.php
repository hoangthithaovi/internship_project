<?php

use Illuminate\Database\Seeder;

class companyEventSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       if(DB::table('companies_events')->get()->count() == 0){
        	$comp_event = [
        		[
        			'company_id'   => '1',
        			'event_id'     => '7',
                    'is_delete'    => '0',
        			'created_at'   => DB::raw('now()'),
        			'updated_at'   => DB::raw('now()'),
        		],[
        			'company_id'   => '2',
                    'event_id'     => '3' ,
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
        		],[
        			'company_id'   => '1',
                    'event_id'     => '2',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
        		],[
        			'company_id'   => '5',
                    'event_id'     =>' 3',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
        		],[
        			'company_id'   => '4',
                    'event_id'     => '3',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
        		],[
        			'company_id'   => '4',
                    'event_id'     => '2',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
        		],[
        			'company_id'   => '5',
                    'event_id'     => '5',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
        		],[
                    'company_id'   => '5',
                    'event_id'     => '2',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'company_id'   => '3',
                    'event_id'     => '3',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'company_id'   => '7',
                    'event_id'     => '3',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'company_id'   => '6',
                    'event_id'     => '6',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'company_id'   => '5',
                    'event_id'     => '4',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'company_id'   => '5',
                    'event_id'     => '6',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ]

        	];
        	DB::table('companies_events')->insert($comp_event);
        }
    }
}
