@extends('layouts.app')

@section('content')

<div id="wrapper">
	<div class="content-wrapper">

		<div class="content">
			<div id="project-dashboard" class="page-layout simple right-sidebar tabbed">
	
				<div class="page-content-wrapper">
				
					<div id="searchBox" class="p-8 advancedsearch">

                        <div class="messagebox form-wrapper md-elevation-8 p-8">
						
							<div id="exTab1" class="container">
								<ul  class="nav nav-pills">
									
									@if ($isdirector == 1) 
										<li><a id="tab1" class="left" href="#1a" data-toggle="tab">Επιχειρήσεις</a></li>
										<li><a id="tab2" class="right active" href="#2a" data-toggle="tab">Διαχειριστές & Ιδιοκτήτες</a></li>
									@else
										<li><a id="tab1" class="left active" href="#1a" data-toggle="tab">Επιχειρήσεις</a></li>
										<li><a id="tab2" class="right" href="#2a" data-toggle="tab">Διαχειριστές & Ιδιοκτήτες</a></li>
									@endif
								</ul>

								<div class="tab-content clearfix">
									@if ($isdirector == 1) 
										<div class="tab-pane" id="1a">
									@else 
										<div class="tab-pane active" id="1a">											
									@endif
										<div class="search">
											<form method="post" action="{{ route('home') }}/en/advancedsearch" id="searchFormCompanies">
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
												<div style="margin:20px 0px; display:inline-block; width:100%;">
													<input type="text" id="searchKey" name="searchKey" value="{{ $varKeyword }}" class="searchText" placeholder="Αναζήτηση με ΑΦΜ & επωνυμία σε 1.340.567 επιχειρήσεις">
													<input type="submit" value="Search" class="searchSubmit">
													<div class="error" style="float:left; margin-top:5px;">Το πεδίο είναι υποχρεωτικό!</div>
												</div>
												<span class="advanced_search"><a href="#">Σύνθετη αναζήτηση</a></span>											
											</form>				
										</div>										
									</div>
									@if ($isdirector == 1)
										<div class="tab-pane active" id="2a">
									@else 
										<div class="tab-pane" id="2a">											
									@endif											
										<div class="search">
											<form method="post" action="{{ route('home') }}/{{ $lang }}/advancedsearch" id="searchFormDirectors">
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
												<div style="margin:20px 0px; display:inline-block; width:100%;">
													<input type="text" id="searchKey" name="searchKey" value="{{ $varKeyword }}" class="searchText" placeholder="Αναζήτηση με ΑΦΜ & επωνυμία σε 546.568 μετόχους και διαχειριστές επιχειρήσεων">
													<input type="hidden" name="isdirector" value="1">
													<input type="submit" value="Search" class="searchSubmit">
													<div class="error" style="float:left; margin-top:5px;">Το πεδίο είναι υποχρεωτικό!</div>
												</div>											
											</form>								
										</div>
{{--
										<div class="search_results" style="margin-top: 40px;">
											{!! $table_str !!}

											<script type="text/javascript">
														$('#searchResults2').DataTable({														
															responsive: true,									
																"lengthChange": true,
																"paging": true,
																"pagingType": "simple",
																"info": true,
																"ordering": true,
																"language": {   "sSearch": "<i class='icon icon-magnify'></i>", 
																				searchPlaceholder: "searchLabel",
																				"lengthMenu": "Records per page _MENU_ ",
																				"paginate": { "previous": "<", "next": ">" },
																				"info": "_START_ - _END_ from _TOTAL_",
																				"sInfoEmpty": "0 - _END_ from _TOTAL_",
																				"emptyTable": "No data available in table",
																				"decimal": ",",
							            										"thousands": "."													
																			}
														});
													</script>
										</div>
--}}										
									</div>

									<div class="search_results" style="margin-top: 40px;">
											{!! $table_str !!}

											<script type="text/javascript">
														$('#searchResults').DataTable({
														"aaSorting": [[ 1, "desc" ]],

															  responsive: true,									
																"lengthChange": true,
																"paging": true,
																"pagingType": "simple",
																"info": true,
																
																//"ordering": true,
																"language": {   "sSearch": "<i class='icon icon-magnify'></i>", 
																				searchPlaceholder: "searchLabel",
																				"lengthMenu": "Εγγραφές ανά σελιδα _MENU_ ",
																				"paginate": { "previous": "<", "next": ">" },
																				"info": "_START_ - _END_ από _TOTAL_",
																				"sInfoEmpty": "0 - _END_ από _TOTAL_",
																				"emptyTable": "Δεν υπάρχουν δεδομένα αυτή τη στιγμή",
																				"decimal": ".",
							            										"thousands": ""													
																			},
																
																"aoColumnDefs": [{ "bVisible": false, "aTargets": [ 1 ] }]
														});													
													</script>
										</div>

								</div>
							</div>

							
                        </div>
                    </div>
				</div>		
			</div>
		</div>
	</div>
		
	

</div>
	
<script>
	$("#tab1").click(function(){
	    //alert("Tab 1 clicked.");
	    $( "#searchFormCompanies" ).submit();
	});

	$("#tab2").click(function(){
	    //alert("Tab 2 clicked.");
	    $( "#searchFormDirectors" ).submit();
	});
/*
	$( "#searchForm" ).submit(function( e ) {
		
		searchKey = $( "#searchKey" ).val();
		
		if (searchKey!="") {
		
            $('#searchForm').attr('action', "{{ route('home') }}/{{ $lang }}/company/"+searchKey+"/basic").submit();
        } else {
			$('#searchForm .error').show();
		}
		
		
		e.preventDefault();
	});
	*/
</script>	
	
@endsection	