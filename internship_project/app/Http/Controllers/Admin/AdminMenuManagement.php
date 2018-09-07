<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\controller;

use Illuminate\Http\Request;
use App\Menu;
use App\Action;

class AdminMenuManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::where([['parent_id', 0], ['is_delete', 0]])->orderBy('created_at', 'desc')->paginate(10);
        $pa = new Menu();
        $parent = $pa->parent();
        return view('admin.menus.index', compact('menus', 'parent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_menus = Menu::where([['parent_id', '=', 0], ['is_delete', '=', 0]])->orderBy('created_at', 'desc')->get();
        $actions = Action::where('is_delete',0)->orderBy('created_at', 'desc')->get();
        return view('admin.menus.create', compact('parent_menus', 'actions'));
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
            'name_menu' => 'required|min:2',
            'parent_id' => 'required',
            'url'       => 'required|min:3',
            'action_id' => 'required',
            'description'=> 'required',
            ], [
            'name_menu.required' => 'Vui lòng nhập tên menu.',
            'name_menu.min'      => 'Tên menu phải lớn hơn 2 kí tự.',
            'parent_id.required' => 'Vui lòng chọn menu cha.',
            'url.required'       => 'Vui lòng nhập đường dẫn.',
            'url.min'            => 'Đường dẫn phải lớn hơn 3 kí tự.',
            'action_id.required' => 'Vui lòng chọn!',
            'description'        => 'Vui lòng nhập mô tả.'
        ]);
             
        $input = $request->all();
        $input['name_menu'] = $request->get('name_menu');
        $input['parent_id'] = $request->get('parent_id');
        $input['url']       = $request->get('url');
        $input['action_id']   = $request->get('action_id');
        $input['description'] = $request->get('description');
        $input['is_delete'] = 0;
        $menu = Menu::create($input);
        return redirect('/admin/menus')->with('create_menu', 'Tạo mới menu thành công!');
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
        $parent_menus = Menu::where([['parent_id', '=', 0], ['is_delete', '=', 0]])->orderBy('created_at', 'desc')->get();
        $actions = Action::where('is_delete',0)->orderBy('created_at', 'desc')->get();
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', compact('menu', 'actions', 'parent_menus'));
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
        $menu = Menu::findOrFail($id);
        $menu->update($request->all());
        return redirect('/admin/menus')->with('update_menu', 'Cập nhật menu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu['is_delete'] = 1;
        $menu->save();
        \Illuminate\Support\Facades\Session::flash('deleted_menu','The menu has been deleted');
        return redirect('/admin/menus');
    }

    public function getChildMenu ($id) {
        $childMenu = new Menu();
        $menus = $childMenu->getChildMenu($id);
        $pa = new Menu();
        $parent = $pa->parent();
        return view('admin.menus.childMenu', compact('menus', 'parent'));
    }
}
