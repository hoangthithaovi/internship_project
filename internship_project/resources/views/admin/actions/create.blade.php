@extends('layouts.admin.admin')

@section('content')


<div class="container">
    <h1 style="color: #0099CC; text-align: center; margin:20px;">Tạo mới Action</h1>
    <form action="{{ route('admin.actions.store') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

        <div class="form-group {{ $errors->has('name_action') ? 'has-error' : '' }}">
            <label> Tên hành động:</label>
            <input type="text" id="name_action" name="name_action" class="form-control" placeholder="Nhập tên hành động..." value="{{ old('name_action') }}" required>
            <span class="text-danger">{{ $errors->first('name_action') }}</span>
        </div>    

        <div class="form-group {{ $errors->has('link_action') ? 'has-error' : '' }}">
            <label> Đường dẫn:</label>
            <input type="text" id="link_action" name="link_action" class="form-control" placeholder="Nhập đường dẫn..." value="{{ old('link_action') }}" list="defaultLink" required>

            <datalist id="defaultLink">
                <option value="admin/actions" label="Show Actions">
                <option value="admin/actions/create" label="Create Action">
                <option value="admin/comments" label="Show Comments">
                <option value="admin/companies" label="Show Companies">
                <option value="admin/companies/create" label="Create Comapny">
                <option value="admin/contacts" label="Show Contacts">
                <option value="admin/events" label="Show Events">
                <option value="admin/events/create" label="Create Event">
                <option value="admin/groups" label="Show Groups">
                <option value="admin/groups/create" label="Create Group"> 
                <option value="admin/menus" label="Show Menus">
                <option value="admin/menus/create" label="Create Menu">
                <option value="admin/orders" label="Show Orders">
                <option value="admin/orders/unfinish" label="Show Unfinish Orders">
                <option value="admin/orders/finish" label="Show Finish Orders">
                <option value="admin/tickets/create" label="Create Tickets">
                <option value="admin/type_events" label="Show/Create Type Events">
                <option value="admin/users" label="Show Users">
                <option value="admin/users/create" label="Create Users"> 
            </datalist>
            <span class="text-danger">{{ $errors->first('link_action') }}</span>
        </div>  

        <div class=" form-group {{ $errors->has('is_public') ? 'has-error' : '' }}">
            <label>Quyền công khai:</label>
            <label class="radio-inline">
                <input type="radio" name="is_public" value="0">Không
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_public" value="1">Có
            </label>
            <span class="text-danger">{{$errors->first('is_public')}}</span>
        </div>

        <div class=" form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            <label>Mô tả:</label>
            <textarea class="form-control" rows="5" id="description" name="description" placeholder="Nhập mô tả..."></textarea>
            <span class="text-danger">{{ $errors->first('description') }}</span>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Tạo mới" />
        </div> 
    </form>       
</div>  
@stop