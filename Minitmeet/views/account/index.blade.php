@extends('layout/account')

@section('title')
Meeting Overview
@endsection

@section('topnav')
        <li class="home">{{ HTML::linkAction('AccountController@index', 'OVERVIEW') }}</li>
        <li>{{ HTML::linkAction('AccountController@contacts', 'CONTACTS') }}</li>
        <li>{{ HTML::linkAction('AccountController@tasks', 'TASKS') }}</li>
@endsection
 
@section('content')
<div class="tablet-hdr merge_bot clearfix">

<div class="title_dim"><h1>My Meetings Overview</h1></div>
  <div class="create_dim "><a class="plusbutton" href="{{ URL::to('/').'/account/create' }}">&nbsp;</a></div>
</div>
<div class="clear"></div>
<div class="sep2px desktop"></div>
<div class="tablet-padding boxin margin_40">
  <!-- <div id="success" class="label label-success" style="display:none">Successfully Deleted Minute And it' Details</div> -->
  <div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Drafts ( <span class="tab1Count">0</span> )</a></li>
    <li><a href="#tab2" data-toggle="tab">Sent ( <span class="tab2Count">0</span> )</a></li>
    <li><a href="#tab3" data-toggle="tab">Recieved ( <span class="tab3Count">0</span> )</a></li>
  </ul>
  <div class="tab-content hasTable">
    <div class="tab-pane active" id="tab1">
     		<table class="table">
              <thead>
                <tr>
                  <th class="prefix_1 span6">Meeting Title<span class="DTOrder icon_order" data-order="desc">&nbsp;</span></th>
                  <th class="span4">Date<span class="DDOrder icon_order" data-order="desc">&nbsp;</span></th>
                  <th class="span2 lastcol">Action</th>
                </tr>
              </thead>
              <tbody>
          <?php  foreach($draft_minutes as $draft_minute){
          if($draft_minute){?>
          <tr class="count">
            <?php if ($draft_minute->mTitle == ''){?>
                <td class="trtitle prefix_1 span6"><div class="test" style="text-overflow:ellipsis;"><a class="blue" href="{{ URL::to('/') }}/account/edit?id={{ $draft_minute->mID }}">No Title Assigned Yet</a></div></td>
            <?php }else{ ?>
                <td class="trtitle prefix_1 span6"><div class="test" style="text-overflow:ellipsis;"><a class="blue" href="{{ URL::to('/') }}/account/edit?id={{ $draft_minute->mID }}">{{ $draft_minute->mTitle }}</a></div></td>
                    <td class="silver span4">{{ $draft_minute->selected_date }}</td>
                    <td class="span2 lastcol"><a href="{{ URL::to('/') }}/account/edit?id={{ $draft_minute->mID }}" class="button_edit"><span class="tab-desk">Edit</span></a><a class="button_del deleteDraft" href="{{ $draft_minute->mID }}"><span class="tab-desk">Delete</span></a></td>
          </tr>
         
          <?php }}else{ ?>
          <tr>
            <td class="trtitle prefix_1"><a class="grayitlic" href="{{ URL::to('/').'/account/create' }}">Welcome. You have not created any meetings yet. Click here to get started.</a></td>
            <td class="silver">{{ date('Y-m-d H:i:s') }}</td>
            <td></td>
          </tr>
          <?php }}?>
        
              </tbody>
            </table>
    </div>
    <div class="tab-pane" id="tab2">
        <table class="table">
              <thead>
                <tr>
                  <th class="prefix_1 span6">Meeting Title<span class="STOrder icon_order" data-order="desc">&nbsp;</span></th>
                  <th class="span4">Date<span class="SDOrder icon_order" data-order="desc">&nbsp;</span></th>
                  <th class="span2 lastcol">Action</th>
                </tr>
              </thead>
              <tbody>
          @foreach ($sent_minutes as $sent_minute)
          @if($sent_minute)
          <tr class="count">
          
            @if ($sent_minute->mTitle == '')
                <td class="trtitle prefix_1 span6"><div class="test" style="text-overflow:ellipsis;"><a class="blue" target="_blank" href="{{URL::to('/')}}/create_result?view=view&id={{ $sent_minute->mID }}">No Title Assigned Yet</a></div></td>
            @else
                <td class="trtitle prefix_1 span6"><div class="test" style="text-overflow:ellipsis;"><a class="blue" target="_blank" href="{{URL::to('/')}}/create_result?view=view&id={{ $sent_minute->mID }}">{{ $sent_minute->mTitle }}</a></div></td>
            @endif
                    <td class="silver span4">{{ $sent_minute->selected_date }}</td>
                    <td class="span2 lastcol"><a class="button_view" target="_blank" href= "{{URL::to('/')}}/create_result?view=view&id={{ $sent_minute->mID }}"><span class="tab-desk">View</span></a><a class="button_del deleteSent" href="{{ $sent_minute->mID }}"><span class="tab-desk">Delete</span></a></td>
          </tr>

          @elseif
          <tr>
            <td class="trtitle prefix_1"><a class="grayitlic" href="{{ URL::to('/').'/account/create' }}">Welcome. You have not created any meetings yet. Click here to get started.</a></td>
            <td class="silver">{{ date('Y-m-d H:i:s') }}</td>
            <td></td>
          </tr>
          @endif
          @endforeach
              </tbody>
            </table>
    </div>
    <div class="tab-pane" id="tab3">
      <table class="table">
              <thead>
                <tr>
                  <th class="span6 prefix_1">Meeting Title<span class="RTOrder icon_order" data-order="desc">&nbsp;</span></th>
                  <th class="span5">Date<span class="RDOrder icon_order" data-order="desc">&nbsp;</span></th>
                  <th class="span1 lastcol">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($recieved_minutes as $recieve_minute)
                @if($recieve_minute)
          <tr class="count">
          @if ($recieve_minute->mTitle == '')
              <td class="trtitle prefix_1 span6"><a class="blue" href="{{URL::to('/')}}/create_result?view=view&id={{$recieve_minute->mID}}">No Title Assigned Yet</a></td>
          @else
              <td class="trtitle prefix_1 span6"><a class="blue" href="{{URL::to('/')}}/create_result?view=view&id={{ $recieve_minute->mID }}">{{ $recieve_minute->mTitle }}</a></td>
          @endif
                  <td class="silver span5">{{ $recieve_minute->selected_date }}</td>
                  <td class="span1 lastcol"><a class="button_view" href="{{URL::to('/')}}/create_result?view=view&id={{ $recieve_minute->mID }}"><span class="mobile inline">View</span>View</a></td>
          </tr>
          @elseif
          <tr>
            <td class="trtitle prefix_1"><span class="grayitlic">Welcome! You have not received any meetings.</span></td>
            <td class="silver">{{ date('Y-m-d H:i:s') }}</td>
            <td></td>
          </tr>
          @endif
          @endforeach
              </tbody>
            </table>
    </div>
  </div>
</div>
</div>
@endsection



