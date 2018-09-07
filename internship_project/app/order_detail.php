<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class order_detail extends Model
{
    use Notifiable;

    protected $table = 'order_detail';
    protected $fillable = ['order_id', 'ticket_id', 'price', 'quantity', 'total','is_delete'];
    
    public function order(){
        return $this->belongsToMany('App\Order');
    }
    
    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }
    //hiển thị sự kiện mới theo total trong order detail
    public static function getNewEvent(){
        $getevent = DB::select('select EVENTS .date_start, EVENTS.date_end, EVENTS.id, EVENTS.location, EVENTS.description, order_detail.ticket_id, EVENTS.title_event, attached_files.folder, attached_files.attached_file FROM ( SELECT DISTINCT SUM(order_detail.total),order_detail.ticket_id, order_detail.is_delete FROM order_detail GROUP BY order_detail.ticket_id, order_detail.is_delete ORDER BY sUM(order_detail.total) DESC ) AS order_detail JOIN EVENTS ON EVENTS .id = order_detail.ticket_id JOIN attached_files ON attached_files.object_id = EVENTS.id AND attached_files.id =( SELECT MAX(attached_files.id) FROM attached_files WHERE attached_files.object_id = EVENTS.id ) WHERE attached_files.parent_object_id = 2 AND attached_files.type_file = 0 AND order_detail.is_delete = 0');
        return $getevent;
    }
    //hiển thị sự kiện mới thông qua ngày diễn ra sự kiện
    public static function getNewEventViaDate(){
        $date_start = DB::select('select order_detail.ticket_id, EVENTS.date_start, EVENTS.id, EVENTS.date_end, events.location,events.description,EVENTS.title_event, attached_files.folder, attached_files.attached_file FROM ( SELECT DISTINCT order_detail.ticket_id FROM order_detail GROUP BY order_detail.ticket_id ) AS order_detail JOIN EVENTS ON EVENTS .id = order_detail.ticket_id JOIN attached_files ON attached_files.object_id = EVENTS.id AND attached_files.id =( SELECT MAX(attached_files.id) FROM attached_files WHERE attached_files.object_id = EVENTS.id ) WHERE attached_files.parent_object_id = 2 AND attached_files.type_file = 0 AND EVENTS.date_start > NOW() AND EVENTS.is_delete = 0');
        return $date_start;
    }


    //get ngày bắt đầu của sự kiện
    public function getDateStartEvent($id,$id_user){
        $getDate = DB::select('select events.date_start FROM order_detail JOIN tickets ON tickets.id = order_detail.ticket_id JOIN EVENTS ON EVENTS .id = tickets.event_id join orders on orders.id = order_detail.order_id join users on users.id = orders.user_id WHERE order_detail.ticket_id = ? and orders.user_id = ?',[$id, $id_user]);
        return $getDate;
    }
    //hiển thị hóa đơn
    public function showBill($id_user){
        $showbill = DB::select('select order_detail.id as ID_orderDetail, order_detail.ticket_id as IDticket, order_detail.is_delete, orders.user_id, orders.fullname, orders.notes, order_detail.total, orders.type_of_payment as payment, orders.date_order, orders.address, orders.email, orders.phone_number, order_detail.price, order_detail.is_delete AS ID_Delete, order_detail.quantity, tickets.name_type_ticket, EVENTS.title_event, EVENTS.id AS id_event, EVENTS.date_start FROM order_detail JOIN orders ON orders.id = order_detail.order_id JOIN users ON orders.user_id = users.id JOIN tickets ON order_detail.ticket_id = tickets.id JOIN EVENTS ON EVENTS .id = tickets.event_id WHERE orders.user_id = ? AND order_detail.is_delete = 0',[$id_user]);

        return $showbill;
    }
}

