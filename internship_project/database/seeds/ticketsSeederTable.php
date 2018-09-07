<?php

use Illuminate\Database\Seeder;

class ticketsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('tickets')->get()->count() == 0) {
        	$tickets = [
        		[
        			'name_type_ticket' => 'Vé VIP',
        			'price'            => '200.000',
        			'quantity'         => '50',
        			'description_ticket'      => 'Vé với những dịch vụ hấp dẫn.',
        			'event_id' 	       => '1',
                    'is_delete'        => '0',
        			'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
        		],[
        			'name_type_ticket' => 'Vé cho người tham dự',
        			'price'            => '100.000',
        			'quantity'         => '1000',
        			'description_ticket'      => 'Vé miễn phí dành cho những phan hâm mộ của ngành lập trình.',
        			'event_id'         => '1',
                    'is_delete'        => '0',
        			'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
        		],[
        			'name_type_ticket' => 'Vé VIP',
        			'price'            => '150.000',
        			'quantity'         => '40',
        			'description_ticket'      => 'Với những đãi ngộ hấp dẫn, chỗ ngồi lí tưởng...',
        			'event_id'         => '2',
                    'is_delete'        => '0',
        			'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
        		],[
        			'name_type_ticket' => 'Vé cho người tham quan',
        			'price'            => '0.000',
        			'quantity'         => '450',
        			'description_ticket'      => 'Vé miễn phí dành cho những người đam mê công nghệ, được đến và đắm mình trong không gian sáng tạo...',
        			'event_id'         => '3',
                    'is_delete'        => '0',
        			'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
        		],[
        			'name_type_ticket' => 'Vé loại A',
        			'price'            => '250.000',
        			'quantity'         => '60',
        			'description_ticket'      => 'Vé với ghế ngồi ở khu A, khu vực gần nhất với sân khấu, miễn phí nước uống...',
        			'event_id'         => '4',
                    'is_delete'        => '0',
        			'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
        		],[
        			'name_type_ticket' => 'Vé loại B',
        			'price'            => '150.000',
        			'quantity'         => '120',
        			'description_ticket'      => 'Vé với ghế ngồi ở khu B của sân khấu. ',
        			'event_id'         => '4',
                    'is_delete'        => '0',
        			'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
        		],[
        			'name_type_ticket' => 'Vé loại C',
        			'price'            => '80.000',
        			'quantity'         => '240',
        			'description_ticket'      => 'Vé với ghế ngồi ở khu C của sân khấu.',
        			'event_id'         => '4',
                    'is_delete'        => '0',
        			'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
        		],[
                    'name_type_ticket' => 'Vé cho khách VIP',
                    'price'            => '180.000',
                    'quantity'         => '24',
                    'description_ticket'      => 'Vé với ghế ngồi dành cho những khách VIP.',
                    'event_id'         => '5',
                    'is_delete'        => '0',
                    'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
                ],[
                    'name_type_ticket' => 'Vé loại thường',
                    'price'            => '80.000',
                    'quantity'         => '240',
                    'description_ticket'      => 'Vé với ghế ngồi ở khu D của sân khấu.',
                    'event_id'         => '6',
                    'is_delete'        => '0',
                    'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
                ],[
                    'name_type_ticket' => 'Vé miễn phí',
                    'price'            => '0.000',
                    'quantity'         => '20',
                    'description_ticket'      => 'Vé miễn phí dành cho những sinh viên.',
                    'event_id'         => '5',
                    'is_delete'        => '0',
                    'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
                ],[
                    'name_type_ticket' => 'Vé thường',
                    'price'            => '0.000',
                    'quantity'         => '10',
                    'description_ticket'      => 'Vé miễn phí cho các bạn nữ.',
                    'event_id'         => '5',
                    'is_delete'        => '0',
                    'created_at'       => DB::raw('now()'),
                    'updated_at'       => DB::raw('now()'),
                ]

        	];
            DB::table('tickets')->insert($tickets);
        }
    }
}
