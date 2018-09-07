<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
class Company extends Model
{
    use Notifiable;

    protected $fillable = [
        'name_company','address', 'phone', 'email', 'is_delete'
    ];

    public function attached_files() {
        return $this->hasMany('App\AttachedFile','object_id','id');
    }

    public function company_image() {
        return $this->attached_files()->where([['parent_object_id', 1], ['type_file',0], ['is_delete', 0]])->get()->last();
    }

    public function events(){
        return $this->hasMany('App\Event','company_id','id');
    }
    //Lấy các công ty đã tổ chức sự kiện
    public function getcompany_event($id_companyevent){
        $company_event = DB::select('select EVENTS .id, attached_files.attached_file, attached_files.folder, companies.name_company FROM EVENTS JOIN companies_events ON companies_events.event_id = EVENTS.id JOIN companies ON companies_events.company_id = companies.id join attached_files on attached_files.object_id = events.id and attached_files.id = (select max(attached_files.id) from attached_files where attached_files.object_id = events.id) where attached_files.parent_object_id =1 and attached_files.type_file = 0 AND events.id = ?', [$id_companyevent]);
        return $company_event;
    }
   public function getEvent($id){
        $company_event = DB::select('select events.id, events.title_event, events.location, events.description, events.date_start, 
            events.date_end, events.status, events.created_at, events.updated_at 
            from companies
            join companies_events on companies_events.company_id = companies.id
            join events on events.id = companies_events.event_id
            where companies_events.is_delete = 0 and companies.id = ?', [$id]);
        return $company_event;
    }
    public function getCompany(){
        $company_image = DB::select('select companies.id, companies.name_company, companies.address,companies.phone, companies.email, companies.created_at, companies.updated_at
            from companies 
            where companies.is_delete = 0');
        return $company_image;
    }

   public function getImage(){
    $getimage = DB::select('select attached_files.id, attached_files.object_id , attached_files.attached_file, attached_files.folder
        FROM companies 
        join attached_files on attached_files.object_id = companies.id and attached_files.id = 
        (SELECT MAX(attached_files.id) FROM attached_files WHERE attached_files.object_id = companies.id 
        and attached_files.parent_object_id = 1 and attached_files.type_file = 0)
        where companies.id = attached_files.object_id');
    return $getimage;
    }
    public function getCompanyforEvent($event_id){
        $ev = DB::select('select events.id, companies.id from events 
            join companies_events on companies_events.event_id = events.id
            join companies on companies.id = companies_events.company_id
            where companies_events.is_delete = 0 and events.id = ?', [$event_id]);
        return $ev;
    }
}
