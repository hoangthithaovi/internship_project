<?php

use Illuminate\Database\Seeder;

class groupsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('groups')->get()->count() == 0) {
            $groups = [
                [
                	'name_group'   => 'Nhóm quản lý tin tức',
                	'description'  => 'Chỉ có quyền thêm mới tin tức, xóa tin tức, chỉnh sửa tin tức.',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'name_group'   => 'Nhóm quản lý sự kiện',
                	'description'  => 'Xác nhận và thêm sự kiện, chỉnh sửa thông tin sự kiện, xóa sự kiện.',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'name_group'   => 'Nhóm chăm sóc khách hàng',
                	'description'  => 'Trả lời các comments và contact từ khách hàng. Hỗ trợ khách hàng khi có yêu cầu.',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'name_group'   => 'Nhóm thu ngân - tài chính',
                	'description'  => 'Nhận tiền thanh toán vé từ khách hàng và cập nhật thông tin vào database.',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ]
            ]; 
            DB::table('groups')->insert($groups);
        }
    }
}
