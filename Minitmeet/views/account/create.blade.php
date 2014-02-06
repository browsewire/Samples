@extends('layout/account')

@section('title')
Create New Meeting
@endsection

@section('topnav')
        <li>{{ HTML::linkAction('AccountController@index', 'OVERVIEW') }}</li>
        <li>{{ HTML::linkAction('AccountController@contacts', 'CONTACTS') }}</li>
        <li>{{ HTML::linkAction('AccountController@tasks', 'TASKS') }}</li>
@endsection

@section('content')
  <div class="create_title create dynamicTitle">
    <strong>Create New Meeting</strong> 
    <div class="indicator clearfix">
      <div class="ag green"><a href="#">Agenda</a></div>
      <div class="mobile lt">></div>
      <div class="at"><a href="#">Attendees</a></div>
      <div class="mobile lt">></div>
      <div class="ad"><a href="#">add minutes</a></div>
    </div>
  </div>
  <div class="create_divider tab-desk"></div>
  <div class="clear"></div>

<div class="mobBoxin">
  <div class="mobile titleDate_banner"><div>&nbsp;</div></div>
  <div class="create_timeTitle clearfix">
    <div class="stretch title_div"><input type="text" name="meetingtitle" placeholder="Type Meeting Title."></div>
    <div id="datetimepicker2" class="input-append date_div">
      <div id="create-input-small"><input name="meetingDate" class="datetimepicker" value="{{ date('m-d-Y H:i') }}"/></div>
    </div>
  </div><!-- .create_timeTitle -->
  <div class="clear"></div>
  <div class="create_manualAdd hidden">
    <div class="atbadge tab-desk">&nbsp;</div>
    {{ Form::open(array('url'=>'account/create','method'=> 'POST','class' => 'addContacts')) }}
    <div class="grid_11 nameField"><div class="name_wrapper_label tab-desk">Attendee Name:</div> <input type="text" name="name" placeholder="Name"></div>
    <div class="clear tab-desk"></div>
    <div class="grid_11 emailField"><div class="email_wrapper_label tab-desk">Attendee Email:</div><input type="email" name="email" placeholder="Email"></div>
    <div class="addAttendeegrid"><button id="addAttendee" typ="submit" name="addAttendee" class="plus_button">&nbsp;</button></div>
    <div class="clear mobile"></div>
    {{ Form::close() }}
    <div class="manual_direction tab-desk">Manually type attendee name and email above or select from your contact list</div>
  </div><!-- .create_manualAdd -->
  <div class="clear"></div>
    <div class="create_infoTitle hidden clearfix">
    <div class="infoTitle">Title Here</div>
    <div class="infoTime">Meeting Occured at  <span class="atdate"></span><span class="attime"></span></div>
  </div><!-- .create_infoTitle -->
  <dic class="clear"></dic>
  <div class="create_subWrapper">
  <div class="tabbable create_TabsDiv1">
    <ul class="nav nav-tabs hidden">
      <li><a  id="attendeeTab" href="#tab2" data-toggle="tab">Attendees</a></li>
      <li class="active"><a id="agendaTab" href="#tab1" data-toggle="tab">Agenda</a></li>
      <li><a id="minuteTab" href="#tab3" data-toggle="tab">Minutes</a></li>
    </ul>
    <div class="tab-content create_tabContent">
      <div class="tab-pane active clearfix" id="tab1">
        
        <div class="mobile draft_banner"><div>&nbsp;</div></div>
        <div class="preview_section tab-desk">
          <div class="preview"><a class="button_preview" href="JavaScript:newPopup('<?php echo URL::to('/'); ?>/create_result?view=view&id=<?php echo $_SESSION['draft'];?>');">&nbsp;</a></div> 
        </div>
        <div class="clearfix">
          <div class="row-fluid">
            <div class="create_agendatemplate">
              <span class="bigfont">Draft Meeting Agenda or <span class="brown">Load Template</span>.</span>
            </div>
            <div class="stretch agenda_div hidden">
              <textarea name="agenda" rows="10" cols="50" style="opacity:0;width:5px;"><span class="bigfont">Draft Meeting Agenda or <span class="brown">Load Template</span>.</span></textarea>
            </div>
          </div>
        </div><!--tab2_innerleft-->
      </div>
      <div class="tab-pane clearfix" id="tab2">
        <div class="preview_section tab-desk">
          <div class="preview"><a class="button_preview" href="JavaScript:newPopup('<?php echo URL::to('/'); ?>/create_result?view=view&id=<?php echo $_SESSION['draft'];?>');">&nbsp;</a></div> 
        </div>
        <div class="att_rightside">
          <div id="ase">

          </div>
        </div><!--tab2_innerleft-->
      </div>
      <div class="tab-pane clearfix" id="tab3">
        <div class="titleDate_banner2 forMinute mobile"><div>&nbsp;</div></div>
        <div class="preview_section tab-desk">
          <div class="preview"><a class="button_preview" href="JavaScript:newPopup('<?php echo URL::to('/'); ?>/create_result?view=view&id=<?php echo $_SESSION['draft'];?>');">&nbsp;</a></div> 
        </div>
        <div class="att_rightside clearfix">
          <div class="minits_div stretch">
          <div class="clear mobile"></div>
            <textarea name="notesArea" rows="10" cols="50"></textarea>
          </div>
          <div class="clear"></div>
          <?php $attendee_array = array(0 =>'Unassigned') ?>
          <div class="ActionBoxOverlay hidden">
            <div class="closeActionBox"></div>
            <div class="actionFields">
              {{Form::select('actionFor', $attendee_array)}}
              <button class="assignedaction">&nbsp;</button>
            </div>
          </div>
          <div class="clear"></div>
          <div class="edit_div" style="display:none;z-index:99999;position:relative;">
          <h1>Edit Notes</h1>
            <div class="minits_div stretch">
              <textarea name="update_notesArea" rows="10" cols="50"><span class="bigfont">Draft Meeting Agenda or <span class="brown">Load Template</span>.</span></textarea>
              <div class="clear"></div>
              <div class="update_footer">
                <a class="close_editDiv"> Close </a> <a class="updatenote"> Update </a>
              </div>
            </div>
          </div>
        </div><!--tab2_innerleft-->
      </div>
    </div>
  </div>
<!--     <div class="createseplight"></div> -->
  <div class="clear"></div>
<div class="clearfix bot_box hidden">
<!-- <div class="grid_3 preview"><a class="button_preview" href="JavaScript:newPopup('<?php echo URL::to('/'); ?>/create_result?view=view&id=<?php echo $_SESSION['draft'];?>');">Preview</a></div> -->
  <div id="autosave" class="grid_6 tab-desk">Draft Auto Save: <span id="clock">saving in 10s CDT</span> <div class="preview tablet"><a class="button_preview" href="JavaScript:newPopup('<?php echo URL::to('/'); ?>/create_result?view=view&id=<?php echo $_SESSION['draft'];?>');">&nbsp;</a></div> </div>
  <div class="clear mobile"></div>
  <div class="preview mobile clearfix">
    {{ HTML::image('img/mobPreviewShow.jpg', 'Preview Thumb') }}
    <div>
      <p>Preview your agenda by clicking the link below</p>
      <a class="button_preview" href="JavaScript:newPopup('<?php echo URL::to('/'); ?>/create_result?view=view&id=<?php echo $_SESSION['draft'];?>');">Preview PDF</a>
    </div>
  </div>
  <div class="mobile clockLine">Draft Auto Save: <span id="clockMob">saving in 10s CDT</span></div>
  <div class="buttonPack clearfix">
    <button class="button_continue">&nbsp;</button>
    <button id="submitAgenda" class="button_sendAgenda agenda hidden">&nbsp;</button>
    <button class="button_back backtostep1 hidden">&nbsp;</button>
    <button class="button_makeActionItem hidden">&nbsp;</button>
    <button id="addminute" class="button_note hidden">&nbsp;</button>
    
  </div><!--bp-->
</div>
</div>

<div class="clear"></div>
<div class='minutesbox create_subWrapper clearfix hidden'>
  <div class="leftPanel">
    <div class="panel2">&nbsp;</div>
    <div class="panel3 hidden">&nbsp;</div>
  </div>
  <div id="notesWrapper" class="clearfix">

  </div>
  <div class="botsendagenda"><button id="confirmNote" class="button_confirmNote">&nbsp;</button></div> 
</div>
   <div id="confirmSendM" class="hidden">
    <div class="cHeading"><h1>Confirm Sending Meeting Minutes</h1></div>
    <div class="closeConfirmSendM close_icon">&nbsp;</div>
    <div class="wrapperSM">
      <div class="msgSM">
        <p>You are about to send meeting minutes to <div id="nameHere">&nbsp;</div>Do you wish to proceed?</p>
      </div>
      <button class='closeConfirmSendM button_closeConfirm'>&nbsp;</button>
      <form action ="{{ URL::to('/') }}/create_result" method="GET" style="display:inline;">
    <input type="hidden" name="id" value="{{ $_SESSION['draft'] }}">
    <input type="hidden" name="sendnote" value="sent">
     <button id="submitNote" type="submit" >&nbsp;</button>
    </form>
   </div>
 </div>




</div>
</div>
         
@endsection

@section('phpFunctions')
<script type="text/javascript">

var int=self.setInterval(function(){clock()},10000);
function clock()
{
  var d=new Date();
  var t=d.toLocaleTimeString();
  jQuery('#clock').html(t); 
  jQuery('#clockMob').html(t);
  jQuery.post('{{URL::to('/account/autosave')}}', {
        title: jQuery('input[name="meetingtitle"]').val(),
        agenda:tinyMCE.get('agenda').getContent(),
        time: jQuery('#datetimepicker2 input').val(),
        id: {{ $_SESSION['draft'] }}
    }, function(data) {
  });
}
</script>
<script type="text/javascript">

(function(){
  jQuery('.bgsilver.clearfix.bgnsilver').hide();
  jQuery( 'input[name="action"]' ).on( "click", function(){
    if(jQuery(this).is(":checked")){
      jQuery('select[name="actionFor"]').removeAttr('disabled');
    }else{
      jQuery('select[name="actionFor"]').attr('disabled', 'disabled');
    }
  });
  jQuery('#minuteTab').click(function(){
    jQuery('.create_header').removeClass('mob-hide').addClass('mob-show');
  });
  jQuery('#agendaTab').click(function(){
    jQuery('.create_header').removeClass('mob-show').addClass('mob-hide');;
  });
  jQuery('#attendeeTab').click(function(){
    jQuery('.create_header').removeClass('mob-show').addClass('mob-hide');;
  });
  jQuery('.fetch_contact').click(function(e){
    e.preventDefault();
    jQuery('.addcontact-overlay').show();
    jQuery('#plus').show();
    jQuery('.close_contact').click(function(){
      jQuery('.addcontact-overlay').hide();
      jQuery('#plus').hide();
    });
  });
  jQuery('.fetch_notes').click(function(){
    jQuery('.addcontact-overlay').show();
    console.log("asd");
    jQuery('#notesWrapper').show();
    jQuery('.close_note').click(function(){
      jQuery('.addcontact-overlay').hide();
      jQuery('#notesWrapper').hide();
    });    
  });
  jQuery('.create_tabContent').hide();
  jQuery('input[name="meetingtitle"]').focus(function() {
     jQuery('.create_tabContent').slideDown();
  });
  jQuery('.create_agendatemplate').click(function(){
    jQuery('.create_tabContent #tab1').height(395);
    jQuery(this).hide().next().slideDown();
    jQuery('.bot_box').show();
  });

  function bindButContinue(){
    jQuery('.button_continue').hide().next().show().next().show();
    jQuery('.create_tabContent #tab1').removeClass('active');
    jQuery('.create_tabContent #tab2').addClass('active');
    jQuery('.create_tabContent #tab3').removeClass("active");
    jQuery('.indicator .ag').removeClass('green');
    jQuery('.indicator .at').addClass('green');
    jQuery('.create_timeTitle').hide();
    jQuery('.create_manualAdd').show();
    jQuery('.titleDate_banner').show();
    jQuery('.create_subWrapper').addClass("forAttendee");
    jQuery('.titleDate_banner div').addClass('forAttend');
    jQuery('.indicator .ag a').click(function(e){
      e.preventDefault();
      backButtonEvent();
      jQuery('.indicator .ad a').unbind("click");
    });
    jQuery('.indicator .ad a').click(function(e){
      e.preventDefault();
      jQuery("#submitAgenda").hide().next().hide().next().next().show();
      jQuery('.create_tabContent #tab2').removeClass('active');
      jQuery('.create_tabContent #tab3').addClass('active');
      jQuery('.indicator .at').removeClass('green');
      jQuery('.indicator .ad').addClass('green');
      jQuery('.create_subWrapper').removeClass("forAttendee");
      jQuery('.titleDate_banner').hide();
      jQuery('.titleDate_banner2').show();
      jQuery('.create_manualAdd').hide();
      jQuery('.create_infoTitle').show();
      jQuery('.create_infoTitle').show();
      jQuery('.infoTitle').text(jQuery('input[name="meetingtitle"]').val());
      jQuery('.infoTime span.attime').text(jQuery('input[name="meetingDate"]').val());
      jQuery('.indicator .ag a').unbind("click");
    });
  }
  jQuery('.button_continue').click(function(){bindButContinue();});
  jQuery('.indicator .at a').click(function(e){ 
    e.preventDefault();
    bindButContinue();
    jQuery('.create_tabContent').show();
    jQuery('.bot_box').show();
    jQuery('.indicator .ad').removeClass('green');
    jQuery('.indicator .ad').removeClass('green');
    jQuery('#addminute').hide();
    jQuery('.button_makeActionItem').hide();
    jQuery('.minutesbox').hide();
    jQuery('.titleDate_banner div').removeClass('forMinute');
    jQuery('.titleDate_banner div').addClass('forAttend');
    jQuery('.create_infoTitle').hide();
  });

  function backButtonEvent(){
    jQuery('.backtostep1').hide().prev().hide().prev().show();
    jQuery('.create_tabContent #tab2').removeClass('active');
    jQuery('.create_tabContent #tab1').addClass('active');
    jQuery('.indicator .ag').addClass('green');
    jQuery('.indicator .at').removeClass('green');
    jQuery('.create_timeTitle').show();
    jQuery('.create_manualAdd').hide();
    jQuery('.create_subWrapper').removeClass("forAttendee");
    jQuery('.titleDate_banner div').removeClass('forAttend');
  }
  jQuery('.backtostep1').click(function(){
    backButtonEvent();
  });
var BASE= '';
  jQuery('#submitAgenda').click(function(e){
    e.preventDefault();
    jQuery.get('{{URL::to('/create_result')}}', {
          id: "{{ $_SESSION['draft'] }}",
          agenda:true
      }, function(data) {
    });
    jQuery(this).hide().next().hide().next().next().show();
    jQuery('.create_tabContent #tab2').removeClass('active');
    jQuery('.create_tabContent #tab3').addClass('active');
    jQuery('.indicator .at').removeClass('green');
    jQuery('.indicator .ad').addClass('green');
    jQuery('.create_subWrapper').removeClass("forAttendee");
    jQuery('.titleDate_banner').hide();
    jQuery('.titleDate_banner2').show();
    jQuery('.create_manualAdd').hide();
    jQuery('.create_infoTitle').show();
    jQuery('.create_infoTitle').show();
    jQuery('.infoTitle').text(jQuery('input[name="meetingtitle"]').val());
    jQuery('.infoTime span.attime').text(jQuery('input[name="meetingDate"]').val());
    jQuery('.indicator .ag a').unbind("click");
  });

  jQuery('.button_makeActionItem').click(function(e){
    e.preventDefault();
    jQuery.get('{{URL::to('/account/minute') }}', function(data) {
      jQuery('select[name="actionFor"]').html(data);
    });
    jQuery('.closeActionBox').click(function(e){
      e.preventDefault();
      jQuery('.pwd_display').hide();
      jQuery('.ActionBoxOverlay').hide();
    });
    jQuery('.pwd_display').show();
    jQuery('.ActionBoxOverlay').show();
  });
  function addPanelClick(){
        jQuery('.panel2').click(function(){
        jQuery('.panel2').removeClass('g');
        jQuery('.panel3').addClass('g');
        jQuery('.leftPanel').removeClass('switch');
        jQuery('.action_container').hide();
        jQuery('.note_container').show();
      });
      jQuery('.panel3').click(function(){
        jQuery('.panel3').removeClass('g');
        jQuery('.panel2').addClass('g');
        jQuery('.leftPanel').addClass('switch');
        jQuery('.note_container').hide();
        jQuery('.action_container').show();
      });
  }
    jQuery('.assignedaction').click(function(e){
      e.preventDefault();
      addPanelClick();
      jQuery('.panel3').show();
      jQuery('.pwd_display').hide();
      jQuery('.ActionBoxOverlay').hide();
      jQuery('.button_makeActionItem').data("userid",jQuery('select[name="actionFor"]').val());
      var grabid = jQuery(".ul_note.note li:eq(0)").data("value");
      var useriD = jQuery('.button_makeActionItem').data("userid");
      if(grabid !== "" && useriD !== ''){
        jQuery.post('{{URL::to('/account/create')}}',{mode:"toaction",id: grabid,type: useriD},function(data) {
            jQuery.renotes(panSwitch= "rev");
        });
      }
    });	

  jQuery("#confirmNote").click(function(){
    var a = jQuery('#nameHere').html(jQuery('.minus_container').html());
    jQuery(".pwd_display").show();
    jQuery("#confirmSendM").show();
    jQuery(".closeConfirmSendM").click(function(){
      jQuery(".pwd_display").hide();
      jQuery("#confirmSendM").hide();
    });

  });
})();
editPage({{$_SESSION['draft']}});
</script>

@endsection
