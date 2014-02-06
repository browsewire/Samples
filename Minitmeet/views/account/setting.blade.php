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
         <li style = "border-right: 1px solid gray;float: left;padding-right: 8px;">{{ HTML::linkAction('AccountController@preferences', 'PDF-SETTING') }}</li>
         <li style = "float: left;margin-left: 13px;padding-right: 1px;" >{{ HTML::linkAction('UserController@get_setting', 'ACCOUNT') }}</li>
        
      </ul>
<div class="title_dim"><h1>Account Settings</h1></div>
</div>

<div style="background-color: rgb(221, 221, 221); margin-bottom: -8px; overflow: hidden; padding-bottom: 7px; width: 13%; text-align: center;"><h2>Contact Info</h2></div>
@if($info)
<div class="setting-wraper tablet-padding">
<table class="table task">
              <thead>
                <tr>
                  <th class="">Name</th>
                  <th class="">Email</th>
                   <th class="">Address</th>
                  <th class=""><span class="actlastcol">Action</span></th>
                </tr>
              </thead>
              <tbody>
		          <tr class="count">
		              <td class="trtitle">{{$info->first_name}} {{$info->last_name}} </td>
		          <td class="trtitle"> {{$info->email}}     </td>
		              <td class="trtitle">{{$info->address}} ,{{$info->zipcode}},{{$info->city}},{{$info->state}},{{$info->country}} </td>
                 <td class="" style="text-align:center;"> <a href="{{URL::to('/account/edit')}}/{{$info->id}}">Edit</a></td>
		        </tr>
		    @endif
              </tbody>
            </table>
  
@foreach($payinfo as $value)
 @if($value) 
 <?php  //print_r($value); die();
 $time= $value->created;
 $timestamp = strtotime($time);
 $date = date('d-m-Y', $timestamp);
 $newdate = date("d-m-Y", strtotime($date ." +1 month") );
 $price= DB::table('transaction_list')->where('transaction_id',$value->transaction_id)->get(array('amount'));
  ?>
 <div style="background-color: rgb(221, 221, 221); margin-bottom: -8px; overflow: hidden; padding-bottom: 7px; width: 13%; text-align: center;"><h2>Payment Info</h2></div>
<div class="setting-wraper tablet-padding">
<table class="table task">
              <thead>
                <tr>
                  <th class="">Transaction ID</th>                
                   <th class="">Address</th>
                     <th class="">Transaction Medium</th>
                       <th class="">Amount Payed</th>
                      <th class="">Payed On</th>
                 <th class="">Expirey Date</th>
                    <!--  <th class=""><span class="actlastcol">Action</span></th> -->
                </tr>
              </thead>
              <tbody>
		          <tr class="count">
		              <td class="trtitle">{{$value->transaction_id}}</td>		       
		              <td class="trtitle">{{$value->address}} ,{{$value->zipcode}},{{$value->city}},{{$value->state}},{{$value->country}} </td>
		               <td class="trtitle" style="text-transform: capitalize;"> {{$value->txn_type}}    </td>
		               <td class="trtitle">${{ $price[0]->amount}}   </td>
		               <td class="trtitle"><?php echo $date;?>    </td>
		                 <td class="trtitle"><?php echo $newdate;?>    </td>
              <!--   <td class="" style="text-align:center;"> <a href="{{URL::to('/account/edit')}}/{{$info->id}}">Edit</a></td> -->
		        </tr>
		    @endif
		    @endforeach
              </tbody>
            </table>



</div>
@endsection
