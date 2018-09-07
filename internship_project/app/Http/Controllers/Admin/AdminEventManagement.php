<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\Event;
use App\Ticket;
use App\Company;
use App\TypeEvent;
use App\AttachedFile;
use App\TypeEvent_Event;
use App\CompanyEvent;

class AdminEventManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $event_image = new Event();
        $images = $event_image->getImage();
        $event_document = new Event();
        $documents = $event_document->getDocument();
        $events = Event::where([['is_delete',0], ['status', '=', 1]])->orderBy('created_at','asc')->paginate(10);
        $quantity_ticket = new Event();
        $quantity = $quantity_ticket->getQuantity();
        return view('admin.events.index', compact('events', 'images', 'documents', 'quantity'));
    }
    
    //Full Search Text cho Admin
    public function searchAdmin() {
        $events =Event::search($_GET['search_textadmin'])->paginate(10);
        $events->setPath('search?search_textadmin='.$_GET['search_textadmin']);
        $search_textadmin = $_GET['search_textadmin'];
        $is_search = 1;
        return view('admin.events.index', compact('events','is_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::where('is_delete',0)->orderBy('created_at', 'asc')->get();
        $type_events = TypeEvent::where('is_delete',0)->orderBy('created_at','asc')->get();
        return view('admin.events.create', compact('type_events', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title_event'       => 'required|min:3',
            'location'          => 'required|min:5',
            'editor'       => 'required|min:5',
            'date_start'        => 'required',
            'date_end'          => 'required',
            'type_event_id'     => 'required',    
            'company_id'        => 'required',
            'file_image'        => 'mimes:png,jpg,jpeg,gif|max:5120',
            'file_document'     => 'mimes:doc,docx,xls,xlsx|max:5120',
            ],[

            'title_event.required'  => 'Vui lòng nhập tên sự kiện.',
            'title_event.min'       => 'Tên sự kiện phải lớn hơn 3 ký tự.',
            'location.required'     => 'Vui lòng nhập địa điểm tổ chức.',
            'location.min'          => 'Vui lòng nhập lớn hơn 5 ký tự.',
            'editor.required'  => 'Vui lòng nhập chi tiết sự kiện.',
            'editor.min'       => 'Mô tả phải lớn hơn 5 ký tự.',
            'date_start.required'   => 'Vui lòng chọn ngày diễn ra sự kiện.',
            'date_end.required'     => 'Vui lòng chọn ngày kết thúc sự kiện.',
            'type_event_id.required'=> 'Vui lòng chọn loại sự kiện!',
            'company_id.required'   => 'Vui lòng chọn công ty tổ chức!',
            'file_image.required'   => 'Vui lòng chọn hình ảnh chỗ ngồi.',
            'file_image.mimes'      => 'Chỉ chấp nhận hình ảnh với đuôi .jpg .jpeg .png .gif',
            'file_image.max'        => 'Dung lượng hình ảnh không quá 5MB',
            'file_document.mines'   => 'Chỉ chấp nhận file với đuôi .doc .docx .xls .xlsx',
            'file_document.max'     => 'Dung lượng file không quá 5MB!',
        ]);

        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['title_event']   = $request->get('title_event');
            $input['location']      = $request->get('location');
            $input['description']   = $request->get('editor');
            $input['date_start']    = $request->get('date_start');
            $input['date_end']      = $request->get('date_end');
            $input['status']        = 1;
            $input['is_delete']     = 0;
            $event = Event::create($input);

            if ($event != null) {
                $file_document = $request->file('file_document');
                if ($file_document) {
                    $this->validate($request, 
                    [
                        'file_document' => 'required|mimes:doc,docx,xls,xlsx|max:5120',  
                    ],          
                    [
                        'file_document.mimes'  => 'Chỉ chấp nhận với đuôi .doc .docx .xls .xlsx',
                        'file_document.max'    => 'Dung lượng không quá 5MB.',
                    ]
                );
                    $year   = date('Y');
                    $month  = date('m');
                    $day    = date('d');
                    $id     = $event->id;
                    
                    $sub_folder = 'events'.'/'. $year . '/' . $month . '/' . $day . '/' . $id .'/';
                    $upload_url = 'documents/' . $sub_folder;

                    if (!File::exists(public_path() . '/' . $upload_url)) {
                        File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
                    }
                    $name = time() . $file_document->getClientOriginalName();
                    $fileName = rand(11111, 99999) . '.' . $name;
                    $input['name_file'] = 'Event Document';
                    $input['attached_file'] = $fileName;
                    $input['description'] = 'Không';
                    $input['folder'] = $upload_url;
                    $input['type_file'] = 1;
                    $input['parent_object_id'] = 2;
                    $input['object_id'] = $id;
                    $input['is_delete'] = 0;
                    $file_document->move($upload_url, $name);
                    $attach_file = AttachedFile::create($input);
                } 

                $file_image = $request->file('file_image');
                if ($file_image) {
                    $this->validate($request, 
                    [
                        'file_image' => 'required|mimes:png,jpg,jpeg,gif|max:5120',  
                    ],          
                    [
                        'file_image.mimes'  => 'Chỉ chấp nhận với đuôi .png .jpg .jpeg .gif',
                        'file_document.max'    => 'Dung lượng không quá 5MB.',
                    ]
                );
                    $year   = date('Y');
                    $month  = date('m');
                    $day    = date('d');
                    $id     = $event->id;
                    
                    $sub_folder = 'events'.'/'. $year . '/' . $month . '/' . $day . '/' . $id .'/';
                    $upload_url = 'images/' . $sub_folder;

                    if (!File::exists(public_path() . '/' . $upload_url)) {
                        File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
                    }
                    $name = time() . $file_document->getClientOriginalName();
                    $fileName = rand(11111, 99999) . '.' . $name;
                    $input['name_file'] = 'Sơ đồ chỗ ngồi';
                    $input['attached_file'] = $fileName;
                    $input['description'] = 'Không';
                    $input['folder'] = $upload_url;
                    $input['type_file'] = 1;
                    $input['parent_object_id'] = 4;
                    $input['object_id'] = $id;
                    $input['is_delete'] = 0;
                    $file_image->move($upload_url, $name);
                    $attach_file = AttachedFile::create($input);
                }
                //Thêm nhiều công ty tổ chức sự kiện
                if($event){
                $companies = $request->input('company_id');
                    if ($companies){
                        foreach ($companies as $company) {
                            $company_event = new CompanyEvent;
                            $company_event->event_id = $event->id;
                            $company_event->company_id = $company;
                            $company_event->is_delete = 0;
                            $company_event->save();
                        }
                    }
                }

                if($event){
                $type_events = $request->input('type_event_id');
                    if ($type_events){
                        foreach ($type_events as $type){
                            $type_event = new TypeEvent_Event;
                            $type_event->event_id = $event->id;
                            $id = (int)$type;
                            $type_event->type_event_id = $id;
                            $type_event->is_delete = 0;
                            $type_event->save();
                        }
                    } 
                }
            }
            DB::commit();
        } catch (Exception $ex) {
            
        }  
        return redirect('/admin/events')->with('create_event', 'Sự kiện đã được tạo!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event_image = new Event();
        $images = $event_image->getImage();
        $event_document = new Event();
        $documents = $event_document->getDocument();
        $events = Event::where([['is_delete',0], ['status', '=', 1]])->orderBy('created_at','asc')->paginate(10);
        $quantity_ticket = new Event();
        $quantity = $quantity_ticket->getQuantity();
        return view('admin.events.finishEvent', compact('events', 'images', 'documents', 'quantity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companies   = Company::where('is_delete',0)->orderBy('created_at', 'asc')->get();
        $type_events = TypeEvent::where('is_delete',0)->orderBy('created_at','asc')->get();

        $event       = Event::findOrFail($id);

        $type = new Event();
        $type_event_ds = $type->getTypeEvents($id);

        $company = new Event();
        $company_event = $company->getCompanies($id);

        $event_images = AttachedFile::where([['object_id', $id], ['parent_object_id', 2], ['is_delete', 0], ['type_file', 0]])->get();
        $ticket = new Event();
        $tickets = $ticket->getTickets($id);
        return view('admin.events.edit', compact('event','type_events', 'companies', 'type_event_ds', 'company_event', 'event_images', 'tickets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        DB::beginTransaction();
        try{
            if ($event != null) {
                $file_document = $request->file('file_document');
                if ($file_document) {
                    $this->validate($request, 
                    [
                        'file_document' => 'required|mimes:doc,docx,xls,xlsx|max:5120',  
                    ],          
                    [
                        'file_document.mimes'  => 'Chỉ chấp nhận với đuôi .doc .docx .xls .xlsx',
                        'file_document.max'    => 'Dung lượng không quá 5MB.',
                    ]
                );
                    $year   = date('Y');
                    $month  = date('m');
                    $day    = date('d');
                    $id     = $event->id;
                    
                    $sub_folder = 'events'.'/'. $year . '/' . $month . '/' . $day . '/' . $id .'/';
                    $upload_url = 'documents/' . $sub_folder;

                    if (!File::exists(public_path() . '/' . $upload_url)) {
                        File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
                    }
                    $name = time() . $file_document->getClientOriginalName();
                    $fileName = rand(11111, 99999) . '.' . $name;
                    $input['name_file'] = 'Event Document';
                    $input['attached_file'] = $fileName;
                    $input['description'] = 'Không';
                    $input['folder'] = $upload_url;
                    $input['type_file'] = 1;
                    $input['parent_object_id'] = 2;
                    $input['object_id'] = $id;
                    $input['is_delete'] = 0;
                    $file_document->move($upload_url, $name);
                    $attach_file = AttachedFile::create($input);
                } 

                $file_image = $request->file('file_image');
                if ($file_image) {
                    $this->validate($request, 
                    [
                        'file_image' => 'required|mimes:png,jpg,jpeg,gif|max:5120',  
                    ],          
                    [
                        'file_image.mimes'  => 'Chỉ chấp nhận với đuôi .png .jpg .jpeg .gif',
                        'file_document.max'    => 'Dung lượng không quá 5MB.',
                    ]
                );
                    $year   = date('Y');
                    $month  = date('m');
                    $day    = date('d');
                    $id     = $event->id;
                    
                    $sub_folder = 'events'.'/'. $year . '/' . $month . '/' . $day . '/' . $id .'/';
                    $upload_url = 'images/' . $sub_folder;

                    if (!File::exists(public_path() . '/' . $upload_url)) {
                        File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
                    }
                    $name = time() . $file_document->getClientOriginalName();
                    $fileName = rand(11111, 99999) . '.' . $name;
                    $input['name_file'] = 'Sơ đồ chỗ ngồi';
                    $input['attached_file'] = $fileName;
                    $input['description'] = 'Không';
                    $input['folder'] = $upload_url;
                    $input['type_file'] = 1;
                    $input['parent_object_id'] = 4;
                    $input['object_id'] = $id;
                    $input['is_delete'] = 0;
                    $file_image->move($upload_url, $name);
                    $attach_file = AttachedFile::create($input);
                }  
            }
            DB::commit();
        } catch (Exception $ex) {
            
        }  
        return redirect('/admin/events')->with('update_event', 'Cập nhật thông tin sự kiện thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $is_delete = 1;
        //Xóa ảnh sự kiện
        $event_images = AttachedFile::where([['object_id', '=', $id], ['parent_object_id', '=', 2], ['type_file', 0], ['is_delete', '=', 0]])->get();

        if($event_images){
            foreach ($event_images as $key => $event_image) {
                $event_link = $event_image->folder.$event_image->attached_file;
                $deleteEvent = AttachedFile::where('id', '=', $event_image->id)->delete();
                if (File::exists($event_link)) {
                    File::delete($event_link);
                }
            }
        } 
        //Xóa tài liệu đính kèm
        $event_documents = AttachedFile::where([['object_id', '=', $id], ['parent_object_id', '=', 2], ['type_file', 1], ['is_delete', '=', 0]])->get();

        if($event_documents){
            foreach ($event_documents as $key => $event_document) {
                $document_link = $event_document->folder.$event_document->attached_file;
                $deleteEvent = AttachedFile::where('id', '=', $event_document->id)->delete();
                if (File::exists($document_link)) {
                    File::delete($document_link);
                }
            }
        }  
        //Xóa ảnh sơ đồ chỗ ngồi
        $event_maps = AttachedFile::where([['object_id', '=', $id], ['parent_object_id', '=', 4], ['type_file', 0], ['is_delete', '=', 0]])->get();

        if($event_maps){
            foreach ($event_maps as $event_map) {
                $map_link = $event_map->folder.$event_map->attached_file;
                $deleteEvent = AttachedFile::where('id', '=', $event_map->id)->delete();
                if (File::exists($map_link)) {
                    File::delete($map_link);
                }
            }
        }  

        $delete_event_company = CompanyEvent::where('event_id', '=', $id)->update(['is_delete' => $is_delete]);
        $delete_type_event = TypeEvent_Event::where('event_id', '=', $id)->update(['is_delete' => $is_delete]);
        $event['is_delete'] = 1;
        $event->save();
        \Illuminate\Support\Facades\Session::flash('deleted_event', 'Sự kiện đã được xóa!');
        return redirect('/admin/events');
    }

    public function getCompany($id){
        $company = new Event();
        $companies = $company->getCompany($id);
        $image = new Company();
        $images = $image->getImage();
        return view('admin.companies.index', compact('companies', 'images'));
    }

    public function getTypeEvents($id){
        $type_event = new Event();
        $type_events = $type_event->getTypeEvents($id);
        return view('admin.type_events.index', compact('type_events'));
    }

    public function getTicket($id) {
        $ticket = new Event();
        $tickets = $ticket->getTickets($id);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function uploadFiles(Request $request, $id)
    {
        if ($request->ajax()) {
            //Kiểm tra ảnh sự tồn tại của files upload
            if ($request->hasFile('file')) {
                $imageFiles = $request->file('file');
                // Quy định đường dẫn lưu ảnh
                $year   = date('Y');
                $month  = date('m');
                $day    = date('d');
                $sub_folder = 'events'.'/'. $year . '/' . $month . '/' . $day . '/' .$id .'/';
                $destinationPath = 'images/'. $sub_folder; // upload path
                if (!File::exists(public_path() . '/' . $destinationPath)) {
                    File::makeDirectory(public_path() . '/' . $destinationPath, 0777, true);
                }
                // this form uploads multiple files
                foreach ($request->file('file') as $fileKey => $fileObject ) {
                    // file phải đúng định dạng
                    if ($fileObject->isValid()) {
                        // make destination file name
                        $destinationFileName = time() . $fileObject->getClientOriginalName();
                        $fileName = rand(11111, 99999) . '.' . $destinationFileName; // renameing image
                        // move the file from tmp to the destination path
                        $fileObject->move($destinationPath, $fileName);
                        // // save the the destination filename
                        $input['name_file']     = 'Event Image';
                        $input['attached_file'] = $fileName;
                        $input['describe']   = 'Not yes';
                        $input['folder']        = $destinationPath;
                        $input['type_file']     = 0;
                        $input['parent_object_id'] = 2;
                        $input['object_id']     = $id;
                        $input['is_delete']     = 0;
                        $attach_file = AttachedFile::create($input);
                    }
                }
            }
        }
    }

    public function deleteImage(Request $request){
        if($request->ajax()){
            $id = $request->input('id');

        }
    }
    public function addTicket(Request $req){
        $event_id         = $req->event_id;
        $name_type_ticket = $req->name_type_ticket;
        $quantityTicket   = $req->quantity;
        $priceTicket      = $req->price;
        $description      = $req->description_ticket;

        $ticket  = new Ticket();
        $ticket->name_type_ticket = $name_type_ticket;
        $ticket->price            = $priceTicket;
        $ticket->quantity         = $quantityTicket;
        $ticket->description_ticket= $description;
        $ticket->event_id          = $event_id;
        $ticket->save();
        if($ticket){
            $last_id = $ticket->id;
        }
        return response()->json(['id'=>$last_id,'name_type_ticket'=>$name_type_ticket,'quantity'=>$quantityTicket,'price'=>$priceTicket,'description'=>$description]);
    }

    public function delete_image(Request $request, $id) {
        $img_id = $request->id;
        $event_id = $request->event;
        $delete = AttachedFile::where('id', $id)->first();
        $link_path = $delete->folder.$delete->attached_file;
        $deleteImage = AttachedFile::where('id', $id)->delete();
        if(File::exists($link_path)){
            File::delete($link_path);
        }
        $show = AttachedFile::where([['object_id', '=', $img_id], ['type_file', 0], ['parent_object_id', 2], ['is_delete', '=', 0]])->get();
        return response()->json(['image_event' => $show]);
    }

    public function delete_map(Request $request, $id) {
        $img_id = $request->id;
        $event_id = $request->event;
        $delete = AttachedFile::where('id', $id)->first();
        $link_path = $delete->folder.$delete->attached_file;
        $deleteImage = AttachedFile::where('id', $id)->delete();
        if(File::exists($link_path)){
            File::delete($link_path);
        }
        $show = AttachedFile::where([['object_id', '=', $img_id], ['type_file', 0], ['parent_object_id', 4], ['is_delete', '=', 0]])->get();
        return response()->json(['image_event' => $show]);
    }

    public function delete_document(Request $request, $id) {
        $img_id = $request->id;
        $event_id = $request->event;
        $delete = AttachedFile::where('id', $id)->first();
        $link_path = $delete->folder.$delete->attached_file;
        $deleteImage = AttachedFile::where('id', $id)->delete();
        if(File::exists($link_path)){
            File::delete($link_path);
        }
        $show = AttachedFile::where([['object_id', '=', $img_id], ['type_file', 1], ['parent_object_id', 2], ['is_delete', '=', 0]])->get();
        return response()->json(['image_event' => $show]);
    }

    public function editTicket(Request $request, $id){
        $ticket_id = $request->id;
        $event_id = $request->event_id;
        $name_ticket = $request->name_ticket;
        $price = $request->price;
        $price_ticket=(float)$price;
        $quantity = $request->quantity;
        $description = $request->description;
        $edit_ticket = Ticket::where('id', $id)->update(array('name_type_ticket' => $name_ticket, 'price' => $price_ticket, 'quantity' => $quantity,'description_ticket'=> $description, 'event_id' => $event_id));
        $edit_info = Ticket::where([['id', $id], ['is_delete', 0]])->first();
        $id_t = $edit_info->id;
        $name_t = $edit_info->name_type_ticket;
        $price_t = $edit_info->price;
        $quantity_t = $edit_info->quantity;
        $description_t = $edit_info->description_ticket;
        return response()->json(['id' => $id_t, 'name_ticket' => $name_t, 'price' => $price_t, 'quantity'=> $quantity_t, 'description' =>$description_t]);
    }

    public function deleteTicket(Request $request, $id){
        $ticket_id = $request->id;
        $event_id = $request->event_id;
        $is_delete = 1;
        $delete_ticket = Ticket::where('id', $id)->update(['is_delete' => $is_delete]);
        $showDelete = Ticket::where(array('id'=> $id, 'is_delete'=> $is_delete))->get();
        return response()->json(['delete_t' => $showDelete]);
    }
}