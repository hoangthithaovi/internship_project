<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use App\Group;
use App\Action;
use App\GroupAction;
use App\UserGroup;

class AdminGroupManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::where('is_delete',0)->orderBy('created_at','asc')->paginate(10);
        return view('admin.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actions = Action::where('is_delete', 0)->orderBy('created_at', 'asc')->get();
        return view('admin.groups.create', compact('actions'));
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
            'name_group' => 'required|min:4',
            'action'     => 'required',
            'description'=> 'required|min:5',
        ],[
            'name_group.required' => 'Vui lòng nhập tên nhóm.',
            'name_group.min'      => 'Tên nhóm lớn hơn 4 kí tự',
            'action.required'     => 'Vui lòng chọn.',
            'description.required'=> 'Vui lòng nhập mô tả.',
            'description.min'     => 'Mô tả phải lớn hơn 5 ký tự.',
        ]);

        DB::beginTransaction();
        try{
            $input = $request->all();
            $input['name_group'] = $request->get('name_group');
            $input['description']= $request->get('description');
            $input['is_delete']  = 0;
            $group = Group::create($input);
            if($group){
                $actions = $request->input('action');
                if ($actions){
                    foreach ($actions as $key => $action) {
                        $group_action           = new GroupAction;
                        $group_action->group_id = $group->id;
                        $group_action->action_id = $action;
                        $group_action->is_delete = 0;
                        $group_action->save();
                    }
                }
            }
            DB::commit();
        } catch (Exception $ex) {   
        }  
        return redirect('/admin/groups')->with('create_group', 'Tạo nhóm thành công!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $actions = Action::where('is_delete', 0)->orderBy('name_action', 'desc')->get();
        $group_action = new Group();
        $group_actions = $group_action->group_action($id);
        return view('admin.groups.edit', compact('group', 'actions', 'group_actions'));
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
        $group = Group::findOrFail($id);
        $group->update($request->all());
        if(isset($group->id)){
            $actions = $request->input('action');
            $group_actions = GroupAction::where([['group_id', '=', $group->id], ['is_delete','=', 0]])->get();
            if($group_actions){
                foreach ($group_actions as $group_action){
                    $group_action_id     = $group_action->id;
                    $delete_group_action = DB::table('group_actions')->where('id', '=', $group_action_id )->delete();
                }
            }else{
                $actions = $request->input('action');
                if(count($actions) >= 1){
                    foreach ($actions as $action) {
                        $group_action            = new GroupAction;
                        $group_action->group_id  = $group->id;
                        $group_action->action_id = $action;
                        $group_action->is_delete = 0;
                        $group_action->save();
                    }
                }else{
                    echo "Không tồn tại";
                }
            }

            if($actions){
                $actions = $request->input('action');
                foreach ($actions as $action) {
                    $group_action           = new GroupAction;
                    $group_action->group_id = $group->id;
                    $group_action->action_id = $action;
                    $group_action->is_delete = 0;
                    $group_action->save();
                } 
            }else{
                echo "Không có action mới nào được cập nhật.";
            }
        }
        return redirect('/admin/groups')->with('update_group', 'Cập nhật thông tin thành công!');; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group['is_delete'] = 1;
        $group->save();
        // Xóa group đồng thời xóa trong bảng group_action
        $is_delete = 1;
        $delete_group_action = GroupAction::where('group_id', '=', $id)->update(['is_delete' => $is_delete]);
        $delete_user_group = UserGroup::where('group_id', '=', $id)->update(['is_delete' => $is_delete]);
        \Illuminate\Support\Facades\Session::flash('deleted_group', 'Nhóm đã được xóa!');
        return redirect('/admin/groups');
    }

    // Lấy các action của group xác định
    public function getAction($id){
        $action = new Group();
        $actions = $action->getAction($id);
        // var_dump($actions);
        // exit();
        return view('admin.actions.index', compact('actions'));
    }
}
