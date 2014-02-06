@extends('layout/account')

@section('title')
Settings
@endsection
@section('css')
<style>
.set a {
    font-size: 15px;
}
.grid_6{
	 border: 1px solid gray;
    border-radius: 6px 6px 6px 6px;
    margin-bottom: 5px;
    padding-bottom: 5px;
    width: 230px;
    background-color: #DDDDDD;
}
select {
    -moz-appearance: none;
    background: none repeat scroll 0 0 transparent;
    border: medium none;
    cursor: pointer;
    font-size: 16px;
    height: 30px;
    padding-left: 10px;
    width: 229px!important;
    margin-left: 0 !important;
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

<div><h2>Contact Info</h2></div>
@if($info)
<div class="setting-wraper tablet-padding">
<table class="table task">
               <form class="signup clearfix" method="POST" action="{{URL::to('/account/edit')}}/{{$info->id}}">
    <!-- check for login errors flash var -->
    <!-- First name field -->
    
    <div class="grid_5 alignright padtop_2">First Name<span class="red">*</span>:</div>
    <input type="text" value="{{$info->first_name}}" name="first_name" class="grid_6" required>    <div class="clear"></div>
    <!-- Last name field -->
    <div class="grid_5 alignright padtop_2">Last Name<span class="red">*</span>:</div>
    <input type="text" value="{{$info->last_name}}" name="last_name" class="grid_6" required>    <div class="clear"></div>    <!-- Email field -->
     <div class="grid_5 alignright padtop_2">Email<span class="red">*</span>:</div>
    <input type="email" value="{{$info->email}}" class="grid_6" name="email" required>
    <div class="clear"></div>
    <div class="grid_5 alignright padtop_2">Address<span class="red">*</span>:</div>
    <input type="text" value="{{$info->address}}" name="address" class="grid_6" required>    <div class="clear"></div>
     <div class="grid_5 alignright padtop_2">city<span class="red">*</span>:</div>
    <input type="text" value="{{$info->city}}" name="city" class="grid_6" required>    <div class="clear"></div>
    <div class="grid_5 alignright padtop_2">state<span class="red">*</span>:</div>
    <input type="text" value="{{$info->state}}" name="state" class="grid_6" required>    <div class="clear"></div>
    <div class="grid_5 alignright padtop_2">Zipcode<span class="red">*</span>:</div>
    <input type="text" value="{{$info->zipcode}}" name="zipcode" class="grid_6" required>    <div class="clear"></div>
        <div class="grid_5 alignright padtop_5">Country<span class="red">*</span>:</div>
            <div class="grid_6" id="">
    <select name="country" required>
    <option selected="{{$info->country}}" value="{{$info->country}}">{{$info->country}}</option>
	<option title="Afghanistan" value="Afghanistan">Afghanistan</option>
	<option title="Åland Islands" value="Åland Islands">Åland Islands</option>
	<option title="Albania" value="Albania">Albania</option>
	<option title="Algeria" value="Algeria">Algeria</option>
	<option title="American Samoa" value="American Samoa">American Samoa</option>
	<option title="Andorra" value="Andorra">Andorra</option>
	<option title="Angola" value="Angola">Angola</option>
	<option title="Anguilla" value="Anguilla">Anguilla</option>
	<option title="Antarctica" value="Antarctica">Antarctica</option>
	<option title="Antigua and Barbuda" value="Antigua and Barbuda">Antigua and Barbuda</option>
	<option title="Argentina" value="Argentina">Argentina</option>
	<option title="Armenia" value="Armenia">Armenia</option>
	<option title="Aruba" value="Aruba">Aruba</option>
	<option title="Australia" value="Australia">Australia</option>
	<option title="Austria" value="Austria">Austria</option>
	<option title="Azerbaijan" value="Azerbaijan">Azerbaijan</option>
	<option title="Bahamas" value="Bahamas">Bahamas</option>
	<option title="Bahrain" value="Bahrain">Bahrain</option>
	<option title="Bangladesh" value="Bangladesh">Bangladesh</option>
	<option title="Barbados" value="Barbados">Barbados</option>
	<option title="Belarus" value="Belarus">Belarus</option>
	<option title="Belgium" value="Belgium">Belgium</option>
	<option title="Belize" value="Belize">Belize</option>
	<option title="Benin" value="Benin">Benin</option>
	<option title="Bermuda" value="Bermuda">Bermuda</option>
	<option title="Bhutan" value="Bhutan">Bhutan</option>
	<option title="Bolivia, Plurinational State of" value="Bolivia, Plurinational State of">Bolivia, Plurinational State of</option>
	<option title="Bonaire, Sint Eustatius and Saba" value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
	<option title="Bosnia and Herzegovina" value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
	<option title="Botswana" value="Botswana">Botswana</option>
	<option title="Bouvet Island" value="Bouvet Island">Bouvet Island</option>
	<option title="Brazil" value="Brazil">Brazil</option>
	<option title="British Indian Ocean Territory" value="British Indian Ocean Territory">British Indian Ocean Territory</option>
	<option title="Brunei Darussalam" value="Brunei Darussalam">Brunei Darussalam</option>
	<option title="Bulgaria" value="Bulgaria">Bulgaria</option>
	<option title="Burkina Faso" value="Burkina Faso">Burkina Faso</option>
	<option title="Burundi" value="Burundi">Burundi</option>
	<option title="Cambodia" value="Cambodia">Cambodia</option>
	<option title="Cameroon" value="Cameroon">Cameroon</option>
	<option title="Canada" value="Canada">Canada</option>
	<option title="Cape Verde" value="Cape Verde">Cape Verde</option>
	<option title="Cayman Islands" value="Cayman Islands">Cayman Islands</option>
	<option title="Central African Republic" value="Central African Republic">Central African Republic</option>
	<option title="Chad" value="Chad">Chad</option>
	<option title="Chile" value="Chile">Chile</option>
	<option title="China" value="China">China</option>
	<option title="Christmas Island" value="Christmas Island">Christmas Island</option>
	<option title="Cocos (Keeling) Islands" value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
	<option title="Colombia" value="Colombia">Colombia</option>
	<option title="Comoros" value="Comoros">Comoros</option>
	<option title="Congo" value="Congo">Congo</option>
	<option title="Congo, the Democratic Republic of the" value="Congo, the Democratic Republic of the">Congo, the Democratic Republic of the</option>
	<option title="Cook Islands" value="Cook Islands">Cook Islands</option>
	<option title="Costa Rica" value="Costa Rica">Costa Rica</option>
	<option title="Côte d'Ivoire" value="Côte d'Ivoire">Côte d'Ivoire</option>
	<option title="Croatia" value="Croatia">Croatia</option>
	<option title="Cuba" value="Cuba">Cuba</option>
	<option title="Curaçao" value="Curaçao">Curaçao</option>
	<option title="Cyprus" value="Cyprus">Cyprus</option>
	<option title="Czech Republic" value="Czech Republic">Czech Republic</option>
	<option title="Denmark" value="Denmark">Denmark</option>
	<option title="Djibouti" value="Djibouti">Djibouti</option>
	<option title="Dominica" value="Dominica">Dominica</option>
	<option title="Dominican Republic" value="Dominican Republic">Dominican Republic</option>
	<option title="Ecuador" value="Ecuador">Ecuador</option>
	<option title="Egypt" value="Egypt">Egypt</option>
	<option title="El Salvador" value="El Salvador">El Salvador</option>
	<option title="Equatorial Guinea" value="Equatorial Guinea">Equatorial Guinea</option>
	<option title="Eritrea" value="Eritrea">Eritrea</option>
	<option title="Estonia" value="Estonia">Estonia</option>
	<option title="Ethiopia" value="Ethiopia">Ethiopia</option>
	<option title="Falkland Islands (Malvinas)" value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
	<option title="Faroe Islands" value="Faroe Islands">Faroe Islands</option>
	<option title="Fiji" value="Fiji">Fiji</option>
	<option title="Finland" value="Finland">Finland</option>
	<option title="France" value="France">France</option>
	<option title="French Guiana" value="French Guiana">French Guiana</option>
	<option title="French Polynesia" value="French Polynesia">French Polynesia</option>
	<option title="French Southern Territories" value="French Southern Territories">French Southern Territories</option>
	<option title="Gabon" value="Gabon">Gabon</option>
	<option title="Gambia" value="Gambia">Gambia</option>
	<option title="Georgia" value="Georgia">Georgia</option>
	<option title="Germany" value="Germany">Germany</option>
	<option title="Ghana" value="Ghana">Ghana</option>
	<option title="Gibraltar" value="Gibraltar">Gibraltar</option>
	<option title="Greece" value="Greece">Greece</option>
	<option title="Greenland" value="Greenland">Greenland</option>
	<option title="Grenada" value="Grenada">Grenada</option>
	<option title="Guadeloupe" value="Guadeloupe">Guadeloupe</option>
	<option title="Guam" value="Guam">Guam</option>
	<option title="Guatemala" value="Guatemala">Guatemala</option>
	<option title="Guernsey" value="Guernsey">Guernsey</option>
	<option title="Guinea" value="Guinea">Guinea</option>
	<option title="Guinea-Bissau" value="Guinea-Bissau">Guinea-Bissau</option>
	<option title="Guyana" value="Guyana">Guyana</option>
	<option title="Haiti" value="Haiti">Haiti</option>
	<option title="Heard Island and McDonald Islands" value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
	<option title="Holy See (Vatican City State)" value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
	<option title="Honduras" value="Honduras">Honduras</option>
	<option title="Hong Kong" value="Hong Kong">Hong Kong</option>
	<option title="Hungary" value="Hungary">Hungary</option>
	<option title="Iceland" value="Iceland">Iceland</option>
	<option title="India" value="India">India</option>
	<option title="Indonesia" value="Indonesia">Indonesia</option>
	<option title="Iran, Islamic Republic of" value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
	<option title="Iraq" value="Iraq">Iraq</option>
	<option title="Ireland" value="Ireland">Ireland</option>
	<option title="Isle of Man" value="Isle of Man">Isle of Man</option>
	<option title="Israel" value="Israel">Israel</option>
	<option title="Italy" value="Italy">Italy</option>
	<option title="Jamaica" value="Jamaica">Jamaica</option>
	<option title="Japan" value="Japan">Japan</option>
	<option title="Jersey" value="Jersey">Jersey</option>
	<option title="Jordan" value="Jordan">Jordan</option>
	<option title="Kazakhstan" value="Kazakhstan">Kazakhstan</option>
	<option title="Kenya" value="Kenya">Kenya</option>
	<option title="Kiribati" value="Kiribati">Kiribati</option>
	<option title="Korea, Democratic People's Republic of" value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
	<option title="Korea, Republic of" value="Korea, Republic of">Korea, Republic of</option>
	<option title="Kuwait" value="Kuwait">Kuwait</option>
	<option title="Kyrgyzstan" value="Kyrgyzstan">Kyrgyzstan</option>
	<option title="Lao People's Democratic Republic" value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
	<option title="Latvia" value="Latvia">Latvia</option>
	<option title="Lebanon" value="Lebanon">Lebanon</option>
	<option title="Lesotho" value="Lesotho">Lesotho</option>
	<option title="Liberia" value="Liberia">Liberia</option>
	<option title="Libya" value="Libya">Libya</option>
	<option title="Liechtenstein" value="Liechtenstein">Liechtenstein</option>
	<option title="Lithuania" value="Lithuania">Lithuania</option>
	<option title="Luxembourg" value="Luxembourg">Luxembourg</option>
	<option title="Macao" value="Macao">Macao</option>
	<option title="Macedonia, the former Yugoslav Republic of" value="Macedonia, the former Yugoslav Republic of">Macedonia, the former Yugoslav Republic of</option>
	<option title="Madagascar" value="Madagascar">Madagascar</option>
	<option title="Malawi" value="Malawi">Malawi</option>
	<option title="Malaysia" value="Malaysia">Malaysia</option>
	<option title="Maldives" value="Maldives">Maldives</option>
	<option title="Mali" value="Mali">Mali</option>
	<option title="Malta" value="Malta">Malta</option>
	<option title="Marshall Islands" value="Marshall Islands">Marshall Islands</option>
	<option title="Martinique" value="Martinique">Martinique</option>
	<option title="Mauritania" value="Mauritania">Mauritania</option>
	<option title="Mauritius" value="Mauritius">Mauritius</option>
	<option title="Mayotte" value="Mayotte">Mayotte</option>
	<option title="Mexico" value="Mexico">Mexico</option>
	<option title="Micronesia, Federated States of" value="Micronesia, Federated States of">Micronesia, Federated States of</option>
	<option title="Moldova, Republic of" value="Moldova, Republic of">Moldova, Republic of</option>
	<option title="Monaco" value="Monaco">Monaco</option>
	<option title="Mongolia" value="Mongolia">Mongolia</option>
	<option title="Montenegro" value="Montenegro">Montenegro</option>
	<option title="Montserrat" value="Montserrat">Montserrat</option>
	<option title="Morocco" value="Morocco">Morocco</option>
	<option title="Mozambique" value="Mozambique">Mozambique</option>
	<option title="Myanmar" value="Myanmar">Myanmar</option>
	<option title="Namibia" value="Namibia">Namibia</option>
	<option title="Nauru" value="Nauru">Nauru</option>
	<option title="Nepal" value="Nepal">Nepal</option>
	<option title="Netherlands" value="Netherlands">Netherlands</option>
	<option title="New Caledonia" value="New Caledonia">New Caledonia</option>
	<option title="New Zealand" value="New Zealand">New Zealand</option>
	<option title="Nicaragua" value="Nicaragua">Nicaragua</option>
	<option title="Niger" value="Niger">Niger</option>
	<option title="Nigeria" value="Nigeria">Nigeria</option>
	<option title="Niue" value="Niue">Niue</option>
	<option title="Norfolk Island" value="Norfolk Island">Norfolk Island</option>
	<option title="Northern Mariana Islands" value="Northern Mariana Islands">Northern Mariana Islands</option>
	<option title="Norway" value="Norway">Norway</option>
	<option title="Oman" value="Oman">Oman</option>
	<option title="Pakistan" value="Pakistan">Pakistan</option>
	<option title="Palau" value="Palau">Palau</option>
	<option title="Palestinian Territory, Occupied" value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
	<option title="Panama" value="Panama">Panama</option>
	<option title="Papua New Guinea" value="Papua New Guinea">Papua New Guinea</option>
	<option title="Paraguay" value="Paraguay">Paraguay</option>
	<option title="Peru" value="Peru">Peru</option>
	<option title="Philippines" value="Philippines">Philippines</option>
	<option title="Pitcairn" value="Pitcairn">Pitcairn</option>
	<option title="Poland" value="Poland">Poland</option>
	<option title="Portugal" value="Portugal">Portugal</option>
	<option title="Puerto Rico" value="Puerto Rico">Puerto Rico</option>
	<option title="Qatar" value="Qatar">Qatar</option>
	<option title="Réunion" value="Réunion">Réunion</option>
	<option title="Romania" value="Romania">Romania</option>
	<option title="Russian Federation" value="Russian Federation">Russian Federation</option>
	<option title="Rwanda" value="Rwanda">Rwanda</option>
	<option title="Saint Barthélemy" value="Saint Barthélemy">Saint Barthélemy</option>
	<option title="Saint Helena, Ascension and Tristan da Cunha" value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
	<option title="Saint Kitts and Nevis" value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
	<option title="Saint Lucia" value="Saint Lucia">Saint Lucia</option>
	<option title="Saint Martin (French part)" value="Saint Martin (French part)">Saint Martin (French part)</option>
	<option title="Saint Pierre and Miquelon" value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
	<option title="Saint Vincent and the Grenadines" value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
	<option title="Samoa" value="Samoa">Samoa</option>
	<option title="San Marino" value="San Marino">San Marino</option>
	<option title="Sao Tome and Principe" value="Sao Tome and Principe">Sao Tome and Principe</option>
	<option title="Saudi Arabia" value="Saudi Arabia">Saudi Arabia</option>
	<option title="Senegal" value="Senegal">Senegal</option>
	<option title="Serbia" value="Serbia">Serbia</option>
	<option title="Seychelles" value="Seychelles">Seychelles</option>
	<option title="Sierra Leone" value="Sierra Leone">Sierra Leone</option>
	<option title="Singapore" value="Singapore">Singapore</option>
	<option title="Sint Maarten (Dutch part)" value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
	<option title="Slovakia" value="Slovakia">Slovakia</option>
	<option title="Slovenia" value="Slovenia">Slovenia</option>
	<option title="Solomon Islands" value="Solomon Islands">Solomon Islands</option>
	<option title="Somalia" value="Somalia">Somalia</option>
	<option title="South Africa" value="South Africa">South Africa</option>
	<option title="South Georgia and the South Sandwich Islands" value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
	<option title="South Sudan" value="South Sudan">South Sudan</option>
	<option title="Spain" value="Spain">Spain</option>
	<option title="Sri Lanka" value="Sri Lanka">Sri Lanka</option>
	<option title="Sudan" value="Sudan">Sudan</option>
	<option title="Suriname" value="Suriname">Suriname</option>
	<option title="Svalbard and Jan Mayen" value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
	<option title="Swaziland" value="Swaziland">Swaziland</option>
	<option title="Sweden" value="Sweden">Sweden</option>
	<option title="Switzerland" value="Switzerland">Switzerland</option>
	<option title="Syrian Arab Republic" value="Syrian Arab Republic">Syrian Arab Republic</option>
	<option title="Taiwan, Province of China" value="Taiwan, Province of China">Taiwan, Province of China</option>
	<option title="Tajikistan" value="Tajikistan">Tajikistan</option>
	<option title="Tanzania, United Republic of" value="Tanzania, United Republic of">Tanzania, United Republic of</option>
	<option title="Thailand" value="Thailand">Thailand</option>
	<option title="Timor-Leste" value="Timor-Leste">Timor-Leste</option>
	<option title="Togo" value="Togo">Togo</option>
	<option title="Tokelau" value="Tokelau">Tokelau</option>
	<option title="Tonga" value="Tonga">Tonga</option>
	<option title="Trinidad and Tobago" value="Trinidad and Tobago">Trinidad and Tobago</option>
	<option title="Tunisia" value="Tunisia">Tunisia</option>
	<option title="Turkey" value="Turkey">Turkey</option>
	<option title="Turkmenistan" value="Turkmenistan">Turkmenistan</option>
	<option title="Turks and Caicos Islands" value="Turks and Caicos Islands">Turks and Caicos Islands</option>
	<option title="Tuvalu" value="Tuvalu">Tuvalu</option>
	<option title="Uganda" value="Uganda">Uganda</option>
	<option title="Ukraine" value="Ukraine">Ukraine</option>
	<option title="United Arab Emirates" value="United Arab Emirates">United Arab Emirates</option>
	<option title="United Kingdom" value="United Kingdom">United Kingdom</option>
	<option title="United States" value="United States">United States</option>
	<option title="United States Minor Outlying Islands" value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
	<option title="Uruguay" value="Uruguay">Uruguay</option>
	<option title="Uzbekistan" value="Uzbekistan">Uzbekistan</option>
	<option title="Vanuatu" value="Vanuatu">Vanuatu</option>
	<option title="Venezuela, Bolivarian Republic of" value="Venezuela, Bolivarian Republic of">Venezuela, Bolivarian Republic of</option>
	<option title="Viet Nam" value="Viet Nam">Viet Nam</option>
	<option title="Virgin Islands, British" value="Virgin Islands, British">Virgin Islands, British</option>
	<option title="Virgin Islands, U.S." value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
	<option title="Wallis and Futuna" value="Wallis and Futuna">Wallis and Futuna</option>
	<option title="Western Sahara" value="Western Sahara">Western Sahara</option>
	<option title="Yemen" value="Yemen">Yemen</option>
	<option title="Zambia" value="Zambia">Zambia</option>
	<option title="Zimbabwe" value="Zimbabwe">Zimbabwe</option>
</select>
</div>
    <div class="clear"></div>
   
    <!-- username field -->
   
    
    <div class="grid_5 desktop">&nbsp;</div><div class="grid_4 tab-flright"><button class="medium_button signupbtn" type="submit">UPDATE</button></div>
    </form>
@endif
</div>
@endsection
