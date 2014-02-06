<option value="0">Unassigned</option>
@foreach ($attendees as $contact)
@if($contact)
  <option value="{{ $contact->contactsID }}">{{ $contact->cName }}</option>
@endif

@endforeach
