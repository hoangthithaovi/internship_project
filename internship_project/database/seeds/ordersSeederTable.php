<?php

use Illuminate\Database\Seeder;

class ordersSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('orders')->get()->count() == 0) {
            $orders = [
                [
                	'user_id' 	      => '1',
                    'fullname'        => 'Nguyễn Thị Thuyền Quyên',
                    'email'           => 'quyen.nguyen@student.passerellesnumeriques.org',
                    'phone_number'    => '01678347343',
                    'address'         => 'Quảng Nam',
                	'date_order'      => DB::raw('now()'),
                	'type_of_payment' => '1',
                	'notes' 	      => 'No',
                	'status' 	      => '0',
                	'is_delete'       => '0',
                    'created_at'      => DB::raw('now()'),
                    'updated_at'      => DB::raw('now()'),
                ],[
                	'user_id' 	      => '2',
                    'fullname'        => 'Hoàng Thị Thảo Vi',
                    'email'           => 'vi.hoang@student.passerellesnumeriques.org',
                    'phone_number'    => '01698347343',
                    'address'         => 'Quảng Trị',
                	'date_order'      => DB::raw('now()'),
                	'type_of_payment' => '1',
                	'notes' 	      => 'No',
                	'status' 	      => '1',
                	'is_delete'       => '0',
                    'created_at'      => DB::raw('now()'),
                    'updated_at'      => DB::raw('now()'),
                ],[
                	'user_id' 	      => '3',
                    'fullname'        => 'Nguyễn Thị Ngọc Ánh',
                    'email'           => 'anh.nguyen@student.passerellesnumeriques.org',
                    'phone_number'    => '01688347348',
                    'address'         => 'Quảng Bình',
                	'date_order'      => DB::raw('now()'),
                	'type_of_payment' => '0',
                	'notes' 	      => 'No',
                	'status' 	      => '0',
                	'is_delete'       => '0',
                    'created_at'      => DB::raw('now()'),
                    'updated_at'      => DB::raw('now()'),
                ],[
                	'user_id' 	      => '2',
                    'fullname'        => 'Lê Hoàng Anh Bảo',
                    'email'           => 'anhbaole@unitech.vn',
                    'phone_number'    => '01688357349',
                    'address'         => 'Đà Nẵng',
                	'date_order'      => DB::raw('now()'),
                	'type_of_payment' => '0',
                	'notes' 	      => 'No',
                	'status' 	      => '0',
                	'is_delete'       => '0',
                    'created_at'      => DB::raw('now()'),
                    'updated_at'      => DB::raw('now()'),
                ],[
                	'user_id' 	      => '1',
                    'fullname'        => 'Lê Hoàng Anh Bảo',
                    'email'           => 'anhbaole@unitech.vn',
                    'phone_number'    => '01688357349',
                    'address'         => 'Đà Nẵng',
                	'date_order'      => DB::raw('now()'),
                	'type_of_payment' => '1',
                	'notes' 	      => 'No',
                	'status' 	      => '0',
                	'is_delete'       => '0',
                    'created_at'      => DB::raw('now()'),
                    'updated_at'      => DB::raw('now()'),
                ]
            ]; 
            DB::table('orders')->insert($orders);
        }
    }
}
