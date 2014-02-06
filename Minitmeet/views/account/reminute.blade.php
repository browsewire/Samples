<table class="table">
  <thead>
    <tr>
      <th class="prefix_1 span6">Meeting Title<span class="DTOrder icon_order" >&nbsp;</span></th>
      <th class="span4">Date<span class="DDOrder icon_order">&nbsp;</span></th>
      <th class="span2 lastcol">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($draft_minutes as $draft_minute){
		if($draft_minute){  ?>
		
    <tr class="count">
      <?php if ($draft_minute->mTitle == ''){ ?>
          <td class="trtitle prefix_1 span6"><div class="test" style="text-overflow:ellipsis;"><a class="blue" href="{{ URL::to('/') }}/account/edit?id={{ $draft_minute->mID }}">No Title Assigned Yet</a></div></td>
      
      <?php }else{?>
          <td class="trtitle prefix_1 span6"><div class="test" style="text-overflow:ellipsis;"><a class="blue" href="{{ URL::to('/') }}/account/edit?id={{ $draft_minute->mID }}">{{ $draft_minute->mTitle }}</a></div></td>
     
              <td class="silver span4">{{ $draft_minute->selected_date }}</td>
              <td class="span2 lastcol"><a href="{{ URL::to('/') }}/account/edit?id={{ $draft_minute->mID }}" class="button_edit"><span class="tab-desk">Edit</span></a><a class="button_del deleteDraft" href="{{ $draft_minute->mID }}"><span class="tab-desk">Delete</span></a></td>
    </tr>

  <?php }} else{?>
    <tr>
      <td class="trtitle prefix_1"><a class="grayitlic" href="{{ URL::to('/').'/account/create' }}">Welcome. You have not created any meetings yet. Click here to get started.</a></td>
      <td class="silver">{{ date('Y-m-d H:i:s') }}</td>
      <td></td>
    </tr>
    <?php }}?>
  </tbody>
</table>
