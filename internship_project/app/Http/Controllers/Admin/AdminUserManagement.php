<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\User;
use App\AttachedFile;
use App\Action;
use App\Group;
use App\UserGroup;
use App\UserAction;
use App\Order;

class AdminUserManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where([['is_delete',0], ['role', 1]])->orderBy('created_at','asc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::where('is_delete', 0)->orderBy('name_group', 'desc')->get();
        $actions = Action::where('is_delete', 0)->orderBy('name_action','desc')->get();
        return view('admin.users.create', compact('groups', 'actions'));
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

            'username'      => 'required|min:5',
            'email'         => 'required',
            'password'      => 'min:6|required',
            'conf_pass'     => 'min:6|required|same:password',
            'attached_file' => 'image|mimes:jpg,jpeg,png,gif',
            ],[
            'username.required'=> 'Vui lòng nhập tên username.',
            'username.min'      => 'Tên username quá ngắn.',
            'email.required'    => 'Vui lòng nhập email.',
            'password.required' => 'Vui lòng nhập password.',
            'password.min'      => 'Độ dài password lớn hơn 6 ký tự.',
            'conf_pass'         => 'Vui lòng nhập lại password.',
            'conf_pass'         => 'Độ dài password lớn hơn 6 ký tự.',
            'attached_file.mimes'=> 'Chỉ chấp nhận với đuôi .jpg .jpeg .png .gif',
        ]);

        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['username']  = $request->get('username');
            $input['email']     = $request->get('email');

            if (trim($request->password) != trim($request->conf_pass)) {
                $input = $request->except('password');
            } else {
                $input['password'] = bcrypt($request->password);
            }
            $input['password']  = bcrypt($request->password);
            $input['role']      = 1;
            $input['remmber_token'] = $request->get('_token');
            $input['is_delete'] = 0;
            $user = User::create($input);

            if ($user != null) {
                $file = $request->file('attached_file');
                if ($file) {  
                    $this->validate($request, 
                    [
                        'attached_file' => 'mimes:jpg,jpeg,png,gif|image',
                    ],          
                    [
                        'attached_file.mimes' => 'Chỉ chấp nhận với đuôi .jpg .jpeg .png .gif',
                    ]
                );
                    $year       = date('Y');
                    $month      = date('m');
                    $day        = date('d');
                    $user_id    = $user->id;
                    
                    $sub_folder = 'users'.'/'. $year . '/' . $month . '/' . $day . '/' . $user_id . '/';
                    $upload_url = 'images/' . $sub_folder;

                    if (!File::exists(public_path() . '/' . $upload_url)) {
                        File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
                    }
                    $name = time() . $file->getClientOriginalName();
                    $input['name_file'] = 'Avata Image';
                    $input['attached_file'] = $name;
                    $input['describe'] = 'Not yes';
                    $input['folder'] = $upload_url;
                    $input['type_file'] = 0;
                    $input['parent_object_id'] = 3;
                    $input['object_id'] = $user->id;
                    $input['is_delete'] = 0;
                    $file->move($upload_url, $name);
                    $attach_file = AttachedFile::create($input);
                }else{
                    $input['name_file'] = 'Avata Image';
                    $input['attached_file'] = 'placehold.it/400x400';
                    $input['describe'] = 'Not yes';
                    $input['folder'] = 'http://';
                    $input['type_file'] = 0;
                    $input['parent_object_id'] = 3;
                    $input['object_id'] = $user->id;
                    $input['is_delete'] = 0;
                    $attach_file = AttachedFile::create($input);
                } 

                $groups = $request->input('group');
                if($groups){
                    foreach ($groups as $group) {
                        $group_insert           = new UserGroup;
                        $group_insert->user_id  = $user->id;
                        $group_insert->group_id = $group;
                        $group_insert->is_delete = 0;
                        $group_insert->save();
                    }
                } 

                $actions = $request->input('action');
                if($actions){
                    foreach ($actions as $action) {
                        $user_action      = new UserAction;
                        $user_action->user_id = $user->id;
                        $user_action->action_id = $action;
                        $user_action->is_delete = 0;
                        $user_action->save();
                    }
                }
            }
            DB::commit();
        } catch (Exception $ex) {
            
        }  
        return redirect('/admin/users')->with('create_user', 'Tạo tài khoản thành công!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::where([['is_delete',0], ['role', 0]])->orderBy('created_at','asc')->paginate(10);
        return view('admin.users.client', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $groups = Group::where('is_delete', 0)->orderBy('name_group', 'desc')->get();
        $actions = Action::where('is_delete', 0)->orderBy('name_action', 'desc')->get();
        $attached_file = AttachedFile::where([['parent_object_id', 3], ['is_delete', 0], ['object_id', $id]])->get()->last();
        $user_action = new User();
        $user_actions = $user_action->user_action($id);

        $user_group = new User();
        $user_groups = $user_group->user_group($id);
        return view('admin.users.edit', compact('user', 'groups', 'actions', 'attached_file', 'user_actions', 'user_groups'));
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
        $user = User::findOrFail($id);
        if (trim($request->password) != trim($request->conf_pass)) {
            $input = $request->except('password');
        } else {
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }
       
        $user->update($input);
        DB::beginTransaction();
        try {
            $file = $request->file('attached_file');
                if ($file) {
                    $this->validate($request, 
                    [
                        'attached_file' => 'required|mimes:jpg,jpeg,png,gif|max:2048|image',
                    ],          
                    [
                        'attached_file.mimes' => 'Chỉ chấp nhận với đuôi .jpg .jpeg .png .gif',
                        'attached_file.max' => 'Dung lượng không quá 2M',
                    ]
                );
                    $year = date('Y');
                    $month = date('m');
                    $day = date('d');
                    $user_id = $user->id;
                    $sub_folder = 'users'.'/'. $year . '/' . $month . '/' . $day . '/' . $user_id . '/';
                    $upload_url = 'images/' . $sub_folder;

                    if (!File::exists(public_path() . '/' . $upload_url)) {
                        File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
                    }
                    $name = time() . $file->getClientOriginalName();

                    $file->move($upload_url, $name);
                    $attached_file = AttachedFile::where([['object_id', '=', $user_id], ['parent_object_id', '=', 3], ['is_delete', 0], ['type_file', 0]])
                        ->update(['attached_file' => $name, 'folder' => $upload_url]);
                }

                if(isset($user->id)){
                    $groups = $request->input('group');
                    $user_groups = UserGroup::where([['user_id', '=', $user->id], ['is_delete','=', 0]])->get();
                    if($user_groups){
                        foreach ($user_groups as $user_group){
                            $user_group_id    = $user_group->id;
                            $delete_user_group = DB::table('users_groups')->where('id', '=', $user_group_id )->delete();
                        }
                    }else{
                        $groups = $request->input('group');
                        if(count($groups) >= 1){
                            foreach ($groups as $group) {
                                $user_group      = new UserGroup;
                                $user_group->user_id = $user->id;
                                $user_group->group_id = $group;
                                $user_group->is_delete = 0;
                                $user_group->save();
                            }
                        }else{
                            echo "Không tồn tại";
                        }
                    }

                    if($groups){
                        $groups = $request->input('group');
                        foreach ($groups as $group) {
                            $user_group      = new UserGroup;
                            $user_group->user_id = $user->id;
                            $user_group->group_id = $group;
                            $user_group->is_delete = 0;
                            $user_group->save();
                        } 
                    }else{
                        echo "Không có nhóm nào được cập nhật.";
                    }
                }

                if(isset($user->id)){
                    $actions = $request->input('action');
                    $user_actions = UserAction::where([['user_id', '=', $user->id], ['is_delete','=', 0]])->get();
                    if($user_actions){
                        foreach ($user_actions as $user_action){
                            $user_action_id    = $user_action->id;
                            $delete_user_action = DB::table('user_actions')->where('id', '=', $user_action_id )->delete();
                        }
                    }else{
                        $actions = $request->input('action');
                        if(count($actions) >= 1){
                            foreach ($actions as $action) {
                                $user_action      = new UserAction;
                                $user_action->user_id = $user->id;
                                $user_action->action_id = $action;
                                $user_action->is_delete = 0;
                                $user_action->save();
                            }
                        }else{
                            echo "Không tồn tại";
                        }
                    }
                    if($actions){
                        $actions = $request->input('action');
                        foreach ($actions as $action) {
                            $user_action      = new UserAction;
                            $user_action->user_id = $user->id;
                            $user_action->action_id = $action;
                            $user_action->is_delete = 0;
                            $user_action->save();
                        } 
                    }else{
                        echo "Không có nhóm nào được cập nhật.";
                    }
                }
                DB::commit();
            } catch (Exception $ex) {
                
            }
            return redirect('/admin/users')->with('update_user', 'Cập nhật thành công!!'); 
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $is_delete = 1;
        $delete_user_group = UserGroup::where('user_id', '=', $id)->update(['is_delete' => $is_delete]);
        $delete_user_action = UserAction::where('user_id', '=', $id)->update(['is_delete' => $is_delete]);
        $delete_order = Order::where('user_id', '=', $id)->update(['is_delete' => $is_delete]);
        $user_avata = AttachedFile::where([['object_id', $id], ['parent_object_id', 3], ['type_file', 0]])->get();
        if($user_avata){
            foreach ($user_avata as $key => $avata) {
                if($avata->object_id == $id){
                    $avata_link = $avata->folder.$avata->attached_file;
                    $deleteAvata = AttachedFile::where('id', '=', $avata->id)->delete();
                    if (File::exists($avata_link)) {
                        File::delete($avata_link);
                    }
                }
            }
        }

        $user['is_delete'] = 1;
        $user->save();
        
        \Illuminate\Support\Facades\Session::flash('deleted_user', 'Thông tin tài khoản đã được xóa.');
        return redirect('/admin/users');
    }

    public function getGroup($id) {
        $group = new User();
        $groups = $group->user_group($id);
        return view('admin.groups.index', compact('groups'));
    }

    public function getAction($id) {
        $action = new User();
        $actions = $action->user_action($id);
        return view ('admin.actions.index', compact('actions'));
    }

    public function getOrder($id) {
        $order = new User();
        $orders = $order->user_order($id);
        return view ('admin.orders.index', compact('orders'));
    }
}
