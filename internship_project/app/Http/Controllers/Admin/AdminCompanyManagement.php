<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Storage;
use App\Company;
use App\AttachedFile;
use App\Event;
use App\CompanyEvent;

class AdminCompanyManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $company = new Company();
        $companies= $company->getCompany();
        $image = new Company();
        $images = $image->getImage();
        return view('admin.companies.index', compact('companies', 'images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.companies.create');
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
            'name_company'  => 'required|min:2',
            'address'       => 'required|min:5',
            'phone'         => 'required|min:10|max:15',
            'email'         => 'required',
            ], [
            'name_company.required' => 'Vui lòng nhập tên công ty.',
            'name_company.min'      => 'Tên công ty phải lớn hơn 2 kí tự.',
            'address.required'      => 'Vui lòng nhập địa chỉ.',
            'address.min'           => 'Địa chỉ phải lớn hơn 5 kí tự.',
            'phone.required'        => 'Vui lòng nhập số điện thoại',
            'phone.min'             => 'Số điện thoại phải lớn hơn hoặc bằng 10 kí tự.',
            'phone.max'             => 'Số điện thoại phải nhỏ hơn hoặc bằng 16 kí tự',
            'email.required'        => 'Vui lòng nhập email.',
        ]);

            $input = $request->all();
            $input['name_company'] = $request->get('name_company');
            $input['address'] = $request->get('address');
            $input['phone']   = $request->get('phone');
            $input['email']   = $request->get('email');
            $input['is_delete'] = 0;
            $company = Company::create($input);
             
        return redirect('/admin/companies')->with('create_company', 'Tạo mới công ty thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $company = Company::findOrFail($id);
        // $companies = Company::where('is_delete',0)->orderBy('created_at', 'asc')->paginate(10);

        // return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $company_images = AttachedFile::where([['object_id', $id], ['parent_object_id', 1], ['is_delete', 0], ['type_file', 0]])->get();
        return view('admin.companies.edit', compact('company', 'company_images'));
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
        $company = Company::findOrFail($id);
        $company->update($request->all());
        
        return redirect('/admin/companies')->with('update_company', 'Cập nhật thông tin thành công!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $is_delete = 1;
        //Kiểm tra xem event do công ty tổ chức do 1 hay nhiều công ty tổ chức, nếu là 1 thì event đó sẽ bị xóa, còn do nhiều công ty thì không bị xóa  
        $company_event = new Company();
        $c_events = $company_event->getEvent($id);
        if($c_events){
            foreach ($c_events as $key => $c_event) {
                $event_id = $c_event->id;
                $com = new Company();
                $com_ev = $com->getCompanyforEvent($event_id);
                if($com_ev){
                    if(count($com_ev) == 1){
                        $delete_event = Event::where('id', '=', $event->id)->update(['is_delete' => $is_delete]);
                    }
                }
            }
        }
        //Xóa công ty xóa luôn ảnh của công ty trong thư mục và DB
        $company_images = AttachedFile::where([['object_id', '=', $id], ['parent_object_id', '=', 1], ['type_file', 0], ['is_delete', '=', 0]])->get();

        if($company_images){
            foreach ($company_images as $key => $company_image) {
                $company_link = $company_image->folder.$company_image->attached_file;
                $deleteComapny = AttachedFile::where('id', '=', $company_image->id)->delete();
                if (File::exists($company_link)) {
                    File::delete($company_link);
                }
            }
        }  
        
        $delete_company_event = CompanyEvent::where('company_id', '=', $id)->update(['is_delete' => $is_delete]);
        $company['is_delete'] = 1;
        $company->save();

        \Illuminate\Support\Facades\Session::flash('deleted_company', 'Thông tin công ty đã được xóa!');
        return redirect('/admin/companies');
    }

    public function getEvent($id){
        $event = new Company();
        $events = $event->getEvent($id);
        $event_image = new Event();
        $images = $event_image->getImage();
        $event_document = new Event();
        $documents = $event_document->getDocument();
        $quantity_ticket = new Event();
        $quantity = $quantity_ticket->getQuantity();
        return view('admin.events.index', compact('events', 'images', 'documents', 'quantity'));
    }

   public function del_img(Request $request, $id) {
        $img_id = $request->id;
        $id_com = $request->company;
        $deleteImg = AttachedFile::where('id',$id)->first();
        $image_event_id = $deleteImg->object_id;
        $image_link = $deleteImg->folder.$deleteImg->attached_file;
        $deleteImgage = AttachedFile::where('id', '=', $id)->delete();
        if (File::exists($image_link)) {
            File::delete($image_link);
        }
//        Storage::delete($images->image_link);

        $show_images = AttachedFile::where([['object_id', '=', $image_event_id], ['type_file', 0], ['parent_object_id', 1], ['is_delete', '=', 0]])->get();
        return response()->json(['images' => $show_images]);
    }

    public function uploadFiles(Request $request, $id)
    {
        if ($request->ajax()) {
            //Kiểm tra ảnh sự tồn tại của files upload
            if ($request->hasFile('file')) {
                // $company_id = $request->input('company_id');
                $imageFiles = $request->file('file');
                // Quy định đường dẫn lưu ảnh
                $year   = date('Y');
                $month  = date('m');
                $day    = date('d');
                $sub_folder = 'companies'.'/'. $year . '/' . $month . '/' . $day . '/' .$id .'/';
                $path_folder = 'images/'. $sub_folder; // upload path
                if (!File::exists(public_path() . '/' . $path_folder)) {
                    File::makeDirectory(public_path() . '/' . $path_folder, 0777, true);
                }
                // this form uploads multiple files
                foreach ($request->file('file') as $fileKey => $fileObject ) {
                    // make sure each file is valid
                    if ($fileObject->isValid()) {
                        // make destination file name
                        $destinationFileName = time() . $fileObject->getClientOriginalName();
                        $fileName = rand(11111, 99999) . '.' . $destinationFileName; // renameing image
                        // move the file from tmp to the destination path
                        $fileObject->move($path_folder, $fileName);
                        // save the the destination filename
                        $input['name_file']     = 'Company Image';
                        $input['attached_file'] = $fileName;
                        $input['description']   = 'Not yes';
                        $input['folder']        = $path_folder;
                        $input['type_file']     = 0;
                        $input['parent_object_id'] = 1;
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
}
