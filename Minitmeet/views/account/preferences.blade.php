@extends('layout/account')

@section('title')
Settings
@endsection
@section('css')
<style>
.set a {
    font-size: 15px;
}


</style>
@endsection
@section('topnav')

        <li>{{ HTML::linkAction('AccountController@index', 'OVERVIEW') }}</li>
        <li>{{ HTML::linkAction('AccountController@contacts', 'CONTACTS') }}</li>
        <li>{{ HTML::linkAction('AccountController@tasks', 'TASKS') }}</li>
@endsection

@section('content')
<div class="tablet-hdr merge_bot clearfix">
      <ul class="set" style=" float: right;">
         <li style="border-right: 1px solid gray;float: left;padding-right: 8px;">{{ HTML::linkAction('AccountController@preferences', 'PDF-SETTING') }}</li>
         <li style="float: left;margin-left: 13px;padding-right: 1px;" >{{ HTML::linkAction('UserController@get_setting', 'ACCOUNT') }}</li>
        
      </ul>
<div class="title_dim"><h1> PDF Settings</h1></div>
</div>
<div class="setting-wraper tablet-padding">
<div class="grid_540 title darkgray tab-desk"><strong>Change Password</strong></div>
<div class="grid_540 title darkgray tab-desk"><strong>PDF Custom logo</strong></div>
<div class="clear mobile"></div>
<div class="mobile pre-title">Change Password</div>
<div class="grid_540 bggray paddingtb_20 brsilver_topwhite minheigth_145">  
  <div class="err alert alert-error hidden">
    Enter a valid password. (min. 4 characters)
  </div>
  <div class="succ alert alert-success hidden">
    Successfully Changed your Password.
  </div>

  <div class="grid_4 pwd_label">Password</div>
  <div class="grid_6"><input type="password" name="firstpwd" class="inputstyle width_325"></div>  
  <div class="clear"></div>
  <div class="grid_4 pwd_label">Confirm Password</div>
  <div class="grid_6"><input type="password" name="secondpwd" class="inputstyle width_325"></div>
  <div class="clear"></div>
  <div class="grid_4 pwd_label"></div>
  <div class="grid_3"><a class="button_medium btn_update changepwd" href="#">UPDATE</a> </div>
</div><!--.grid_12-->
<div class="clear mobile"></div>
<div class="mobile pre-title">PDF Custom logo</div>
  <div  class="grid_540 bggray brsilver_topwhite paddingtb_20 minheigth_145">
<div class="imgholder">
  <img src="{{ Auth::user()->logo."?".date('Y-m-d H:i:s') }}" style="width:90%;max-height: 135px;margin-top:15px;margin-left: 5px;">
</div> 
{{Form::open(array('url'=>'account/preferences','method'=>'post','id'=>'myform','class'=>'grid_3','files'=>true))}}
<input class="upload_button medium_button" value="CHOOSE FILE">
<input type="file" class="opacity" id="field" name="photo" accept="image/*">
<div class="silver size14 italic filename">None Selected</div>

<br>
<input type="submit" value="UPLOAD LOGO" class="submit_upload medium_button">
<span class="silver size14 italic">JPG, GIF or PNG</span>
{{ Form::close() }}
<br>
</div>
<div class="clear"></div>
<div class="grid_540 botborder tab-desk"></div>
<div class="grid_540 botborder tab-desk"></div>
<div class="clear"></div>
<div class="grid_24" style="margin-top:20px;"></div>
<!--   <h1>PDF Color Scheme</h1> -->
  <div id="xam" class="grid_20 hidden" style="background-color:rgb({{ Auth::user()->bgcolor }});color:rgb({{ Auth::user()->fontcolor }});">Meeting Title</div>
<div class="clear"></div>
<div class="grid_540 title darkgray tab-desk"><strong>Select PDF Meeting Title Background Color</strong></div>
<div class="grid_540 title darkgray tab-desk"><strong>Select PDF Font Color</strong></div>
<div class="clear mobile"></div>
  <div class="mobile pre-title">Select PDF Meeting Title Background Color</div>  
<div class="grid_540 bggray paddingtb_20 brsilver_topwhite">
  <div class="bgerr alert alert-error hidden">
    Some Problem occur Please try again
  </div>
  <div class="bgsucc alert alert-success hidden">
    Successfully Changed Background color.
  </div>
  <div id="colorpickerHolder" class="grid_7"></div>
  <div class="italic silver infobg grid_2">Select color to the
left and preview or
submit it to customize
your PDF.</div>
  <button class="button_medium btn_update setbg">UPDATE</button>
</div><!--.grid_10-->
<div class="clear mobile"></div>
    <div class="mobile pre-title">Select PDF Font Color </div>
  <div  class="grid_540 bggray paddingtb_20 brsilver_topwhite">
  <div class="fnerr alert alert-error hidden">
    Some Problem occur Please try again
  </div>
  <div class="fnsucc alert alert-success hidden">
    Successfully Changed Font color.
  </div>
    <div id="fontcolor" class="grid_7"></div>
    <div class="italic silver infobg grid_2">Select color to the
left and preview or
submit it to customize
your PDF.</div>
  <button class="button_medium btn_update setfnt">UPDATE</button>
</div><!--.grid_10-->
<div class="clear"></div>
<div class="grid_540 botborder tab-desk"></div>
<div class="grid_540 botborder tab-desk"></div>
<div class="clear"></div>
<div class="mobile extra"></div>
<!--   <div class="grid_10">
    <h4>Choose Background Color</h4>
  <div id="colorpickerHolder"></div>
  <br>
  <button class="btn btn-warning setbg">Update Background Color</button>
  </div>
  <div class="grid_10">
    <h4>Choose Font Color</h4>
  <div id="fontcolor"></div>
  <button class="btn btn-warning setfnt">Update Font Color</button>

  </div> -->
</div>
@endsection

@section('phpFunctions')
<script type="text/javascript">
 jQuery('#colorpickerHolder').ColorPicker({
  flat: true,
  onChange: function (hsb, hex, rgb) {
    console.log(rgb.r);
    jQuery('#xam').css('backgroundColor', '#' + hex);
  }

 });
  jQuery('#fontcolor').ColorPicker({
  flat: true,
  onChange: function (hsb, hex, rgb) {
    console.log(rgb.r);
    jQuery('#xam').css('color', '#' + hex);
  }

 });
 </script>
 <script src="http://jquery.bassistance.de/validate/jquery.validate.js"></script>
<script src="http://jquery.bassistance.de/validate/additional-methods.js"></script>
<script>
// just for the demos, avoids form submit

jQuery( "#myform" ).validate({
  rules: {
    photo: {
      required: true,
      accept: "image/*"
    }
  }
});
</script>
<script type="text/javascript">
(function() {
  jQuery('.setbg').click(function(){
    var bg1 = jQuery('#xam').css("background-color");
    var bg2 = bg1.replace('rgb(', '');
    var bg = bg2.replace(')', '');
    jQuery.post('{{URL::to('/account/preferences')}}', {
                    bgcolor: bg,
                    mode: "bg"
              }, function(data) {
                console.log(data);
                  });
          });
})();
(function() {
  jQuery('.setfnt').click(function(){
    var bg1 = jQuery('#xam').css("color");
    var bg2 = bg1.replace('rgb(', '');
    var bg = bg2.replace(')', '');
    jQuery.post('{{URL::to('/account/preferences')}}', {
                    fncolor: bg,
                    mode: "fn"
              }, function(data) {
                console.log(data);
                  });
          });
})();
(function() {
  jQuery('.changepwd').click(function(){
    var pwd1 = jQuery('input[name="firstpwd"]').val();
    var pwd2 = jQuery('input[name="secondpwd"]').val();
      if(pwd1 === pwd2 && pwd1 !=='' && pwd1.length >= 4){
        jQuery.post('{{URL::to('/account/preferences')}}', {
                        password: pwd1,
                        mode: "pwd"
                  }, function(data) {
                    jQuery('.succ').fadeIn(function(){jQuery('.succ').delay(2000).fadeOut();});
                      }
        );
      }else{
        jQuery('.err').fadeIn(function(){jQuery('.err').delay(2000).fadeOut();});
      }
  });

  jQuery('#field').change(function(){
    var filename = jQuery('#field').val();
    if(filename !== ''){
      jQuery('.filename').html(filename.split('\\').pop());
    }else{
      jQuery('.filename').html("None Selected");
    }
  });
})();
</script>
@endsection
