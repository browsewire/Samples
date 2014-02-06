@extends('layout/account')
@section('title')
Tasks
@endsection
@section('topnav')
        <li>{{ HTML::linkAction('AccountController@index', 'OVERVIEW') }}</li>
        <li>{{ HTML::linkAction('AccountController@contacts', 'CONTACTS') }}</li>
        <li class="home">{{ HTML::linkAction('AccountController@tasks', 'TASKS') }}</li>
@endsection

@section('content')
<div class="tablet-hdr merge_bot clearfix">

<div class="title_dim"><h1>Tasks</h1></div>
  <div class="create_dim "><a class="plusbutton" href="{{ URL::to('/').'/account/create' }}">&nbsp;</a></div>
</div>
<div class="clear"></div>
<div class="sep2px desktop"></div>
<div class="setting-wraper taskspadding tablet-padding boxin margin_40">
<div class="tabbable"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Pending ( <span class="tab1Count"></span> )</a></li>
    <li><a href="#tab2" data-toggle="tab">Completed ( <span class="tab2Count"></span> )</a></li>
    <li><a href="#tab3" data-toggle="tab">My Task ( <span class="tab3Count"></span> )</a></li>
    <a href="#" class="add_task tab-desk">Assign New Task</a>
  </ul>
  <div class="tab-content hasTable taskTable">
    <div class="tab-pane active" id="tab1">
      <table class="table task">
              <thead>
                <tr>
                  <th class="ccol1">Task</th>
                  <th class="ccol2">Assigned To</th>
                  <th class="ccol3"><span class="actlastcol">Action</span></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tasks_pending as $pending)
                  @if($pending)
		          <tr class="count">
		          @if ($pending->description == '')
		              <td class="trtitle">No description Assigned Yet
                    <div id="{{ $pending->notes_id }}" class="hidden">
                      <p>Created By:</p>
                      <p>Created Time: {{ $pending->selected_date }} </p>
                      <p>Reminder Send: <span class="reminerCount">{{ $pending->reminder }}</span> </p>
                    </div>
                  </td>
		          @else
		              <td class="trtitle">{{ $pending->description }}
                    <div id="{{ $pending->notes_id }}" class="hidden">
                      <p>Created By: {{ Auth::user()->username }}</p>
                      <p>Created Time: {{ $pending->selected_date }} </p>
                      <p>Reminder Send: <span class="reminerCount">{{ $pending->reminder }}</span> </p>
                    </div>
                  </td>
		          @endif
		                  <td class="assigned_name">{{ $pending->cName }}</td>
		                  <td class="alignRight">
                        <div class="task_menu mobile">
                          <div class="task_submenu">
                            <a href="{{ $pending->notes_id }}" class="label viewdetail">Detail</a><a href="{{ $pending->notes_id }}#{{ $pending->reminder }}" class="label reminder">Reminder</a><a href="{{ $pending->notes_id }}" class="label markcomplete">Completed</a>
                          </div>
                        </div>
                        <span class="tab-desk"><a href="{{ $pending->notes_id }}" class="label viewdetail button_detail"><span class="mobile inline">Detail</span>&nbsp;</a> <span class="mobile inline-blck">|</span><a href="{{ $pending->notes_id }}#{{ $pending->reminder }}" class="label reminder button_rem"><span class="mobile inline">Reminder</span>&nbsp;</a><span class="mobile inline-blck">|</span> <a href="{{ $pending->notes_id }}" class="label markcomplete button_comp"><span class="mobile inline">Completed</span>&nbsp;</a></span> 
                      </td>
		                </tr>
		          @elseif
		          <tr>
		            <td class="trtitle"><span class="grayitlic">There are no Pending Tasks Right Now</span></td>
                <td></td>
                <td></td>
		          </tr>
		          @endif
		          @endforeach
              </tbody>
            </table>
    </div>
    <div class="tab-pane" id="tab2">
      <table class="table task">
              <thead>
                <tr>
                  <th class="span6">Task</th>
                  <th class="span3">Assigned To</th>
                  <th class="span4 lastcol 3butth"><span class="actlastcol">Action</span></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tasks_completed as $completed)
                @if($completed)
              <tr class="count">
              @if ($completed->description == '')
                  <td class="trtitle span6">No description Assigned Yet
                    <div id="{{ $completed->notes_id }}" class="hidden">
                      <p>Created By:</p>
                      <p>Created Time: {{ $completed->selected_date }} </p>
                      <p>Reminder Send: <span class="reminerCount">{{ $completed->reminder }}</span> </p>
                    </div>
                  </td>
              @else
                  <td class="trtitle span6">{{ $completed->description }}
                    <div id="{{ $completed->notes_id }}" class="hidden">
                      <p>Created By: {{ Auth::user()->username }}</p>
                      <p>Created Time: {{ $completed->selected_date }} </p>
                      <p>Reminder Send: <span class="reminerCount">{{ $completed->reminder }}</span> </p>
                    </div>
                  </td>
              @endif
                      <td class="assigned_name span3">{{ $completed->cName }}</td>
                      <td class="span4 lastcol 3buttd">
                        <div class="task_menu mobile">
                          <div class="task_submenu">
                            <a href="{{ $completed->notes_id }}" class="label viewdetail">Detail</a><a href="{{ $completed->notes_id }}" class="label reopentask">Reopen</a>
                          </div>
                        </div>
                        <span class="tab-desk"><a href="{{ $completed->notes_id }}" class="label viewdetail button_detail"><span class="mobile inline">Detail</span>&nbsp;</a> <span class="mobile inline-blck">|</span><a href="{{ $completed->notes_id }}" class="label reopentask button_open"><span class="mobile inline">Reopen</span>&nbsp;</a></span> 
                      </td>
                    </tr>
              @elseif
              <tr>
                <td class="trtitle"><span class="grayitlic">There are no Completed Tasks Right Now</span></td>
                <td></td>
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
                  <th class="span6">Task</th>
                  <th class="span4">Assigned To</th>
                  <th class="span2 lastcol">Action</th>
                </tr>
              </thead>
              <tbody>
         		 @foreach ($my_tasks as $mytask)
         		 @if($mytask)
		          <tr class="count">
		          @if ($mytask->description == '')
		              <td class="trtitle span6">No description were Assigned for This task
                    <div id="{{ $mytask->notes_id }}" class="hidden">
                      <p>Created By: {{ $mytask->username }}</p>
                      <p>Created Time: {{ $mytask->selected_date }}</p>
                      <p>Reminder Send: <span class="reminerCount">{{ $mytask->reminder }}</span> </p>
                    </div>
                  </td>
		          @else
		              <td class="trtitle span6">{{ $mytask->description }}
                    <div id="{{ $mytask->notes_id }}" class="hidden">
                      <p>Created By: {{ $mytask->username }}</p>
                      <p>Created Time: {{ $mytask->selected_date }}</p>
                      <p>Reminder Send: <span class="reminerCount">{{ $mytask->reminder }}</span> </p>
                    </div>

                  </td>
		          @endif
		                  <td class="span4">{{ $mytask->cName }}</td>
		                  <td class="span2 lastcol"><a href="{{ $mytask->notes_id }}" class="label viewmydetail button_detail2"><span class="mobile inline">Detail</span>&nbsp;</a><span class="mobile inline-blck">|</span><a href="{{ $mytask->notes_id }}" class="label mycomplete button_comp"><span class="mobile inline">Completed</span>&nbsp;</a> </td>
		                </tr>
		          @elseif
		          <tr>
		            <td class="trtitle"><span class="grayitlic">There are no Tasks For you Right Now</span></td>
                <td></td>
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
