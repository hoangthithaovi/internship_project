<?php

use Illuminate\Database\Seeder;

class commentsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('comments')->get()->count() == 0) {
            $comments = [
                [
                	'event_id' 	   => '1',
                	'user_id'      => '1',
                	'parent_id'	   => '0',
                	'content'	   => 'Nơi mua vé uy tín chất lượng',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'event_id' 	   => '2',
                	'user_id'      => '3',
                	'parent_id'	   => '0',
                	'content'	   => 'Khá là yên tâm khi đặt vé nhưng việc xử lý thanh toán còn quá chậm và chưa thuận tiện.',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'event_id' 	   => '1',
                	'user_id'      => '3',
                	'parent_id'	   => '1',
                	'content'	   => 'Tui thấy thái độ làm việc của nhân viên còn rất thờ ơ, lạnh nhạt, không nhiệt tình với khách hàng.',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'event_id' 	   => '3',
                	'user_id'      => '2',
                	'parent_id'	   => '0',
                	'content'	   => 'Sự kiện này thật tuyệt, không gian sôi động tươi trẻ, năm ngoái tôi có đi một lần. Hi vọng năm nay sẽ không làm tôi thất vọng.',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'event_id' 	   => '3',
                	'user_id'      => '1',
                	'parent_id'	   => '0',
                	'content'	   => 'Ừm, nghe bạn nói vậy mình cũng muốn đăng kí mua vé đi sự kiện này một lần.',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                	'event_id' 	   => '4',
                	'user_id'      => '3',
                	'parent_id'	   => '0',
                	'content'	   => 'Tôi thực sự hài lòng về sự kiện này, nó đã giúp tôi rất nhiều.',
                	'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ]
            ]; 
            DB::table('comments')->insert($comments);
        }
    }
}
