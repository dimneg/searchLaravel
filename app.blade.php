<!DOCTYPE html>
<!--
   _      _       _            _   ____            _                     
  | |    (_)     | |          | | |  _ \          (_)                    
  | |     _ _ __ | | _____  __| | | |_) |_   _ ___ _ _ __   ___  ___ ___ 
  | |    | | '_ \| |/ / _ \/ _` | |  _ <| | | / __| | '_ \ / _ \/ __/ __|
  | |____| | | | |   <  __/ (_| | | |_) | |_| \__ \ | | | |  __/\__ \__ \
  |______|_|_| |_|_|\_\___|\__,_| |____/ \__,_|___/_|_| |_|\___||___/___/
	  
-->
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style type="text/css">
		[fuse-cloak], fuse-cloak { display: none !important; }
    </style>
    
	
<?php 
$less_pages = array("login", "register", "password-request", "password-reset");


if (in_array(str_replace('.','-',Route::currentRouteName()), $less_pages)) { ?>	

	<link type="text/css" rel="stylesheet" href="{{ asset('css/all_pout.css') }}">	

	
<?php } else { ?>
	
	<link type="text/css" rel="stylesheet" href="{{ asset('css/all.css') }}">	
	
<?php }  ?>
	
	
		
	
<?php if (in_array(str_replace('.','-',Route::currentRouteName()), $less_pages)) { ?>	
	
	<script type="text/javascript" src="{{ asset('js/all_pout.js') }}"></script>
	
	<script type='text/javascript' src="{{ asset('js/components/clientjs/dist/client.min.js') }}"></script>

<?php } else { ?>

	<script type="text/javascript" src="{{ asset('js/all.js') }}"></script>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	

	<link rel="stylesheet" type="text/css" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/MarkerCluster.css" />
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/MarkerCluster.Default.css" />

    <script type='text/javascript' src='http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js'></script>
    <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/leaflet.markercluster.js'></script>
{{--
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
--}}
	
<?php }  ?>

	<link href="{{route('home')}}/images/favicon.ico" rel="shortcut icon">
	<link href="{{route('home')}}/images/android-chrome-144x144.png" rel="apple-touch-icon">

<script type='text/javascript' src='https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js'></script>
<script type='text/javascript' src='https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js'></script>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js'></script>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js'></script>
<script type='text/javascript' src='https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js'></script>
<script type='text/javascript' src='https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js'></script>


<script type='text/javascript' src='https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js'></script>
<script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js'></script>
<script type='text/javascript' src='//cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js'></script>


</head>
<body class="<?php echo str_replace('.','-',Route::currentRouteName());?> layout layout-vertical layout-left-navigation layout-above-toolbar">

		@if (!Auth::guest())
			
		<nav id="toolbar" class="fixed-top bg-white">

            <div class="row no-gutters align-items-center flex-nowrap">

                <div class="col">

                    <div class="row no-gutters align-items-center flex-nowrap">
	
						<div class="logo"><a href="{{route('home')}}/{{$lang}}"><img src="{{route('home')}}/images/logo.png"></a></div>
						
						<div class="toolbar-separator"></div>
										
                    </div>
                </div>

                <div class="col-auto">

                    <div class="row no-gutters align-items-center justify-content-end">
                    	@if(isset($stst))
                    	@if(((Auth::user()->product==2 || Auth::user()->role_id==3) || (Auth::user()->product==1 && $stst[0] - $stst[1]>0)) && isset($stst)) 
                    	  
							<img class="flag mr-2" src="{{route('home')}}/images/svg/wait.svg" width=16 height=16></i> {{ $stst[0] - $stst[1] }}

                    	@endif
                    	@endif

                        <div class="user-menu-button dropdown">

                            <div class="dropdown-toggle ripple row align-items-center no-gutters px-2 px-sm-4 fuse-ripple-ready" role="button" id="dropdownUserMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar-wrapper">
                                	@if(Auth::user()->logo==null)
                                    <img class="avatar" src="{{route('home')}}/avatars/profile.jpg">
                                    @else
                                    <img class="" src="/userlogos/{{ Auth::user()->logo }}" height=60>
                                    @endif
                                    <i class="status text-green icon-checkbox-marked-circle s-4"></i>
                                </div>
                                <span class="username mx-3 d-none d-md-block">{{ Auth::user()->name }}</span>
                            </div>

                            <div class="dropdown-menu" aria-labelledby="dropdownUserMenu">
							
								@if (Auth::user()->role_id == 3)
									<a class="dropdown-item fuse-ripple-ready" href="{{route('home')}}/{{$lang}}/admin">
										<div class="row no-gutters align-items-center flex-nowrap">
											<i class="icon-table-large"></i>
											<span class="px-3">{{ __('lang.useradmin_lbl') }}</span>
										</div>
									</a>

									<div class="dropdown-divider"></div>
									
									<a class="dropdown-item fuse-ripple-ready" href="{{route('home')}}/{{$lang}}/feedback">
										<div class="row no-gutters align-items-center flex-nowrap">
											<i class="icon-table-large"></i>
											<span class="px-3">{{ __('lang.feedback_lbl') }}</span>
										</div>
									</a>

									<div class="dropdown-divider"></div>

									<a class="dropdown-item fuse-ripple-ready" href="{{route('home')}}/{{$lang}}/notifications">
										<div class="row no-gutters align-items-center flex-nowrap">
											<i class="icon-table-large"></i>
											<span class="px-3">{{ __('lang.notifications_lbl') }}</span>
										</div>
									</a>

									<div class="dropdown-divider"></div>

								@endif
								
								<a class="dropdown-item fuse-ripple-ready" href="{{route('home')}}/{{$lang}}/profile/{{ Auth::user()->name }}/info">
                                    <div class="row no-gutters align-items-center flex-nowrap">
                                        <i class="icon-account"></i>
                                        <span class="px-3">{{ __('lang.myProfile') }}</span>
                                    </div>
                                </a>
								
								<div class="dropdown-divider"></div>
{{--
                                <a id="feedback-link" class="dropdown-item fuse-ripple-ready" href="#" data-toggle="modal" data-target="#feedbackModal">
                                    <div class="row no-gutters align-items-center flex-nowrap">
                                        <i class="icon-repeat"></i>
                                        <span class="px-3">{{ __('lang.feedback') }}</span>
                                    </div>
                                </a>

                                <div class="dropdown-divider"></div>
--}}
                                <a class="dropdown-item fuse-ripple-ready" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <div class="row no-gutters align-items-center flex-nowrap">
                                        <i class="icon-logout"></i>
                                        <span class="px-3">{{ __('lang.logout') }}</span>
                                    </div>
                                </a>
								
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
                                </form>
								
                            </div>
                        </div>                       

                        <div class="toolbar-separator"></div>

                       <!--  <div class="language-button dropdown">

                            <div class="dropdown-toggle ripple row align-items-center justify-content-center no-gutters px-0 px-sm-4 fuse-ripple-ready" role="button" id="dropdownLanguageMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="row no-gutters align-items-center">
									                                    
									@if ($lang == 'en')
										<img class="flag mr-2" src="{{route('home')}}/images/flags/en.png">
										<span class="d-none d-md-block">EN</span>
									@else
										<img class="flag mr-2" src="{{route('home')}}/images/flags/gr.png">
										<span class="d-none d-md-block">GR</span>
									@endif
									
                                </div>
                            </div>

                            <div class="dropdown-menu" aria-labelledby="dropdownLanguageMenu">

                                <a class="dropdown-item fuse-ripple-ready" href="
								@if (!str_contains(Request::fullUrl(), '/en'))
									@if (str_contains(Request::fullUrl(), '/gr'))
										{{ str_replace('/gr', '/en', Request::fullUrl()) }}
									@else
										{{ Request::fullUrl() }}/en
									@endif									
								@endif">
                                    <div class="row no-gutters align-items-center flex-nowrap">
                                        <img class="flag" src="{{route('home')}}/images/flags/en.png">
										<span class="px-3">English</span>
                                    </div>
                                </a>

                                <a class="dropdown-item fuse-ripple-ready" href="								
								@if (str_contains(Request::fullUrl(), '/en'))
									{{ str_replace('/en', '/gr', Request::fullUrl()) }}
								@endif
								">
                                    <div class="row no-gutters align-items-center flex-nowrap">
										<img class="flag" src="{{route('home')}}/images/flags/gr.png">
                                        <span class="px-3">Greek</span>
                                    </div>
                                </a>
								
                            </div>
                        </div> -->

                        <div class="toolbar-separator"></div>

                        <a href="{{route('home')}}/{{$lang}}/search"><button type="button" id="old=openSearchTop" class="search-button btn btn-icon fuse-ripple-ready">
                        	<i class="icon icon-magnify"></i>
                        </button></a>
                            
                        <div class="toolbar-separator"></div>

                        <button type="button" class="quick-panel-button btn btn-icon fuse-ripple-ready" data-toggle="modal" data-target="#feedbackModal" title="{{ __('lang.feedback') }}">
                            <i class="icon icon-comment-alert-outline"></i>
                        </button>

                        <div class="toolbar-separator"></div>

                        <button type="button" class="quick-panel-button btn btn-icon fuse-ripple-ready" data-fuse-bar-toggle="quick-panel-sidebar">
                            <i class="icon icon-format-list-bulleted"></i>
                        </button>

                    </div>
                </div>
            </div>           
        </nav>

        <button type="button" id="closeSearchTop" class="close">
			<span aria-hidden="true">×</span>
		</button>

        <div id="searchBar" class="fuse-search-bar">
		    
		    <form method="post" action="{{ route('home') }}/{{ $lang }}/topsearch/" id="topSearch">
				<input name="_token" type="hidden" value="{{ csrf_token() }}">
				<input class="searchbox" id="fuse-search-bar-input" name="searchKey" placeholder="{{ __('lang.searchLabel') }}" type="text">			 			   
			</form>
		</div>
		
		@endif

		
		
		<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog"
			 aria-labelledby="exampleModalLabel"
			 aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">{{ __('lang.feedback') }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
                        <div id="error-modal" class="alert alert-danger" role="alert"></div>
                        <div class="alert alert-success" role="alert">{{ __('lang.feedback_success') }}</div>
						<form id="feedback_form">    
							<input type="hidden" id="feedback_url" name="feedback_url" value="{{ url()->current() }}">
							<div class="form-group">
								<label for="message-text" class="form-control-label">{{ __('lang.message_lbl') }}:</label>
								<textarea class="form-control feedbacktxt" id="message-text" name="feeadback_message" required></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
						<button type="button" class="btn btn-primary" id="send-feedback">{{ __('lang.send_message') }}</button>
					</div>
				</div>
			</div>
		</div>
<!--
		<div id="searchBar" class="">
			search bar
		</div>
-->
		

		@if (!Auth::guest())
            
		<script>
			$("#openSearchTop").click(function() {				
				$("#searchBar, #closeSearchTop").show();
			});

			$("#closeSearchTop").click(function() {				
				$("#searchBar, #closeSearchTop").hide();
			});

            $("#feedback-link").click(function() {
                $("#error-modal").hide();
                $(".alert-success").hide();
                $("#message-text").val("");
            });
            
			$("#send-feedback").click(function() {
				var feedback_url = $("#feedback_url").val();
				var feedback_message = $("#message-text").val();
				
                //alert(feedback_message);
                
				$("#error-modal").hide();
                
                // check if textarea is empty even with spaces or enter
                if($("#message-text").val().trim() != ''){
               
                    $.ajax({
                        type: "post",
                        url: '{{route('home')}}/feedback/',
                        data: { 
                            "feedback_url": feedback_url,
                            "feedback_user_id": {{ Auth::user()->id }},
                            "feedback_message": feedback_message,					
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            $("#error-modal").hide();
                            $(".alert-success").show();
                            $("#message-text").val("");
                            setTimeout( function() {
                                $('#feedbackModal').modal('toggle');
                            }, 2000);
                            
                            //window.location.reload();

                        },
                        error: function() {
                            console.log('error');
                        }
                    });

                } else {
                    //console.log('error: field is empty');
                    $("#error-modal").html("<strong>{{ __('lang.warning') }}!</strong> {{ __('lang.feedback_error') }}.");
                    $("#error-modal").show();
                    $(".alert-success").hide();
                }
				
			});
		</script>
            
		@endif
        
        @yield('content')


       
	

</body>
 <footer>
        	<br>
        	
        
        	<div class="row" style="text-align: right; background-color: #D9D9D9; color: #000000; position: fixed; left: 0 ; right: 0; bottom: 0;  height:30px; line-height: 200%;">
        		    <div class="col-6 col-lg-6" style="text-align: left;">
        		    	 &emsp;&emsp;<a href="http://greece.linkedbusiness.eu/" style="color:#0275d8;"> Αρχική</a>  &emsp;&emsp;    <a href="http://greece.linkedbusiness.eu/Terms" style="color:#0275d8;">Όροι Χρήσης</a>   &emsp;&emsp;   <a href="http://greece.linkedbusiness.eu/data-policy" style="color:#0275d8;">Προσωπικά Δεδομένα</a> &emsp;&emsp;
        		    </div>
        		    <div class="col-6 col-lg-6">
        		    	 &emsp;&emsp;© 2018, Linkedbusiness.gr/eu, v1.11.01, All Rights Reserved. &emsp;&emsp;
        		    </div>					
		    </div>	
		    	
		   
		</footer>
</html>