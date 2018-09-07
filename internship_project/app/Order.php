<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use DB;

class Order extends Model
{
    use Notifiable;

    protected $table = 'orders';
    protected $fillable = ['user_id, fullname, email, phone_number, address, date_order, type_of_payment, notes, status'];
    
    public function ticket(){
        return $anh = $this->tickets()->get()->all();
    }
   
    public function order_detail(){
        return $this->hasMany('App\OrderDetail','order_id','id');
    }
    
    public function is_detail(){
        return $this->order_detail()->get()->all();
    }  

    public function users(){
        return $this->belongsTo('App\User','user_id','id');
    }
   public static function getTicket(){
        $getTicket = DB::select('select id, user_id, fullname, email, phone_number, address, date_order, type_of_payment, notes, status, created_at, updated_at from orders where status = 1 and is_delete = 0;');
        return $getTicket;
    }
   public static function getFinishOrder(){
        $getTicket = DB::select('select id, user_id, fullname, email, phone_number, address, date_order, type_of_payment, notes, status, created_at, updated_at from orders where status = 0 and is_delete = 0;');
        return $getTicket;
    }
    //Hiển thị thông tin hóa đơn(vé) khi mới mua vé
    public function getOrder($id){
        $getOrder = DB::select('select orders.id AS id, orders.user_id, orders.notes AS notes, order_detail.total AS total, orders.type_of_payment AS payment, orders.date_order AS date_order, orders.fullname AS fullname, orders.address, orders.phone_number, orders.email, order_detail.order_id, order_detail.ticket_id, order_detail.price AS price, order_detail.quantity AS quantity, tickets.id, tickets.name_type_ticket AS name_ticket, EVENTS.title_event FROM orders JOIN users ON orders.user_id = users.id JOIN order_detail ON orders.id = order_detail.order_id JOIN tickets ON order_detail.ticket_id = tickets.id JOIN EVENTS ON EVENTS .id = tickets.event_id WHERE orders.is_delete = 0 AND order_detail.is_delete=0 AND orders.user_id = ? AND orders.date_order = CURRENT_DATE() ORDER BY orders.id DESC',[$id]);
        return $getOrder;

    }
    //Hiển thị thông tin cá nhân của khách hàng trong hóa đơn
     public function getCusInfor($id){
        $getCusInfor = DB::select('select orders.fullname, orders.address, orders.phone_number, orders.email FROM orders JOIN users ON orders.user_id = users.id WHERE orders.is_delete = 0 AND orders.user_id = ? AND orders.date_order = CURRENT_DATE() ORDER BY orders.id DESC',[$id]);
        return $getCusInfor;
    }
    //Lấy số lượng vé bán được trong order detail
    public function getQuantity($id_ticket){
        $getQuantity = DB::select('select sum(order_detail.quantity) as qty from order_detail where ticket_id = ? group by ticket_id',[$id_ticket]);
        return $getQuantity;
    }
    //Lấy những hóa đơn đã được thanh toán
    public static function getOrderUnfinish(){
        $getTicket = DB::select('select orders.id AS id, orders.notes AS notes, order_detail.total AS total, orders.type_of_payment AS payment, orders.status AS status, orders.date_order AS date_order, orders.created_at AS created_at, orders.updated_at AS updated_at, orders.fullname AS fullname, order_detail.order_id, order_detail.ticket_id, order_detail.price AS price, order_detail.quantity AS quantity, tickets.id, tickets.name_type_ticket AS name_ticket from orders join users on orders.user_id = users.id join order_detail on orders.id = order_detail.order_id join tickets on order_detail.ticket_id = tickets.id order by orders.id where orders.status = 1;');
        return $getTicket;
    }

    public static function getOrderFinish(){
        $getTicket = DB::select('select orders.id AS id, orders.notes AS notes, order_detail.total AS total, orders.type_of_payment AS payment, orders.status AS status, orders.date_order AS date_order, orders.created_at AS created_at, orders.updated_at AS updated_at, orders.fullname AS fullname, order_detail.order_id, order_detail.ticket_id, order_detail.price AS price, order_detail.quantity AS quantity, tickets.id, tickets.name_type_ticket AS name_ticket from orders join users on orders.user_id = users.id join order_detail on orders.id = order_detail.order_id join tickets on order_detail.ticket_id = tickets.id order by orders.id where orders.status = 0;');
        return $getTicket;
    }
    public static function getOrderDetail($id){
        $getDetail = DB::select('select order_detail.id, order_detail.order_id, order_detail.total, order_detail.ticket_id, order_detail.price, order_detail.quantity, tickets.id,
            tickets.name_type_ticket AS name_ticket, tickets.event_id, events.id, events.title_event AS name_event, order_detail.created_at, order_detail.updated_at
            from orders 
            join order_detail on orders.id = order_detail.order_id 
            join tickets on order_detail.ticket_id = tickets.id
            join events on events.id = tickets.event_id
            where orders.id = ?', [$id]);
        return $getDetail;
    }
}
