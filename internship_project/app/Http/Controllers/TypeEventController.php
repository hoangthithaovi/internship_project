<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeEvent;
use App\Company;
use App\Event;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
class TypeEventController extends Controller
{
    //Hiển thị các sự kiện theo loại sự kiện
    public function getTypeEvent(Request $request,$type){
    	$company = Company::all();
    	   // Hiển thị loại event 
        $type_event = TypeEvent::select('id','name_type_event')->get();
    	$types = TypeEvent::find($type);
    	$event = Event::where('type_event_id',$type);
        $event_type = new Event();
        $get_event = $event_type->getTypeEvent($type);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($get_event);
         // Define how many items we want to be visible in each page
        $perPage = 2;
         // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());
    	return view('client.page.event_demo',compact('company','type_event'),['get_event'=>$paginatedItems]);
    }
}
