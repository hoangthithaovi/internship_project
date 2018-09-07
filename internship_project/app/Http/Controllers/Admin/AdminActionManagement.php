<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Action;
use App\UserAction;
use App\GroupAction;
use App\Menu;

class AdminActionManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = Action::where('is_delete','==',0)->orderBy('created_at', 'asc')->get();
        return view('admin.actions.index', compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.actions.create');
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
            'name_action' => 'required|min:2',
            'link_action' => 'required|min:3',
            'is_public'   => 'required',
            'description' => 'required|min:3',
            ], [
            'name_action.required' => 'Vui lòng nhập tên hành động.',
            'name_action.min'      => 'Tên hành động quá ngắn.',
            'link_action.required' => 'Vui lòng nhập đường dẫn.',
            'link_action.min'      => 'Đường dẫ quá ngắn.',
            'is_public.required'   => 'Vui lòng chọn.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'description.min'      => 'Mô tả quá ngắn, không đáp ứng yêu cầu.'
        ]);
             
        $input = $request->all();
        $input['is_delete'] = 0;
        Action::create($input);
        return redirect('/admin/actions')->with('create_action', 'Tạo mới thành công.');
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
        $action = Action::findOrFail($id);
        return view('admin.actions.edit', compact('action'));
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
        $action = Action::findOrFail($id);
        $action->update($request->all());
        return redirect('/admin/actions')->with('update_action', 'Cập nhật thành công!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $action = Action::findOrFail($id);
        $is_delete = 1;
        $deleted_group_action = UserAction::where('action_id', '=', $id)->update(['is_delete' => $is_delete]);
        $delete_user_action = GroupAction::where('action_id', '=', $id)->update(['is_delete' => $is_delete]);
        $delete_menu = Menu::where('action_id', '=', $id)->update(['is_delete' => $is_delete]);
        $action['is_delete'] = 1;
        $action->save();
        \Illuminate\Support\Facades\Session::flash('deleted_action','Hành động đã được xóa!');
        return redirect('/admin/actions');
    }
}
