<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Company;
use App\Event;
use Input,File;
use App\Contact;
use App\Ticket;
use App\User;
use App\Comment;
use App\TypeEvent;
use App\AttachedFile;
use App\Like;
use Illuminate\Pagination\LengthAwarePaginator;
class EventController extends Controller
{
    //Hàm hiển thị sự kiện theo công ty
    public function getEvent(Request $request,$evc){
        $type_event = TypeEvent::select('id','name_type_event')->get();
        $company = Company::all();
        $event = new Event();
        $event_company = $event->getEventToCompany($evc);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($event_company);
         // Define how many items we want to be visible in each page
        $perPage = 2;
         // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());
        return view('client.page.event',compact('company','type_event'),['event_company'=>$paginatedItems]);
    }
    public function getDetailevent(Request $request,$evd){
        // Hiển thị thông tin chi tiết của từng sự kiện
        $detail = new Event();
        $event_details = $detail->getEventDetail($evd);
        $ev_detail = Event::where('id',$evd)->first();
        $type_ticket = Ticket::select('id','name_type_ticket','price','quantity')->where('event_id',$ev_detail->id)->get();
        // Hiển thị những hình ảnh liên quan đến sự kiện
        $attached_file = new AttachedFile();
        $imageEventDetail = $attached_file->getImageEachEvent($evd);
        //hiển thị những công ty liên quan đến sự kiện đó
        $comp = new Company();
        $companies = $comp->getcompany_event($evd);
         // Hiển thị ra dữ liệu của sự kiện nổi bật
        $event = new Event();
        $eventall = $event->image_event();
         //In ra tất cả các hình ảnh của một sự kiện
        $all_image_event = $event->getAllimage_event($evd);
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($eventall);
         // Define how many items we want to be visible in each page
        $perPage = 2;
         // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());
        //hiển thị like
        $like  = new Like();
        $count = $like->LikeEvent($evd);
        //kiểm tra xem user đăng nhập đã like sự kiện nào hay chưa, nếu like rồi thì những sự kiện đó sẽ hiện lên màu xanh, còn ngược lại sẽ hiện màu trắng
        if(Auth::check()){
            $like  = new Like();
            $existLike = $like->LikeExist($evd,Auth::user()->id);
        }
        //hiển thị comments
        $array_comment = [];
        $comment = new Comment();
        $comment->getFullComment($array_comment,0,$evd);
        $comment = new Comment();
        $user = $comment->user_comment();
        $comments = DB::table('comments')->where([['event_id', $ev_detail->id], ['parent_id', 0], ['is_delete', 0]])->orderBy('created_at', 'asc')->get();
        return view('client.page.event_detail', compact('event_details','existLike', 'companies','type_ticket','imageEventDetail','comments','user','count','array_comment','all_image_event'), ['eventall' => $paginatedItems]);
    }
    //Hàm lưu thông tin đăng kí user
    public function postRegister(Request $request){
        $rules= [
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:20',
            'remember_token'=>'required|same:password',
        ];
        $this->validate($request, $rules);
        $user = new User();
        $user->email = $request->email;
        $user->password = $request->password;
        $user->remember_token = $request->remember_token;
        $user->is_delete = 0;
        $user->save();
        return redirect()->back()->with(['flash_level' => 'success','flash_message' =>'Thêm bài viết thành công']);
    }
    //Hiển thị tất cả các sự kiện
    public function getAllEvents(Request $request){
        $type_event = TypeEvent::select('id','name_type_event')->get();
        $company = Company::all();
        $event = new Event();
        $allevent = $event->getAllEvent();
        $is_search = 0;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($allevent);
        $perPage = 2;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('client.page.allevent',compact('type_event','company','is_search'),['allevent'=>$paginatedItems]);
    }
    //Full search text cho Client
    public function search() {
        $allevent = Event::search($_GET['search_text'])->paginate(3);
        $allevent->setPath('search?search_text='.$_GET['search_text']);
        $search_text = $_GET['search_text'];
        $is_search = 1;
        $type_event = TypeEvent::select('id','name_type_event')->get();
        $company = Company::all();
        return view('client.page.allevent', compact('allevent','company','type_event','is_search'));
    }
    //like function
    public function like(Request $request ,$id_event){
        $event_id = $request->event_id;
        $user_id  = $request->id_user;
        $like  = new Like();
        $existLike = $like->LikeExist($id_event,Auth::user()->id);
        $dem = count($existLike);
        if($request->ajax()){
            if($dem==0){

                $likeEvent  = new Like();
                $likeEvent->user_id     = $user_id;
                $likeEvent->type_object = 1;
                $likeEvent->object_id   = $event_id;
                $likeEvent->save();
                $show = new Like();
                $showCountLike = $show->LikeEvent($id_event);
                $Amountdemlike  = $showCountLike[0]->CountLike; 
            }
            else
            {
                $findId = Like::where([['user_id', '=', $user_id],['type_object', '=',1], ['object_id', '=', $event_id] ,['is_delete', '=', 0]])->get()->first();
                $idLike      = $findId->id;
                $disLike = Like::findOrFail($idLike);
                $disLike->delete();
                $show = new Like();
                $showCountLike = $show->LikeEvent($id_event);
                $Amountdemlike  = $showCountLike[0]->CountLike; 

            }
            return response()->json(['event_id'=>$event_id,'dem'=>$dem,'Amountdemlike'=>$Amountdemlike,'user_id'=>$user_id]);  
         } 
    }
    //Đếm số lượng like show ra trang chủ
    public function Countlike(Request $req){
        $event_id = $req->event_id;
        $like  = new Like();
        $count = $like->LikeEvent($event_id);
        if(count($count)==0){
            $countLike = 0;
        }
        else{

            $countLike = $count[0]->CountLike;
        }
        if($req->ajax()){
            return response()->json(['event_id'=>$event_id,'count'=>$countLike]);
        }
    }
    //Kiểm tra đã like hay chưa like sự kiện
    public function LikeOrNotYet(Request $req){
        $event_id = $req->event_id;
        $like  = new Like();
        if(Auth::check()){
          $existLike = $like->LikeExist($event_id,Auth::user()->id);
          $dem = count($existLike);
        }
        if($req->ajax()){
            return response()->json(['check'=>$dem,'event_id'=>$event_id]);
        }
    }
    //Comment
    public function comment_event(Request $req) {
        $content  = $req->content;
        $event_id = $req->event_id;
        $user = Auth::user()->id;
        if ($user) {
            $comment = new Comment();
            $comment->user_id  = $user;
            $comment->event_id = $event_id ;
            $comment->content  = $content;
            $comment->save();
            return response()->json($comment);
        }
    }
    //Reply
    public function reply_event(Request $req) {
        $comment_id = $req->comment_id;
        $parent_id  = $req->parent_id;
        $product_id = $req->product_id;
        $content    = $req->content;
        $user       = Auth::user()->id;
        if ($user) {
            $reply = new Comment();
            $reply->user_id   = $user;
            $reply->parent_id = $parent_id;
            $reply->event_id  = $product_id;
            $reply->content   =  $content;
            $reply->save();
            $array_comment = [];
            $comment = new Comment();
            $comment->getFullComment($array_comment,0,$product_id);
            foreach($array_comment as $comment){
                $count = count($comment['childs']);
            }
            return response()->json(['reply'=>$reply,'content'=>$content,'count'=>$count]);
        }
    }
      //Đếm số lượng comment show ra trang chủ
    public function CountComment(Request $req){
        $event_id = $req->event_id;
        $comment  = new Comment();
        $count = $comment->countComment($event_id);
        if(count($count)==0){
            $CountComment = 0;
        }
        else{

            $CountComment = $count[0]->CountComment;
        }
        if($req->ajax()){
            return response()->json(['event_id'=>$event_id,'countComment'=>$CountComment]);
        }
    }
}