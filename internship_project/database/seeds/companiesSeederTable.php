<?php

use Illuminate\Database\Seeder;

class companiesSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('companies')->get()->count() == 0) {
            $companies = [
                [
                    'name_company' => 'AXON ACTIVE',
                    'address'      => 'Hải Châu - Đà Nẵng - Việt Nam',
                    'phone'        => '0123456789',
                    'email'        => 'axonactive@gmail.com',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ], [
                    'name_company' => 'Unitech Viet Nam',
                    'address'      => '02 - Quang Trung - Hải Châu - Đà Nẵng - Việt Nam',
                    'phone'        => '0123456789',
                    'email'        => 'unitech@gmail.com',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'name_company' => 'Logiger Đà Nẵng',
                    'address'      => 'Sơn Trà - Đà Nẵng - Việt Nam',
                    'phone'        => '0123456789',
                    'email'        => 'logigear@gmail.com',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'name_company' => 'GameLoft Đà Nẵng',
                    'address'      => 'Trần Phú - Hải Châu - Đà Nẵng - Việt Nam',
                    'phone'        => '0123456789',
                    'email'        => 'gameloft@gmail.com',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'name_company' => 'FPT software Đà Nẵng',
                    'address'      => 'Hòa Vang - Đà Nẵng - Việt Nam',
                    'phone'        => '0123456789',
                    'email'        => 'fpt@gmail.com',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'name_company' => 'SEA DEV Đà Nẵng',
                    'address'      => 'Đà Nẵng - Việt Nam',
                    'phone'        => '0123456789',
                    'email'        => 'seadev@gmail.com',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'name_company' => 'VNPT Đà Nẵng',
                    'address'      => 'Đà Nẵng - Việt Nam',
                    'phone'        => '0123456789',
                    'email'        => 'vnpt@gmail.com',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ]
            ];
            DB::table('companies')->insert($companies);
        }
    }
}
