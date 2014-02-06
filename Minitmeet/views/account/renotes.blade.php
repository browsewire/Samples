<div class="note_container">
		<!-- <h2 class="notetitle">Meeting Minutes:</h2><div class="close_contact close_note mobile">x</div> -->
        <ul class="ul_note note">
		    @foreach ($notes_meeting as $notes)
		      @if($notes) 
		        @if($notes->type=='-1')
		        	<li data-value="{{ $notes->notes_id }}">{{ $notes->description }}</li>
		        @endif
		    @elseif
		    	<li class="grayitlic"><span classs="grayitlic">No minutes. Add them in the text area above and click the “Add to Minutes” button.</span></li>
			@endif
			@endforeach 
        </ul>
        <div class="clear"></div>
		<div class="note_footer">
			<a class="label label-warning toaction">Move To Action Items</a> <a class="label editnote">Edit</a> <a class="delnote">Delete</a>
		</div>
</div><!--.note_container-->
<div class="action_container hidden">
	<!-- <h2 class="itemtitle">Action Items:</h2> -->
	<ul class="ul_item items">
	    @foreach ($notes_meeting as $notes)
	    @if($notes)
	        @if($notes->type != '-1')
	        <li data-value="{{ $notes->notes_id }}">{{ $notes->description }}
	        	<?php 
	        		$actionTO = DB::table('contacts')->where('contactsID', '=' , $notes->type)->first();
	        	?>
	        </li>
	        	@if($actionTO)
	        		<div class="garyLabelAssigned">Assigned To: <span>{{ $actionTO->cName }}</span></div>
	        	@endif
	        @endif
	    @elseif
			<li id="actionItems" class="grayitlic"><span class="grayitlic">No action items. Add them by drafting minutes above and checking the action item box before submitting.</span></li>
		
		 @endif
		@endforeach 
	</ul>
	<div class="item_footer">
		<a class="tonotes"> Move to Meeting Minutes </a> <a class="edititem"> Edit </a> <a class="delnote"> Delete </a>
	</div>
</div><!--.action_container-->
