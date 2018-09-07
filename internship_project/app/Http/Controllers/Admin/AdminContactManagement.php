<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Contact;

class AdminContactManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::where('is_delete', 0)->orderBy('created_at', 'asc')->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact['is_delete'] = 1;
        $contact->save();
        \Illuminate\Support\Facades\Session::flash('deleted_contact', 'Phản hồi đã được xóa.');
        return redirect('/admin/contacts');
    }
}
