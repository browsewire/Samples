@foreach ($attendees as $contact)
@if($contact)
 {{ $contact->contactsID }} ,
@elseif
@endif
@endforeach
