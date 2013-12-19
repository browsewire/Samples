@extends('layouts.default')
@section('content')
 <div class="container-fluid">
      <div id="mainnav" class="hidden-phone hidden-tablet">
		@include('layouts.rightSidebar')
      </div>
      <div class="dashboard-wrapper">
        <div class="main-container">
          <div class="navbar hidden-desktop">
            <div class="navbar-inner">
              <div class="container">
                <a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </a>
                <div class="nav-collapse collapse navbar-responsive-collapse">
					@include('layouts.navResponsive')
                </div>
              </div>
            </div>
          </div>
		 
          <div class="row-fluid">
            <div class="span12">
              @include('content.default')
            </div>
          </div>
        </div>
      </div><!-- dashboard-container -->
    </div><!-- container-fluid -->
@endsection
