<?php

use Illuminate\Database\Seeder;

class type_eventsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('type_events')->get()->count() == 0) {
            $type_events = [
                [
                    'name_type_event'            => 'Công nghệ thông tin',
                    'description_typeEvent'      => 'Các sự kiện về công nghệ thông tin.',
                    'is_delete'                  => '0',
                    'created_at'                 => DB::raw('now()'),
                    'updated_at'                 => DB::raw('now()'),
                ], [
                	'name_type_event'            => 'Kĩ năng mềm',
                    'description_typeEvent'      => 'Các sự kiện về kĩ năng mềm.',
                    'is_delete'                  => '0',
                    'created_at'                 => DB::raw('now()'),
                    'updated_at'                 => DB::raw('now()'),
                ], [
                	'name_type_event'            => 'Hoạt động giải trí',
                    'description_typeEvent'      => 'Các sự kiện về giải trí, âm nhạc, phim ảnh, nhạc kịch...',
                    'is_delete'                  => '0',
                	'created_at'                 => DB::raw('now()'),
                	'updated_at'                 => DB::raw('now()'),
                ]
            ];
            DB::table('type_events')->insert($type_events);
        }
    }
}
