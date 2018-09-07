<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ticket;
use App\Event;

class AdminTicketManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::where('is_delete',0)->orderBy('created_at','desc')->get();
        $tickets = Ticket::where('is_delete',0)->orderBy('event_id','asc')->paginate(10);
        return view('admin.tickets.index', compact('tickets', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name_type_ticket' => 'required|min:4',
            'price'            => 'required',
            'quantity'         => 'required',
            'event_id'         => 'required',
            'description'      => 'required|min:5',
        ],[
            'name_type_ticket.required' => 'Name ticket is required.',
            'name_type_ticket.min'      => 'Name ticket is very short.',
            'price.required'            => 'Price is required.',
            'quantity.required'         => 'Quantity is required.',
            'event_id.required'         => 'Please choose name event.',
            'description.required'      => 'Description is required.',
            'description.min'           => 'Description is very short.',
        ]);

        $input = $request->all();
        $input['is_delete'] = 0;
        Ticket::create($input);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket['is_delete'] = 1;
        $ticket->save();
        \Illuminate\Support\Facades\Session::flash('deleted_ticket','Vé đã được xóa');
        return redirect('/admin/tickets');
    }
}