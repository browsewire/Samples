          <div id="plus"><div class="plus_container">
              <div><div class="close_contact mobile">x</div>
              
              </div>
            <?php foreach ($contacts as $contact){
				 
				 if($contact){
				  ?>
             
              <div class="list"><a href="{{ $contact->contactsID }}" class="addAttendee">{{ $contact->cName }}</a></div>
              <?php }else{

		}}?>
          </div></div>
          
          <div id="minus"><div class="minus_container">
         <?php foreach ($attendees as $contact){
				 
				 if($contact){
				  ?>
             
              <div class="list"><a href="{{ $contact->contactsID }}" class="removeAttendee">{{ $contact->cName }}</a></div>
            <?php }else{

		}}?>

          
          </div></div>
