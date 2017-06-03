<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>NewsG - @yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
        .container{min-height:450px;}
        .pagination{float:left;width:100%;margin:0px;padding:5px;text-align: center;background:#e3e3e3;}
        .pagination a.prev{float:left;width:50%;text-align:left;font-size:18px;}
        .pagination a.next{float:right;width:50%;text-align:right;font-size:18px;}
        .pagination a.prev span {font-size: 23px;margin-right: 5px;}
        .pagination a.next span {font-size: 23px;margin-left: 5px;}
        .pagination li span{font-size: 20px;}
        .pagination li{font-size: 20px; display: inline-block;list-style:none;padding: 2px 5px;}
        .pagination li.active span{font-size: 14px;}
         body{width:100%;margin:0px;}
        .header{width:100%;background:#e2e2e2;text-align:center;font-size:30px;padding:20px 0px;}
        .footer{width:100%;background:#e2e2e2;text-align:center;font-size:12px;padding:10px 0px;float:left;}
        .form{width:600px;float:left;margin:0px;}
        .form-group{width:100%;float:left;margin:5px;}
        .form-group label{width:200px;float:left;}
        .form-group input[type=text]{width:400px;float:left;}
        .form-group input[type=submit]{width:100px;float:left;}
        .row{width:100%;float:left;padding-bottom:20px;}
        .left-content{width:70%;float:left}
        .right-sidebar{width:25%;float:right}
         a{text-decoration:none;color:#005789;}
        #content{width:90%;margin:5%;}
        .post-list{width:47%;}
         a:hover{color:#000;}
         h1{margin:0px;}
         h2{margin: 0px;font-size:20px;}
         h4 {margin: 0;font-size:14px;}
         span{font-size:12px;color:#005789;}
        .post-list p.action{text-align:right;}
         p.tags{float:left;width:100%;background:#e3e3e3;padding:5px;}
        .post-list:nth-child(2n+1){float:left;margin: 1% 0%;padding:1% 1% 1% 0%;border-bottom:1px solid #005789;border-right:1px solid #005789;}
        .post-list:nth-child(2n+2){float:right;margin: 1% 0%;padding:1% 1% 1% 1%;border-bottom:1px solid #005789;border-left:1px solid #005789;}
        .right-sidebar > ul {list-style-type: square;padding: 0 0 0 15px;}
        .right-sidebar > ul li{padding:2px 0px;}
        </style>
    </head>
    <body>
        
        @section('sidebar')
            <div class="header"><a href="{{ URL::to( '/'  ) }}" title="News Home">News Home</a></div>
        @show

        <div class="container">
            @yield('content')
        </div>
        
        <div class="footer">&copy; 2017 All Rights Reserved BWC:Web Development</div>
    </body>
</html>
