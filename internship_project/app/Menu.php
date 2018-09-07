<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = ['id',
        'name_menu','action_id', 'url'
    ];

    public function action() {
        return $this->belongsTo('App\Action', 'action_id', 'id');
    }
    public function parent(){
        return $this->belongsTo('App\Menu', [['parent_id', 0],['is_delete', 0]]);
    }
    public function getChildMenu($id){
        $child = DB::select('select * from menus where is_delete = 0 and parent_id = ?', [$id]);
        return $child;
    }
    public function parent_menu(){
        return $this->where([['parent_id', 0],['is_delete', 0]])->get();
    }
    // Function show tất cả các menu ra ngoài trang admin đã kiểm tra là có quyền
    public function getFullmenu(&$menu, $parent_id, $rights_id_arr){
            //Show tất cả các menu và action, link_action ra ngoài trang admin nhưng hiện tại đây là một mảng Object
        $menu_tree = $this->select('menus.id', 'menus.name_menu', 'menus.action_id', 'menus.url', 'menus.parent_id', 'menus.description', 'actions.name_action', 'actions.link_action')
                            ->join('actions', 'actions.id', '=', 'menus.action_id')
                            ->where('parent_id', '=', $parent_id)
                            ->where('menus.is_delete', '=', 0)
                            ->get();

            //Show tất cả các menu và action, link_action ra ngoài trang admin đây là một mảng bình thường, ở đây tạo thêm một biến rights để kiểm tra có quyền hay không trả về True or False, và một mảng childs
            foreach ($menu_tree as $key => $data) {        
            $menu[] = ['id'=>$data->id,'parent_id'=> $data->parent_id, 'name_menu'=>$data->name_menu, 'action_id'=>$data->action_id, 'description'=>$data->description, 'name_action'=>$data->name_action, 'link_action'=>$data->link_action,'rights'=>in_array($data->action_id, $rights_id_arr),'childs'=>[]];
             
             $this->getFullmenu($menu[count($menu) -1]['childs'], $data->id, $rights_id_arr);
            }

        }
    // Function phân quyền menu cho admin đang đăng nhập vào
    public function getRightmenu(&$item){

        for ($i = count($item ) -1; $i >= 0; $i--) {
            $value = $item[$i];
            //Trường hợp value không có con child = 0 không có quyền thì xóa đi 
            if ($value['rights'] == false ) {

               if(count($value['childs']) == 0) {

                array_splice($item, $i ,1);

                }else{
                   $this->getRightmenu($item[$i]['childs']);

                   if (count($value['childs']) == 0) {
                       array_splice($item, $i ,1);
                   }
                }
               
            }else{
                $this->getRightmenu($value['childs']);
            }
            
        }

    }
    // Function bildMenu là dùng để in ra những menu có quyền của admin đang đăng nhập vào, In tree menu theo kiểu đệ qui
public function buildMenu($item){
        $result = "";
        
            foreach ($item as $key => $value) {

                $link_action = $value['link_action'];
                $result .= "<li>";
                $result .= "<a class='dropdown-toggle'>";
                $result .= " <a href='".$link_action."'>";
                $result .= "<span class='menu-text'>";
                $result .= $value['name_menu'];
                $result .= "</span>";
                $result .= "</a>";
                $result .= "</a>";
                if(count($value['childs'])>0){
                    $result .= "<ul class='submenu'>";
                    $result .= " <a href='".$link_action."'>";
                    $result .= $this->buildMenu($value['childs']);
                    $result .= "</a>";
                    $result .= "</ul>";
                }
                $result .= "</li>";
            }    
       
        return $result;
    }
}

    