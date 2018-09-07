<?php

use Illuminate\Database\Seeder;

class eventsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('events')->get()->count() == 0) {
            $events = [
                [
                    'title_event'  => 'THUỶ TINH ĐỨA CON THỨ 101',
                    'location'     => 'Nhà hát Quân Đội (Theater Army) 140 Cộng Hòa, phường 4 (Đối diện Maximax Cộng Hòa, xéo về phía trên khoản 200m), Quận Tân Bình, Thành Phố Hồ Chí Minh',
                    'description'  => 'Thủy tinh là câu chuyện hư cấu độc đáo và táo bạo về nhân vật phản diện trong câu chuyện truyền thuyết nổi tiếng sơn tinh thủy tinh, câu chuyện kể về chuyến phiêu lưu vượt lên chính mình của nhân vật nửa người nửa rồng Thủy Tinh, với những tình tiết hoàn toàn mới mang lại một cách nhìn đầy mới mẻ về nhân vật cũng như truyền thuyết Sơn tinh thủy tinh này. Như xu hướng làm mới các câu chuyện và đưa ra góc nhìn mới về các nhân vật phản diện của thế giới như maleficent đã từng rất thành công của disney.',
                    'date_start'   => '2018-08-16 08:20',
                    'date_end'     => '2018-08-16 10:30',
                    'status'       => '1',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ], [
                    'title_event'  => 'Ha Noi-Sungha Jung Live in Vietnam 2018',
                    'location'     => 'Nhà hát Tuổi Trẻ 11 Ngô Thì Nhậm, Quận Hai Bà Trưng, Thành Phố Hà Nội',
                    'description'  => 'Tại Việt Nam, Trance đang là một trong những dòng nhạc phát triển nhanh chóng bậc nhất được hàng triệu khán giả yêu thích đam mê. Điều này được thể hiện rất rõ bởi sức lan tỏa và sức hút của nhiều festival âm nhạc điện tử ngoài trời. Tuy vậy, Hà Nội hiện vẫn đang cực “khát” những địa điểm nightlife chất lượng dành cho “trance lovers”. ',
                    'date_start'   => '2018-08-10 07:00',
                    'date_end'     => '2018-08-10 11:00',
                    'status'       => '1',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ], [
                    'title_event'  => 'Halong Bay Heritage Marathon',
                    'location'     => 'Fair and Exhibition Quang Ninh Province,Hạ Long,Quảng Ninh',
                    'description'  => 'Cuộc thi Marathon Di sản Vịnh Hạ Long, một trong những Cuộc thi Marathon Quốc tế lớn nhất, chuyên nghiệp và được tổ chức tốt nhất tại Việt Nam, được tổ chức hàng năm vào Thứ Bảy cuối cùng của tháng 11 trong Di sản Thiên nhiên Thế giới được UNESCO công nhận trên Vịnh Hạ Long. Cuộc đua nhằm mục đích tạo ra một môi trường lành mạnh và tích cực, nơi những người đam mê chạy có thể thử thách bản thân, cũng như gặp gỡ và chia sẻ kinh nghiệm của họ với những người khác như họ. Thiết kế đặc biệt của đường đua cung cấp một khóa học duy nhất chạy qua Cầu Bãi Cháy, cây cầu nhịp đơn dài nhất ở Đông Nam Á. Thiết kế của khóa học này cũng cung cấp một cái nhìn ngoạn mục từ trên cao đến cảnh quan tuyệt đẹp của Vịnh Hạ Long.',
                    'date_start'   => '2018-08-1 07:00',
                    'date_end'     => '2018-08-1 12:00',
                    'status'       => '1',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'title_event'  => 'ĐÊM HOA LỆ - LỊCH SỬ SÀI GÒN CHỢ LỚN',
                    'location'     => 'Nhà hát Trưng Vương Đà Nẵng, 12-Trưng Vương, Hải Châu, Đà Nẵng.',
                    'description'  => 'Sau chương trình "À ố show", TP HCM đã có thêm một điểm dừng chân thú vị đối với du khách yêu thích khám phá nghệ thuật trình diễn. Một dấu ấn mới mà họa sĩ Sĩ Hoàng đã kỳ công tạo dựng. Chương trình "Đêm hoa lệ" diễn ra tại Nhà hát Chợ Lớn (TP HCM) vào các tối cuối tuần đã là một điểm nhấn độc đáo khiến những ai yêu thích bộ môn truyền thống hát bội, cải lương và dòng nhạc boléro đều phải trầm trồ khen ngợi. Đây là dự án tạp kỹ do nhà thiết kế thời trang Sĩ Hoàng, biên kịch Trác Thúy Miêu, đạo diễn Vũ Trần thực hiện. Chương trình quy tụ hơn 50 diễn viên trẻ và những nghệ sĩ nổi tiếng của lĩnh vực cải lương, hát bội',
                    'date_start'   => '2018-08-06 07:00',
                    'date_end'     => '2018-08-06 11:00',
                    'status'       => '1',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'title_event'  => 'BUỔI SEMINAR MIỄN PHÍ VỀ BLOCKCHAIN CHO 1000 BẠN NỮ',
                    'location'     => 'Queen Plaza Kỳ Hoà 16A Lê Hồng Phong, Quận 10, Thành Phố Hồ Chí Minh',
                    'description'  => 'Bạn sẽ được truyền đạt những kiến thức Blockchain nhập môn, và những thông tin từ chuyên gia để giúp bạn định hướng và tìm thấy những cơ hội nghề nghiệp, cơ hội kinh doanh trong lĩnh vực Blockchain. Sự kiện không giới hạn độ tuổi, không giới hạn ngành nghề, hoàn toàn miễn phí cho các bạn nữ và chỉ diễn ra trong duy nhất 1 buổi. Ngôn ngữ chính được sử dụng trong sự kiện là tiếng Việt, phiên dịch tiếng Anh có thể được hỗ trợ. Thức ăn và nước uống sẽ được ban tổ chức phục vụ trong suốt thời gian diễn ra seminar. Seminar bắt đầu từ 8:00 sáng tại Queen Plaza Kỳ Hòa, các bạn nên đến sớm để check in. Nếu có câu hỏi hay thắc mắc gì, xin vui lòng liên hệ với chúng tôi để được giải đáp',
                    'date_start'   => '2018-07-27 07:00',
                    'date_end'     => '2018-07-27 10:00',
                    'status'       => '1',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'title_event'  => 'EMPATHY LEADERSHIP Workshop',
                    'location'     => 'Saigon Prince Hotel 63 Nguyễn Huệ, P. Bến Nghé, Quận 1, TPHCM',
                    'description'  => 'Khi trở thành nhà lãnh đạo, chúng ta phải làm việc với nhiều người và sẽ phải đối diện với những phức tạp mà con người mang đến. Nếu không có được “Sự Thấu Cảm” thì chúng ta sẽ không thể thúc đẩy đội ngũ của mình làm việc hiệu quả, càng không thể tập hợp được tinh thần và khối óc của cả tập thể, để cùng nhau vươn tới mục tiêu lớn lao. Sự Thấu Cảm trong lãnh đạo mang những con người bình thường đến gần nhau, cùng làm việc và tạo ra kết quả phi thường.',
                    'date_start'   => '2018-07-30 08:00',
                    'date_end'     => '2018-07-30 12:00',
                    'status'       => '1',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'title_event'  => 'Vở hài Kịch "Trời trao của lạ"',
                    'location'     => 'Sân Khấu Kịch 5B 5B, Võ Văn Tần, Phường 6, Quận 3, Thành Phố Hồ Chí Minh',
                    'description'  => 'Sân khấu kịch 5B vừa công diễn vở kịch “Trời trao của lạ” của tác giả - đạo diễn Mai Thắm, một câu chuyện dung dị nhưng đầy ắp những yêu thương. Vở kịch là câu chuyện về mối quan hệ giữa hai nhà hàng xóm, chỉ cách nhau dậu mồng tơi. Tưởng chừng mối quan hệ ấy khăng khít, hàng xóm tối lửa tắt đèn có nhau, nhưng vì những mâu thuẫn nhỏ đã đẩy hai gia đình nhiều tình huống dở khóc, dở cười.',
                    'date_start'   => '2018-07-28 08:00',
                    'date_end'     => '2018-07-28 12:00',
                    'status'       => '1',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ],[
                    'title_event'  => 'Vở kịch: Những Giấc Mơ Lóng Lánh',
                    'location'     => 'Sân Khấu Kịch 5B 5B, Võ Văn Tần, Phường 6, Quận 3, Thành Phố Hồ Chí Minh',
                    'description'  => 'Những giấc mơ lóng lánh là kịch bản mới đầu tiên được Nhà hát kịch Sân khấu nhỏ 5B dàn dựng sau khi hoạt động trở lại từ đầu tháng 4.Một vở kịch tương tác, Sân khấu 360• được thiết kế như phim trường, Giao lưu và đặt câu hỏi với ekip Rút thăm trúng thưởng ',
                    'date_start'   => '2018-07-29 08:00',
                    'date_end'     => '2018-07-29 12:00',
                    'status'       => '1',
                    'is_delete'    => '0',
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()'),
                ]
            ];
            DB::table('events')->insert($events);
        }
    }
}
