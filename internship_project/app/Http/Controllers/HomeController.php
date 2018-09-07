<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\order_detail;
use App\TypeEvent;
use App\Event;
use DB;
use Validator;
use Auth;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Socialite, Redirect, Session, URL;
use App\User;
use App\Ticket;
use App\Like;
use Illuminate\Pagination\LengthAwarePaginator;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    // public function getIndex(){
    //     return view('home');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //Hàm hiển thị sự kiện ra trang chủ
    public function index(Request $request)
    {   
        // Hiển thị ra dữ liệu của sự kiện nổi bật
        $event = new Event();
    	$eventall = $event->image_event();
        // Hiển thị sự kiện mới: Select từ bảng order và order detail
        $newevent = order_detail::getNewEvent();
        //Hiển thị sự kiện mới thông qua ngày bắt đầu sự kiện so với ngày hiện tại
        $start_event = order_detail::getNewEventViaDate();
        // Hiển thị loại event 
        $type_event = TypeEvent::select('id','name_type_event')->get();
        // show ra các sự kiện giảm giá
        $free_event = $event->event_free();
        // Show ra các sự kiện trả tiền vé
        $paid_event = $event->paid_event();
        //hiển thị số lượt like and comment
        return view('home',compact('type_event','newevent','start_event','free_event','paid_event','eventall'));
    }
    public function calcList($id) {
        $TypeId = TypeEvent::find($id);
        $event_to_type = Event::all()->where('type_event_id',$id)->get(); 
        return Response::json($event_to_type);
    }
    public function adminPage(){
        return view('layouts/admin/admin');
    }
    public function getEvent(){
        return view('client.page.event');
    }
    public function getTypeTicket($id){
        $typeticket = Ticket::where('event_id',$id);
        return view('home');
    }
  
    public function getAbout(){
        return view('client.page.about');
    }


         /**
     * Chuyển hướng người dùng sang OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver('google')->redirect();
    }  

    /**
     * Lấy thông tin từ Provider, kiểm tra nếu người dùng đã tồn tại trong CSDL
     * thì đăng nhập, ngược lại nếu chưa thì tạo người dùng mới trong SCDL.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            
        
            $googleUser = Socialite::driver('google')->user();
            $existUser = User::where('email',$googleUser->email)->first();
            

            if($existUser) {
                Auth::loginUsingId($existUser->id);
            }
            else {
                $user = new User;
                $user->email = $googleUser->email;
                $user->provider_id = $googleUser->id;
                $user->password = md5(rand(1,10000));
                $user->save();
                Auth::loginUsingId($user->id);
            }
            return redirect()->route('home');
        } 
        catch (Exception $e) {
            return 'error';
        }
    }

    public function redirect(){
        return Socialite::driver('facebook')->redirect();   
    }  
    public function callback($provider){
        try {
        
            $facebookUser = Socialite::driver('facebook')->user();
            $existUsers = User::where('email',$facebookUser->email)->first();
            

            if($existUsers) {
                Auth::loginUsingId($existUsers->id);
            }
            else {
                $user = new User;
                $user->email = $facebookUser->email;
                $user->provider_id = $facebookUser->id;
                $user->password = md5(rand(1,10000));
                $user->save();
                Auth::loginUsingId($user->id);
            }
            return redirect()->route('home');
        } 
        catch (Exception $e) {
            return 'error';
        }
    } 
    public function items(Request $request){
        $items = ['item1','item2', 'item3','item4','item5','item6','item7','item8','item9','item10'];
        $event = new Event();
        $eventall = $event->image_event();
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($items);
         // Define how many items we want to be visible in each page
        $perPage = 1;
         // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());
 
        return view('item_view', ['items' => $paginatedItems]);
    }

}