@extends('layout/account')

@section('title')
Contacts
@endsection

@section('topnav')
        <li>{{ HTML::linkAction('AccountController@index', 'OVERVIEW') }}</li>
        <li class="home">{{ HTML::linkAction('AccountController@contacts', 'CONTACTS') }}</li>
        <li>{{ HTML::linkAction('AccountController@tasks', 'TASKS') }}</li>
@endsection

@section('content')
<div class="tablet-hdr merge_bot clearfix">

<div class="title_dim"><h1>Contacts</h1></div>
  <div class="create_dim "><a class="plusbutton" href="{{ URL::to('/').'/account/create' }}">&nbsp;</a></div>
</div>
<div class="clear"></div>
<div class="sep2px desktop"></div>
<div class="tablet-padding boxin margin_40">
  <div class="alert alert-error notification1 hidden">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Warning!</strong> Please Provide valid name to continue.
  </div>
  <div class="clear"></div>
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Contact List</a></li>
    <a href="#" class="add_contact tab-desk">Add Contact</a>
  </ul>
    <div class="tab-content hasTable">
    <div class="tab-pane active" id="tab1">
  <div id="refreshcontact">
    <form action="{{ URL::to('/') }}/account/contacts" method="POST"><input type="hidden" name="order" value="{{ $nextorder }}"><input type="submit" value="order" class="order_button"></form>
    <table class="table">
      <thead>
        <tr>
          <th class="span6 sort prefix_1">Contact Name</th>
          <th class="span4">Date Added</th>
          <th class="span2 lastcol">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contacts as $contact)
        @if($contact)
        <tr class="count">
            <td class="span6 trtitle prefix_1 name{{ $contact->contactsID }}"><span>{{ $contact->cName }}</span><input type="text" value="{{ $contact->cName }}" style="display:none;" class="silver"></td>
            <td class="span4 email{{ $contact->contactsID }}"><span class="silver">{{ $contact->created_at }}</span></td>
            <td class="span2 lastcol"><a class="contact_edit button_edit" href="{{ $contact->contactsID }}"><span class="tab-desk">Edit</span></a><a class="contact_done button_save hidden" href="{{ $contact->contactsID }}"><span class="tab-desk">Save</span></a><a class="contact_delete button_del" href="{{ $contact->contactsID }}"><span class="tab-desk">Delete</span></a></td>
        </tr>
        
        @elseif
        <tr>
          <td class="trtitle prefix_1"><a class="grayitlic" href="{{ URL::to('/').'/account/create' }}">You don't have any contacts yet, Click here to start adding them.</a></td>
          <td class="silver">{{ date('Y-m-d H:i:s') }}</td>
          <td></td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
    </div>
    </div>
  </div><!--#refreshcontact -->
</div><!--tabable-->
</div><!--.tablet-padding-->
@endsection <!-- content -->
@section('phpFunctions')
  <script type="text/javascript">contactpage();  editBindEvent();
  delBindEvent();
  </script>
@endsection
