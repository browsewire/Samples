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
