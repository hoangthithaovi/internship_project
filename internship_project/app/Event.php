<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class Event extends Model
{
    use Notifiable;

    use FullTextSearch;

    protected $table = 'events';

    protected $fillable = ['id','title_event', 'location', 'description','date_start', 'date_end', 'status'
    ];

    protected $searchable = [
        'title_event', 'location', 'description' 
    ];
    public function tickets(){
        return $this->hasMany('App\Ticket','event_id', 'id');
    }

    public function is_ticket($event){
        $ev =  $this->where([['id', $event], ['is_delete', 0]])->get()->first();
        return $ev;
    }
    public function type_ticket($id){
        $type = $this->tickets()->where('is_delete',0)->get()->first();
        return $type;
    }

    public function attached_files() {
        return $this->hasMany('App\AttachedFile','object_id','id');
    }
    public function thumbnail($id) {
        $a =  $this->attached_files()->where([['object_id',$id],['parent_object_id', 2], ['type_file',0], ['is_delete', 0]])->get()->first();
        return $a;
    }

    //Lấy tất cả các comment của event
    public function getComments($id){
        $comments = DB::select('select events.id, comments.id, comments.event_id, comments.parent_id, comments.content, comments.user_id, comments.created_at, users.username, users.email, attached_files.attached_file, attached_files.folder,attached_files.parent_object_id, attached_files.object_id from events
            join comments on events.id = comments.event_id and comments.parent_id = comments.id
            join users on comments.user_id = users.id
            join attached_files on users.id =  attached_files.object_id and attached_files.parent_object_id = 3
            where events.is_delete = 0 and events.id = ?',[$id]);
        return $comments;
    }

    //Lấy hình ảnh và những thông tin của sự kiện lưu trong trang chủ
    public static function image_event(){
        $img = DB::select('select events.id, events.title_event, events.location,events.description, attached_files.attached_file, events.date_start, attached_files.folder from events join attached_files on events.id = attached_files.object_id and attached_files.id = (SELECT MAX(attached_files.id) FROM attached_files WHERE attached_files.object_id = events.id ) where attached_files.parent_object_id = 2 and attached_files.type_file = 0 and events.is_delete = 0');
        return $img;
    }
    //Hiển thị những sự kiện miễn phí
    public static function event_free(){
        $free_event = DB::select('select events.date_start, events.date_end,events.id, events.title_event, attached_files.folder, attached_files.attached_file, tickets.price from events join tickets on events.id = tickets.event_id join attached_files on attached_files.object_id = events.id and attached_files.id = (select MAX(attached_files.id) from attached_files where attached_files.object_id = events.id ) where attached_files.parent_object_id =2 and attached_files.type_file = 0 and events.is_delete = 0 and tickets.price =0 limit 4');
        return $free_event;
    }
    //Hiển thị những sự kiện phải trả tiền vé
    public function paid_event(){
        $paid_event = DB::select('select events.date_start, events.date_end,events.id, events.title_event, attached_files.folder, attached_files.attached_file, tickets.price from events join tickets on events.id = tickets.event_id and tickets.id = (select MAX(tickets.id) from tickets where tickets.event_id = events.id) join attached_files on attached_files.object_id = events.id and attached_files.id = (select max(attached_files.id) from attached_files where attached_files.object_id = events.id ) where attached_files.parent_object_id = 2 and attached_files.type_file = 0 and events.is_delete = 0 and tickets.price <>0 limit 4');
        return $paid_event;
    }
    //Hiển thị các sự kiện tương ứng với từng loại sự kiện
    public function getTypeEvent($id){
        $type_event = DB::select('select title_event, EVENTS.description, EVENTS.location, EVENTS.id, EVENTS.date_start, type_events.name_type_event, attached_files.attached_file, attached_files.folder FROM EVENTS JOIN type_event_events on type_event_events.event_id = events.id JOIN type_events ON type_events.id = type_event_events.type_event_id JOIN attached_files ON attached_files.object_id = EVENTS.id AND attached_files.id =( SELECT MAX(attached_files.id) FROM attached_files WHERE attached_files.object_id = EVENTS.id ) WHERE attached_files.parent_object_id = 2 and attached_files.type_file = 0 AND EVENTS.is_delete = 0 AND type_events.id = ?',[$id]);
        return $type_event;
    }
    //Hiển thị những sự kiện tương ứng với từng công ty
    public function getEventToCompany($id){

        $event_com = DB::select('select EVENTS .id, EVENTS.title_event, EVENTS.date_start, EVENTS.location, EVENTS.description, EVENTS.date_end, EVENTS.is_delete, companies.address, attached_files.attached_file, attached_files.folder FROM EVENTS JOIN companies_events ON companies_events.event_id = EVENTS.id JOIN companies ON companies.id = companies_events.company_id JOIN attached_files ON attached_files.object_id = EVENTS.id AND attached_files.id =( SELECT MAX(attached_files.id) FROM attached_files WHERE attached_files.object_id = EVENTS.id ) WHERE attached_files.parent_object_id = 2 and attached_files.type_file = 0 AND EVENTS.is_delete = 0 AND companies.id = ?',[$id]);
        // var_dump($event_com);
        return $event_com;
    }
    //hiển thị thông tin chi tiết của từng sự kiện
    public function getEventDetail($id_event){
        $event_detail = DB::table('events')
                        ->select('events.id', 'events.title_event','events.location','events.description','events.date_start','events.date_end','attached_files.attached_file','attached_files.folder','events.status')
                        ->join('attached_files', function ($join) {
                            $join->on('attached_files.object_id', '=', 'events.id')
                                 ->where('attached_files.id',function ($q) {
                                    $q->select(DB::raw('MAX(attached_files.id)'))
                                      ->from('attached_files')
                                      ->whereRaw('attached_files.object_id = events.id');
                            })  
                            ->where('attached_files.parent_object_id', '=', 2)
                            ->where('attached_files.type_file','=',0);
                        })
                        ->where('events.is_delete','=',0)
                        ->where('events.id',$id_event)
                        ->get()->first();
        return $event_detail;
    }

    //hiển thị tất cả các sự kiện
    public function getAllEvent(){
        $allevent = DB::select('select events.id,events.title_event, events.location, events.description, events.date_start, attached_files.attached_file, attached_files.folder from events left join attached_files on attached_files.object_id = events.id and attached_files.id = (select max(attached_files.id) from attached_files where attached_files.object_id = events.id) where attached_files.parent_object_id =2 and attached_files.type_file = 0
            ');
        return $allevent;
    }
    public function getAllimage_event($id_eventall){
        $image_eventall = DB::select('select events.id, attached_files.attached_file, attached_files.folder FROM events JOIN attached_files ON attached_files.object_id = events.id WHERE attached_files.parent_object_id = 2 AND attached_files.type_file = 0 AND events.is_delete = 0 AND events.id = ?',[$id_eventall]);
        return $image_eventall;

    }
     public function getImage(){
    $getimage = DB::select('select attached_files.id, attached_files.object_id , attached_files.attached_file, attached_files.folder
        FROM events 
        join attached_files on attached_files.object_id = events.id and attached_files.id = 
        (SELECT MAX(attached_files.id) FROM attached_files WHERE attached_files.object_id = events.id 
        and attached_files.parent_object_id = 2 and attached_files.type_file = 0)
        where events.id = attached_files.object_id');
    return $getimage;
    }

     public function getDocument(){
       $getdocument = DB::select('select attached_files.id, attached_files.object_id , attached_files.attached_file, attached_files.folder
        FROM events 
        join attached_files on attached_files.object_id = events.id and attached_files.id = 
        (SELECT MAX(attached_files.id) FROM attached_files WHERE attached_files.object_id = events.id 
        and attached_files.parent_object_id = 2 and attached_files.type_file = 1)
        where events.id = attached_files.object_id');
    return $getdocument; 
    }

     public function getEvent(){
        $getevent = DB::select('select  events.id, events.title_event, events.location, events.description, events.date_start,  events.date_end, events.status, events.created_at, events.updated_at, attached_files.attached_file, attached_files.folder, sum(tickets.quantity) as quantity
            from events
            join tickets on tickets.event_id = events.id
            join attached_files on events.id = attached_files.object_id and attached_files.id = 
            (SELECT MAX(attached_files.id) FROM attached_files WHERE attached_files.object_id = events.id ) 
            where attached_files.parent_object_id = 2 and attached_files.type_file = 0 and events.is_delete = 0');
        return $getevent;
    }
    public function getCompanies($id){
        $getcompany = DB::select('select companies.id, companies.name_company
            from events
            join companies_events on companies_events.event_id = events.id
            join companies on companies.id = companies_events.company_id
            where companies_events.is_delete = 0 and events.id =?', [$id]);
        return $getcompany;
    }

   //Lấy loại sự kiện của event xác định
    public function getTypeEvents($id){
        $gettype = DB::select('select type_events.id, type_events.name_type_event, type_events.description_typeEvent, type_events.created_at, 
            type_events.updated_at
            from events
            join type_event_events on type_event_events.event_id = events.id
            join type_events on type_events.id = type_event_events.type_event_id
            where type_event_events.is_delete = 0 and events.id =?', [$id]);
        return $gettype;
    }
 //Lấy các loại vé của sự kiện
    public function getTickets($id) {
        $getticket = DB::select('select tickets.id, tickets.name_type_ticket, tickets.price, tickets.quantity, tickets.description_ticket, tickets.event_id, tickets.created_at, tickets.updated_at 
            from events 
            join tickets on tickets.event_id = events.id
            where tickets.is_delete = 0 and events.id =? order by created_at desc', [$id]);
        return $getticket;
    }
     //Lấy công ty tổ chức sự kiện đó
    public function getCompany($id){
        $getcompany = DB::select('select companies.id, companies.name_company, companies.address,companies.phone, companies.email, companies.created_at, companies.updated_at, attached_files.attached_file, attached_files.folder 
            from events
            join companies_events on companies_events.event_id = events.id
            join companies on companies.id = companies_events.company_id
            join attached_files on attached_files.object_id = companies.id and attached_files.id = 
            (SELECT MAX(attached_files.id) from attached_files where attached_files.object_id = companies.id)
            where attached_files.parent_object_id = 1 and companies.is_delete = 0 and attached_files.type_file = 0 and attached_files.is_delete = 0
            and companies_events.is_delete = 0 and events.id = ?', [$id]);
        return $getcompany;
    }
     public function getQuantity(){
        $quantity = DB::select('
        select distinct * from (
            select events.id as id, SUM(tickets.quantity) as quantity
            from events
            join tickets on tickets.event_id = events.id
        where
            events.is_delete = 0
            group by events.title_event, events.id
        UNION ALL
            SELECT EVENTS.id, SUM(tickets.quantity) AS quantity
            FROM EVENTS
        JOIN tickets ON tickets.event_id = EVENTS.id
        WHERE
             EVENTS.is_delete = 0
            GROUP BY events.title_event, events.id
        )kk;');
        return $quantity;
    }

}
