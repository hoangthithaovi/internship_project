<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Menu;
use Auth;

use App\UserAction;
use App\UserGroup;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    
    // protected $redirectTo = '/home';

     // protected $redirectTo = '/admin';
     // 
     // 
     // 
   
    protected $redirectTo;
    protected function redirectTo()
    {

        $link = '/admin';
        $users_group = new UserGroup();
        $users_action = new UserAction();
        $fullRights = array_merge($users_action->getRights_id_arr(Auth::user()->id),
        $users_group->getRights_id_arr(Auth::user()->id));
        $array_menu = [];
        $menu = new Menu();
        $menu->getFullmenu($array_menu,0,$fullRights);
        $menu->getRightmenu($array_menu);
        $menu_string = $menu->buildMenu($array_menu);
        Session::put('menu', $menu_string);

        if (Auth::check())
        {
            if(Auth::user()->role==1){
                $this->redirectTo = $link;
                return $this->redirectTo;
            }
            else
            {
            return '/';
            }
        }
        else 
        {
            return redirect('/login');
        }
       
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        
    }


}


