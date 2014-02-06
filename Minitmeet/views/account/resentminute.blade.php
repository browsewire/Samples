<table class="table">
  <thead>
    <tr>
      <th class="prefix_1 span6">Meeting Title<span class="STOrder icon_order" >&nbsp;</span></th>
      <th class="span4">Date<span class="SDOrder icon_order" >&nbsp;</span></th>
      <th class="span2 lastcol">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($sent_minutes as $sent_minute){
		if($sent_minute){ ?>
    <tr class="count">
         <?php if ($sent_minute->mTitle == ''){?>
          <td class="trtitle prefix_1 span6"><div class="test" style="text-overflow:ellipsis;"><a class="blue" target="_blank" href="{{URL::to('/')}}/create_result?view=view&id={{ $sent_minute->mID }}">No Title Assigned Yet</a></div></td>
      <?php }else{?>
          <td class="trtitle prefix_1 span6"><div class="test" style="text-overflow:ellipsis;"><a class="blue" target="_blank" href="{{URL::to('/')}}/create_result?view=view&id={{ $sent_minute->mID }}">{{ $sent_minute->mTitle }}</a></div></td>
     
              <td class="silver span4">{{ $sent_minute->selected_date }}</td>
              <td class="span2 lastcol"><a class="button_view" target="_blank" href="{{URL::to('/')}}/create_result?view=view&id={{ $sent_minute->mID }}"><span class="tab-desk">View</span></a><a class="button_del deleteSent" href="{{ $sent_minute->mID }}"><span class="tab-desk">Delete</span></a></td>
    </tr>

   <?php }
   }else{?>
    <tr>
      <td class="trtitle prefix_1"><a class="grayitlic" href="{{ URL::to('/').'/account/create' }}">Welcome. You have not created any meetings yet. Click here to get started.</a></td>
      <td class="silver">{{ date('Y-m-d H:i:s') }}</td>
      <td></td>
    </tr>
   <?php }}?>
  </tbody>
</table>
