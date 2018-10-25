@extends('layouts.app_nofooter')

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
										<li><a id="tab1" class="left" href="#1a" data-toggle="tab">{{ __('lang.companies') }} </a></li>
										<li><a id="tab2" class="right active" href="#2a" data-toggle="tab">{{ __('lang.corporate_groups') }} </a></li>
									@else
										<li><a id="tab1" class="left active" href="#1a" data-toggle="tab">{{ __('lang.companies') }}</a></li>
										<li><a id="tab2" class="right" href="#2a" data-toggle="tab">{{ __('lang.corporate_groups') }}</a></li>
									@endif
								</ul>

								<div class="tab-content clearfix">
									@if ($isdirector == 1) 
										<div class="tab-pane" id="1a">
									@else 
										<div class="tab-pane active" id="1a">											
									@endif
										<div class="search">
											<form method="post" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest2" id="searchFormCompanies">
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
												<div style="margin:20px 0px; display:inline-block; width:100%;">
													<input type="text" id="searchKey" name="searchKey" value="{{ $varKeyword }}" class="searchText" placeholder='{{ __('lang.advancedSearchPlaceholder') }}'>
													<input type="submit" value="Search" class="searchSubmit">
													<div class="error" style="float:left; margin-top:5px;">{{ __('lang.field_required') }}</div>
												</div>
												<span class="advanced_search"><a href="#">{{ __('lang.advancedSearchBtn') }}</a></span>	
                                                                                                 <span class="advanced_search" onClick="showHideAdvanceSearch()">Σύνθετη Αναζήτηση</span>
											</form>				
										</div>										
									</div>
									@if ($isdirector == 1)
										<div class="tab-pane active" id="2a">
									@else 
										<div class="tab-pane" id="2a">											
									@endif											
										<div class="search">
											<form method="post" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest2" id="searchFormDirectors">
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
												<div style="margin:20px 0px; display:inline-block; width:100%;">
													<input type="text" id="searchKey" name="searchKey" value="{{ $varKeyword }}" class="searchText" placeholder='{{ __('lang.advancedSearchPlaceholder_corporate') }}'>
													<input type="hidden" name="isdirector" value="1">
													<input type="submit" value="Search" class="searchSubmit">
													<div class="error" style="float:left; margin-top:5px;">{{ __('lang.field_required') }}</div>
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
																				"lengthMenu": "{{ __('lang.advancedSearchResults_lengthMenu') }} ",
																				"paginate": { "previous": "<", "next": ">" },
																				"info": "_START_ - _END_ from _TOTAL_",
																				"sInfoEmpty": "0 - _END_ from _TOTAL_",
																				"emptyTable": "{{ __('lang.empty_table') }}",
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
																				"lengthMenu": "{{ __('lang.advancedSearchResults_lengthMenu') }}",
																				"paginate": { "previous": "<", "next": ">" },
																				"info": "_START_ - _END_ από _TOTAL_",
																				"sInfoEmpty": "0 - _END_ από _TOTAL_",
																				"emptyTable": "{{ __('lang.empty_table') }}",
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

	@include('sidebar')

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

<script>
    function showHideAdvanceSearch() {
        if(document.getElementById("advanced-search-box").style.display=="none") {
            document.getElementById("advanced-search-box").style.display = "block";
	    document.getElementById("advance_search_submit").value= "1";
            }
            else {
		document.getElementById("advanced-search-box").style.display = "none";
		document.getElementById("crf1").value= "" 
		document.getElementById("crf2").value= "";
		document.getElementById("crf3").value= "";
		document.getElementById("search_in").value= "";
		document.getElementById("advance_search_submit").value= "";
	    }
   }
</script>
<footer>
<p>  The Open Journalism (OpJ) Project is funded by:
 <img src="/images/opjlogos/inn_fund.png" alt="Innovation Fund" width="108" height="44 "align="middle">
 <img src="/images/opjlogos/dni.png" alt="Digital News Initiative" width="108" height="44" align="middle">
 </p>
</footer>
	
@endsection	