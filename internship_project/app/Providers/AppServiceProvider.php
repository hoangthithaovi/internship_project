<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\TypeEvent;
use Session;
use App\Cart;
use App\Menu;
use Auth;
use App\Event;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(255);
        view()->composer('layouts.header', function($view){
            $type_event = TypeEvent::all();
            $view->with('type_event',$type_event);
        });
        view()->composer('layouts.slide_event', function($view){
            $event = new Event();
            $eventall = $event->image_event();
            $view->with('eventall',$eventall);
        });
        view()->composer(['layouts.header','client.page.payment','client.page.choose_ticket','client.page.cart','client.page.checkout','client.bill'],function($view){
            if(Session('cart')){
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $view->with(['cart'=> Session::get('cart'), 'product_cart'=>$cart->items,'totalPrice'=>$cart->totalPrice,'totalQty'=>$cart->totalQty]);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
