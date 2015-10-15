<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel Loan Calculator - by Brett Brewer</title>

    {{-- stupid IE stuff --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Load Bootstrap css from cdn -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->

    <!-- Load our custom styles -->
    <link rel="stylesheet" href="{!! elixir('css/all.css') !!}">

    <!-- stupid IE8 and lower mediaquery support -->
    <!--[if lt IE 9]>
    <script src="/js/respond.min.js"></script>
    <![endif]-->

    <script>
        /**
        * Define an event so we can tell if JQuery is loaded using our own custom function.
        * See the checkJQueryLoaded function in app.js which fires the JQueryLoaded event
        * once the global jQuery object is defined and jQuery.isLoaded is true.
        */
        var e = document.createEvent('Event');

        // Define that the event name as 'JQueryLoaded'.
        e.initEvent('JQueryLoaded', false, true);
        window.JQueryLoaded = e;
    </script>

    {{-- This has been moved to the footer
    <script src="{!! elixir('js/all.js') !!}"></script>
    --}}

</head>
<body role="document">

    <div class="container">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="{{ URL::route('home') }}">Loan Calculator</a>
            </div>
            <div class="navbar-collapse collapse">
              
              <ul class="nav navbar-nav">
                <li><a href="{{ URL::route('home') }}">Home</a></li>
               
                <li><a href="{{ URL::route('about') }}">About</a></li>
                <li><a href="{{ URL::route('bootstrap-examples') }}">Bootstrap3</a></li>
               
      
               
              
                
                </ul>
               
                
                <ul class="nav navbar-nav navbar-right">
                

                @if( Auth::user() ) 
                    <li class="dropdown ">
                      
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->username }}<span class="caret"></span></a>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                   
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-pencil"></span> Edit Account Info</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-off"></span> Log out {{ Auth::user()->username }}</a>
                        
                        </li>
                      </ul>
                   </li>
                @else
					<li>
                        <a href="#">Log In</a>
					</li>
                @endif

                
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
        
        {{-- Display any flash error messages from the session. --}}
        {{-- Errors should always be a MessageBag object --}}
        @if(Session::has('errors'))
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Errors
                    </h4>
                </div>
                
                @foreach(Session::get('errors')->all() as $error)
                <p style="padding:1em;">{{$error}}</p>
                @endforeach
               
            </div>
        @endif 
        
        {{-- Display any flash message from the session. --}}
        @if(Session::has('message'))
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Message
                    </h4>
                </div>
                
                <p style='padding:1em;'>{{ Session::get('message') }}</p>
                
            </div>
        @endif 
        
        {{-- Display any flash messages from the session messages array. --}}
        {{-- Messages should always be a MessageBag object --}}
        @if(Session::has('messages'))
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Messages
                    </h4>
                </div>
                
                @foreach(Session::get('messages')->all() as $message)
                    <p style="padding:1em;">{{$message}}</p>
                @endforeach
                
            </div>
        @endif 
           

        {{-- show our main content --}}
        @yield('content')
            
    </div>

    <div class="container-fluid" style='margin-top:3em;'>
        <div class="row" style='background:#ccc;'>
                <ul class="nav nav-justified">
                    <li><a href="/">LoanCalculator by Brett Brewer, {{@date("Y")}} LoanCalculator</a></li>
                </ul>

        </div>
    </div>

    <!-- These have all been combined in js/all.js for purposes of demonstration. 
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script async src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    -->

    <script async src="{!! elixir('js/all.js') !!}"></script>


</body>
</html>
