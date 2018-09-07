<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Mail;
use App\Contact;
use Redirect;
class MailController extends Controller
{
    //Hàm hiển thị trang liên hệ
    public function getContact(){
    	return view('client.page.contact');
    }
    //Hàm lưu thông tin liên hệ và gửi email đến admin
    public function postMail(Request $request) {
		$data = array('email'=>$request->email, 'subject'=>$request->subject,'user_message' => $request->content);
		Mail::send('client.page.email', $data, function($message) use ($data) {
			$message->from('vi.hoang0706@gmail.com','Hoàng Thị Thảo Vi');
			$message->to($data['email'], 'Artisans Web');
			$message->subject($data['subject']);
		});
		$contacts = new Contact();
        $contacts->email = $request->email;
        $contacts->subject = $request->subject;
        $contacts->content = $request->content;
        $contacts->is_delete = 0;
        $contacts->save();
		return redirect()->back()->with('success','Thank you for your message!');
    }
}
