<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Cart;
use App\Event;
use DB;
use App\Order;
use App\Ticket;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use App\order_detail;
use App\AttachedFile;
use App\Http\Controllers\Carbon;
class PageController extends Controller
{
    //Add ticket to cart
    public function getAddtoCart(Request $req,$id){
        $ticket = Ticket::find($id);
        $slTicket = Ticket::select('quantity')->where('id',$id)->get();
        foreach($slTicket as $key =>$data){
            $sl = $data['quantity'];
        }
        $quantity_data = new Order();
        $quantity_order = $quantity_data->getQuantity($id); 
        if(count($quantity_order) > 0 ){
            foreach ($quantity_order as $keys => $value) {
                $slOrder = $value->qty;
                $slOrder = $slOrder + 0 ;
            }
            $quan1 = $req->quantity;
            $quan  = (int)$quan1;
            $sumQty = $quan + $slOrder;
            $HetVe  = $sl - $sumQty;
            $oldCart = Session('cart')?Session::get('cart'):null;
            $cart = new Cart($oldCart);
            if($HetVe > 0 ){
                $cart->add($ticket, $id,$req->price);
                $req->session()->put('cart',$cart);
                if($req->ajax()){
                    return response()->json(['quantyti' => Session::get('cart')->totalQty, 'totalprice' => Session::get('cart')->totalPrice, 'totaltong' => Session::get('cart')->totaltong,'slTicket'=>$sl,'HetVe'=>$HetVe,'quantity_order'=>$slOrder,'quan'=>$quan,'qty' => Session::get('cart')->items[$id]['qty'], 'price' => Session::get('cart')->items[$id]['price'],'price_up'=>Session::get('cart')->items[$id]['price_update']]);
                    }
                }
                else 
                {
                    if($req->ajax()){
                    return response()->json(['quantyti' => Session::get('cart')->totalQty, 'totalprice' => Session::get('cart')->totalPrice, 'totaltong' => Session::get('cart')->totaltong,'slTicket'=>$sl,'HetVe'=>$HetVe,'quantity_order'=>$slOrder,'qty' => Session::get('cart')->items[$id]['qty'], 'price' => Session::get('cart')->items[$id]['price'],'price_up'=>Session::get('cart')->items[$id]['price_update']]);
                    }
                }
        }
        else 
        {
            $quan1 = $req->quantity;
            $quan  = (int)$quan1;
            $oldCart = Session('cart')?Session::get('cart'):null;
            $cart = new Cart($oldCart);
            if($quan<$sl){
                $cart->add($ticket, $id,$req->price);
                $req->session()->put('cart',$cart);
                if($req->ajax()){
                    return response()->json(['quantyti' => Session::get('cart')->totalQty, 'totalprice' => Session::get('cart')->totalPrice, 'totaltong' => Session::get('cart')->totaltong,'qty' => Session::get('cart')->items[$id]['qty'], 'price' => Session::get('cart')->items[$id]['price'],'quan'=>$quan,'sl'=>$sl,'price_up'=>Session::get('cart')->items[$id]['price_update']]);
                    }
            }
            else{
                if($req->ajax()){
                return response()->json(['quantyti' => Session::get('cart')->totalQty, 'totalprice' => Session::get('cart')->totalPrice, 'totaltong' => Session::get('cart')->totaltong,'qty' => Session::get('cart')->items[$id]['qty'],'quan'=>$quan,'sl'=>$sl,'price' => Session::get('cart')->items[$id]['price'],'price_up'=>Session::get('cart')->items[$id]['price_update']]);
                }
            }
        }
      
        return redirect()->back();
    }
    //Xóa từng vé trong giỏ cart
    public function getDelItemCart($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            $data = Session::put('cart', $cart);
        } else {
            $data = Session::forget('cart');
        }
        $quantity = Session::has('cart') ? Session::get('cart')->totalQty : 0;
        $totalprice = Session::has('cart') ? Session::get('cart')->totalPrice : 0;
        $totaltong = Session::has('cart') ? Session::get('cart')->totaltong : 0;
    return response()->json(['html' => $data, 'quantity' => $quantity, 'totalprice' => $totalprice, 'totaltong' => $totaltong]);
    }
    //Hiển thị trang thanh toán
    public function getCheckout(){
        if (!Session::has('cart')) 
        {
            return view('client.page.cart');
        }
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            $total = $cart->totalPrice;
            return view('client.page.payment');     
    }
    //Lưu thông tin thanh toán vào Order và Order detail
    public function postCheckout(CheckoutRequest $req){
    $cart = Session::get('cart');
    $user = Auth::user();
    if($user) {

        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->fullname = $req->name;
        $order->email = $req->email;
        $order->address = $req->address;
        $order->phone_number = $req->phone;
        $order->date_order = date('Y-m-d');
        $order->type_of_payment = $req->payment_method;
        $order->notes = $req->notes;
        $order->save();
        foreach ($cart->items as $key => $value) {
            $order_detail = new order_detail;
            $order_detail->order_id = $order->id;
            $order_detail->ticket_id = $key;
            if($key){
                $quantity_db= Ticket::select('id','quantity')->where([['id', $key], ['is_delete','=', 0]])->get(); 
                foreach($quantity_db as $key=>$data){
                   $quantity_data = $data['quantity']; 
                }
                $quantity_order = $value['qty'];
                $quantity_order = $quantity_order + 0;
                $quantity_now = $quantity_data - $quantity_order; 
              
                $quantity_ticket = DB::table('tickets')->where('id', $key)
                                   ->update(['quantity' => $quantity_now]); 
                // dd($quantity_ticket);
            }
            $order_detail->quantity = $value['qty'];
            $order_detail->price = $value['price'];
            $order_detail->total = $value['price_update'];
            $order_detail->save();
        }
        Session::forget('cart');
        return redirect()->route('getBill',Auth::user()->id)->with(['getOrder','message', 'Message sent!']);
    }
    else 
    {
         return redirect()->route('login')->with('message','Please login before payment');
    }     

    }
    //Hiển thị thông tin của giỏ hàng
    public function getShoppingCart(){
       if (!Session::has('cart')) {
            return view('client.page.cart', ['product_cart' => null]);
        }
        else 
        {
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            return view('client.page.cart', ['product_cart' => $cart->items, 'totalPrice' => $cart->totalPrice]);
        }
    }
    //Hiển thị trang chọn vé
    public function getChooseTicket($type){
        $name_event = Event::select('title_event','location','date_start','date_end')->where('id',$type)->first();
        $type_event =Ticket::select('id','name_type_ticket','price','event_id')->where('event_id',$type)->get();
        //Hiển thị sơ đồ chỗ ngồi ứng với các sự kiện(sẽ có sơ đồ hay không có sơ đồ chỗ ngồi)
        $map = new AttachedFile();
        $mapEvent = $map->getMapEvent($type);
        //End
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('client.page.choose_ticket',compact('type_event','name_event','mapEvent'),['product_cart'=>$cart->items,'totalPrice'=>$cart->totalPrice,'totalQty'=>$cart->totalQty]);
    }
    //Giảm số lượng vé trong giỏ hàng Ajax
    public function getReduceByOne($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return response()->json(['quantyti' => Session::get('cart')->totalQty, 'qty' => Session::get('cart')->items[$id]['qty'], 'price' => Session::get('cart')->items[$id]['price'], 'totaltong' => Session::get('cart')->totaltong, 'totalprice' => Session::get('cart')->totalPrice,'price_up'=>Session::get('cart')->items[$id]['price_update']]);
    }
    //Hiển thị ra thông tin hóa đơn của khách hàng vừa mới mua
    public function getBill($id_user){
        $order = new Order();
        $getOrder = $order->getOrder($id_user);
        $getCusInfor = $order->getCusInfor($id_user);
        return view('client.bill',compact('getOrder','getCusInfor'));
    }
    //Hiển thị tất cả hóa đơn của khách hàng
    public function showBill($id_user){
        $order = new order_detail();
        $showBill = $order->showBill($id_user);
        $customer = new Order();
        $getCusInfor = $customer->getCusInfor($id_user);
        return view('client.page.ShowAllBill', compact('showBill','getCusInfor'));
    }
    //Hủy hóa đơn trước 48 giờ
    public function deleteBill(Request $request, $id){
        $order = order_detail::where('order_id',$id)->first();
        $order_detailID = $request->order_id;
        $date_start = $request->date_started;
        $date = date('Y-m-d H:i:s');
        $start_time = \Carbon\Carbon::parse($date);
        $finish_time = \Carbon\Carbon::parse($date_start);
        $result = $start_time->diffInHours($finish_time, false);
        if($result >=48){
            if($request->ajax()){
                   $order1 = order_detail::findOrFail($id);
                   $order1['is_delete'] = 1;
                   $order1->save();
                   $show = new order_detail();
                   $showBill = $show->showBill(Auth::user()->id);
                   return response()->json(['html'=>$showBill,'date_start'=>$date_start,'result'=>$result,'is_delete'=>$order1['is_delete']]);
            }
              
        }
        else
        {
           $thongbao ="Bạn không thể hủy vé!";
            return response()->json(['thongbao'=>$thongbao]);
        }
    }
}
