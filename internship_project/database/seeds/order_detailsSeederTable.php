<?php

use Illuminate\Database\Seeder;

class order_detailsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('order_detail')->get()->count() == 0) {
            $order_detail = [
                [
                	'order_id' 	   => '1',
                	'ticket_id'    => '3',
                	'price'		   => '150.000',
                	'quantity'	   => '2',
                	'total' 	   => '300.000',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'order_id' 	   => '2',
                	'ticket_id'    => '1',
                	'price'		   => '200.000',
                	'quantity'	   => '3',
                	'total' 	   => '600.000',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'order_id' 	   => '3',
                	'ticket_id'    => '2',
                	'price'		   => '0.000',
                	'quantity'	   => '1',
                	'total' 	   => '0.000',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'order_id' 	   => '4',
                	'ticket_id'    => '4',
                	'price'		   => '0.000',
                	'quantity'	   => '4',
                	'total' 	   => '0.000',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'order_id' 	   => '4',
                	'ticket_id'    => '5',
                	'price'		   => '250.000',
                	'quantity'	   => '3',
                	'total' 	   => '750.000',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'order_id' 	   => '5',
                	'ticket_id'    => '6',
                	'price'		   => '150.000',
                	'quantity'	   => '5',
                	'total' 	   => '750.000',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'order_id'     => '5',
                    'ticket_id'    => '7',
                    'price'        => '80.000',
                    'quantity'     => '3',
                    'total'        => '240.000',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ]
            ]; 
            DB::table('order_detail')->insert($order_detail);
        }
    }
}
