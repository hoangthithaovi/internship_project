<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\order_detail;

class AdminOrderManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $find  = new Order();
        $orders = $find->getTicket();    
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $finishOrder = new Order();
        $finishOrders = $finishOrder->getFinishOrder();
        return view('admin.orders.orderFinish', compact('finishOrders'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
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
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return redirect('admin/orders')->with('update_order', 'Cập nhật hóa đơn thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order['is_delete'] = 1;
        $order->save();
        $is_delete = 1;
        $delete_order_detail = order_detail::where('order_id', '=', $id)->update(['is_delete' => $is_delete]);
        \Illuminate\Support\Facades\Session::flash('deleted_order', 'Hóa đơn đã được xóa!');
        return redirect('/admin/orders');
    }

    public function getOrderDetail($id){
        $order_detail = new Order();
        $order_details = $order_detail->getOrderDetail($id);
        return view('admin.orders.order_detail', compact('order_details'));
    }
}
