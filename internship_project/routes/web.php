<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Client
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('about', function () {
    return view('client.page.about');
});
// About
Route::get('about', [
    'as' => 'about',
    'uses' => 'HomeController@getAbout'
]);
// End
//Hiển thị trnag contact
Route::get('addcontact',[
    'as'=>'contactsofcustomer', 
    'uses' =>'MailController@getContact'
]);

Route::post('addcontact',[
    'as'=>'contactsofcustomerpost',
    'uses' =>'MailController@postMail'
]);
//End Contact
//Events Client
Route::get('events/{id}',[
    'as' => 'events', 
    'uses' => 'EventController@getEvent'
]);
//Chi tiết sự kiện
Route::get('eventsdetail/{type}',[
    'as'=>'detailevents',
    'uses'=>'EventController@getDetailevent'
]);
//get sự kiện theo loại
Route::get('loaievent/{id}',[
    'as' => 'loaisanpham', 
    'uses' => 'TypeEventController@getTypeEvent'
]);
//Hiển thị trang thanh toán
Route::get('checkout',[
    'as'=>'checkout', 
    'uses' =>'PageController@getCheckout'
]);
Route::post('checkout',[
    'as'=>'checkout',
    'uses' =>'PageController@postCheckout'
]);
//hiển thị giỏ cart
Route::get('shopping_cart',[
    'as'=>'shopping_cart',
    'uses'=>'PageController@getShoppingCart'
]);
//hiển thị thêm loại vé vào giỏ hàng
Route::get('chooseticket/{id}',[
    'as'=>'chooseticket',
    'uses'=>'PageController@getChooseTicket'
]);
//Giảm số lượng
Route::get('deductbyone/{id}',[
    'as'=>'deductbyone',
    'uses'=>'PageController@getReduceByOne'
]);
//Xóa vé trong giỏ hàng
Route::get('removeticket/{id}',[
        'as'=>'removeticket',
        'uses'=>'PageController@getDelItemCart'
]);
Route::get('Cartupdate',[
    'as'=>'getCartUpdate',
    'uses'=>'PageController@getCartUpdate'
]);
//hiển thị hóa đơn
Route::get('bill',[
    'as'=>'billticket',
    'uses'=>'PageController@getBill'
]);
//hiển thị tất cả sự kiện
Route::get('getallevent',[
    'as'=>'getallevent',
    'uses'=>'EventController@getAllEvents'
]);
//thêm sự kiện vào giỏ hàng
Route::get('addtocart/{id}',[
    'as'=>'themvaogio',
    'uses'=>'PageController@getAddtoCart'
]);

//hiển thị hóa đơn vừa mới mua hàng
Route::get('getBill/{id}',[
    'as'=>'getBill',
    'uses'=>'PageController@getBill'
]);
//hiển thị tất cả hóa đơn
Route::get('showbill/{id}',[
    'as'=>'showbill',
    'uses'=>'PageController@showBill'
]);
// hoãn vé trước 48 giờ
Route::get('removebill/{id}',[
    'as'=>'removebill',
    'uses'=>'PageController@deleteBill'
]);
// get search client
Route::get('searchs',[
    'as' => 'eventssearch', 
    'uses' => 'EventController@search'
]);
//Comment và reply
Route::post('comment_event',[
    'as'     =>'comment_event',
    'uses'   =>'EventController@comment_event'
]);
Route::get('reply_event',[
    'as' =>'reply_event',
    'uses'   =>'EventController@reply_event'
]);
//like sự kiện
Route::get('likeEvent/{id}',[
    'as'=>'likeEvent',
    'uses'  =>'EventController@like'
]);
//Đếm số lượng like ở trang chủ
Route::get('likeEventCount',[
    'as'=>'likeEventCount',
    'uses'  =>'EventController@Countlike'
]);
//End like
Route::get('LikeOrNotYet',[
    'as'=>'LikeOrNotYet',
    'uses'  =>'EventController@LikeOrNotYet'
]);
//Đếm số lượng comment ở trang chủ
Route::get('CommentEventCount',[
    'as'=>'CommentEventCount',
    'uses'  =>'EventController@CountComment'
]);
//End router Client
// Router dành cho admin
Route::group(['middleware' => ['admin']], function () {
     //Route Admin
    Route::get('admin', 'Admin\AdminManagement@index')->name('admin');
    Route::resource('admin/groups', 'Admin\AdminGroupManagement', array('as'=> 'admin'));
    Route::get('admin/groups/{id}/action', 'Admin\AdminGroupManagement@getAction');
    //Route quản lý user
    Route::resource('admin/users', 'Admin\AdminUserManagement', array('as'=>'admin'));
    Route::get('admin/users/{id}/groups', 'Admin\AdminUserManagement@getGroup');
    Route::get('admin/users/{id}/actions', 'Admin\AdminUserManagement@getAction');
    Route::get('admin/users/{id}/orders', 'Admin\AdminUserManagement@getOrder');

    Route::resource('admin/actions', 'Admin\AdminActionManagement', array('as' => 'admin'));
    Route::resource('admin/contacts', 'Admin\AdminContactManagement', array('as'=>'admin'));

    Route::resource('admin/menus', 'Admin\AdminMenuManagement', array('as' => 'admin'));
    Route::get('admin/menus/{id}/child', 'Admin\AdminMenuManagement@getChildMenu');

    Route::resource('admin/orders', 'Admin\AdminOrderManagement', array('as' => 'admin'));
    Route::get('admin/orders/{id}/order_detail', 'Admin\AdminOrderManagement@getOrderDetail');
    //Route quản lý công ty tổ chức sự kiện
    Route::resource('admin/companies', 'Admin\AdminCompanyManagement', array('as'=> 'admin'));
    Route::get('admin/companies/{id}/events', 'Admin\AdminCompanyManagement@getEvent');
    Route::get('del_image/{id}',['as'=>'del_image','uses'  =>'Admin\AdminCompanyManagement@del_img'
    ]);
    Route::post('uploadImagesCompany/{id}',[
        'as'=>'uploadImagesCompany',
        'uses'  =>'Admin\AdminCompanyManagement@uploadFiles'
    ]);
    //End
    Route::resource('admin/type_events', 'Admin\AdminTypeEventManagement', array('as' => 'admin'));
    Route::get('admin/type_events/{id}/events', 'Admin\AdminTypeEventManagement@getEvent');

    Route::resource('admin/events', 'Admin\AdminEventManagement', array('as' => 'admin'));
    //Delete event image
    Route::get('delete_image/{id}', ['as'=>'delete_image', 'uses' => 'Admin\AdminEventManagement@delete_image']);
    Route::get('update_ticket/{id}', ['as'=>'update_ticket', 'uses'=>'Admin\AdminEventManagement@editTicket']);
    //Xem công ty tổ chức sự kiện
    Route::get('admin/events/{id}/companies', 'Admin\AdminEventManagement@getCompany');
    //Xem loại sự kiện
    Route::get('admin/events/{id}/type_event', 'Admin\AdminEventManagement@getTypeEvents');
    //Xem vé sự kiện
    Route::get('admin/events/{id}/tickets', 'Admin\AdminEventManagement@getTicket');
    //Upload ảnh
    Route::post('uploadImagesEvents/{id}',[
        'as'=>'uploadImagesEvents',
        'uses'  =>'Admin\AdminEventManagement@uploadFiles'
    ]);
    //Xóa ảnh sự kiện
    Route::post('deleteImage','Admin\AdminEventManagement@deleteImage');
    //Xóa vé sự kiện
    Route::get('delete_ticket/{id}', ['as'=> 'delete_ticket', 'uses' => 'Admin\AdminEventManagement@deleteTicket']);
    //Thêm vé sự kiện
    Route::get('addTicket',[
        'as' =>'addTicket',
        'uses'=>'Admin\AdminEventManagement@addTicket'
    ]);

    Route::resource('admin/comments', 'Admin\AdminCommentManagement', array('as'=>'admin'));
    Route::get('admin/comments/{id}/reply' , 'Admin\AdminCommentManagement@getReplyComment');

    Route::resource('admin/tickets', 'Admin\AdminTicketManagement', array('as' => 'admin'));
    // get search admin
    Route::get('searchsadmin',[
        'as' => 'eventssearchadmin', 
        'uses' => 'Admin\AdminEventManagement@searchAdmin'
    ]);
});

Route::get('/redirect', 'HomeController@redirect');
Route::get('/auth/{provider}/callbacks', 'HomeController@callback');
Route::get('/auth/{provider}', 'HomeController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'HomeController@handleProviderCallback');

//Router dành cho Client