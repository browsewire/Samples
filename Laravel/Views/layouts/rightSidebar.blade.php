 <ul>
	@if(empty($pageName))
          <li class="active">
			 <span class="current-arrow"></span>
	@else
	 <li>
	@endif	 
		    <a href="{{URL::to($username)}}">
              <div class="icon">
				  <img src="{{URL::to($profilePicLarge)}}" width="60" height="50" />
              </div>
           </a>
          </li>
   @if($pageName=='page1')
         <li class="active">
			<span class="current-arrow"></span>
	@else
	 <li>
	@endif	
            <a href="{{URL::to($username)}}/page1">
              <div class="icon">
                <span class="fs1" aria-hidden="true" data-icon="&#xe006;"></span>
              </div>
              page1
            </a>
          </li>
          
	@if($pageName=='page2')
         <li class="active">
			<span class="current-arrow"></span>
	@else
	 <li>
	@endif
            <a href="{{URL::to($username)}}/page2">
              <div class="icon">
                <span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span>
              </div>
               page2
            </a>
          </li>
          
	@if($pageName=='story')
         <li class="active">
			<span class="current-arrow"></span>
	@else
		<li>
	@endif
            <a href="{{URL::to($username)}}/story">
              <div class="icon">
                <span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span>
              </div>
              Story
            </a>
          </li>
          
  @if($pageName=='page3')
         <li class="active">
			<span class="current-arrow"></span>
	@else
		<li>
	@endif
            <a href="{{URL::to($username)}}/page3">
              <div class="icon">
                <span class="fs1" aria-hidden="true" data-icon="&#xe01f;"></span>
              </div>
              page3
            </a>
          </li>
   @if($pageName=='profile')
         <li class="active">
			<span class="current-arrow"></span>
	@else
		<li>
	@endif
            <a href="{{URL::to($username)}}/profile">
              <div class="icon">
                <span class="fs1" aria-hidden="true" data-icon="&#xe023;"></span>
              </div>
              Profile
            </a>
          </li>
          
          

		@if($pageName=='settings')
		 <li class="active">
			<span class="current-arrow"></span>
		@else
			<li>
		@endif
			<a href="{{URL::to(Auth::user()->username)}}/settings">
			  <div class="icon">
				<span class="fs1" aria-hidden="true" data-icon="&#xe08b;"></span>
			  </div>
			  Settings
			</a>
	   </li>

    
    @if($userSession)   
		<li>
            <a href="{{URL::to('logout')}}">
              <div class="icon">
                <span style="color:#d13736;" class="fs1" aria-hidden="true" data-icon="&#xe0b1;"></span>
              </div>
              Logout
            </a>
          </li> 
       @endif     
 </ul>
