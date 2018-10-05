@extends('layouts.app_nofooter')

@section('content')
<?php
$adv_orgType= '';
#$search_in_amount = '';
$crf1 = '';
$crf2 = '';
$crf3 = '';
?>

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
										<li><a id="tab2" class="right active" href="#2a" data-toggle="tab">{{ __('lang.managers_directors') }} </a></li>
									@else
										<li><a id="tab1" class="left active" href="#1a" data-toggle="tab">{{ __('lang.companies') }}</a></li>
										<li><a id="tab2" class="right" href="#2a" data-toggle="tab">{{ __('lang.managers_directors') }}</a></li>
									@endif
								</ul>

								<div class="tab-content clearfix">
									@if ($isdirector == 1) 
										<div class="tab-pane" id="1a">
									@else 
										<div class="tab-pane active" id="1a">											
									@endif
										<div class="search">
											<form method="post" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest3" id="searchFormCompanies">
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
												<div style="margin:20px 0px; display:inline-block; width:100%;">
													<input type="text" id="searchKey" name="searchKey" value="{{ $varKeyword }}" class="searchText" placeholder='{{ __('lang.advancedSearchPlaceholder') }}'>
													<input type="submit" value="Search" class="searchSubmit">
													<div class="error" style="float:left; margin-top:5px;">{{ __('lang.field_required') }}</div>
												</div>
												<span class="advanced_search" onClick="showHideAdvanceSearch()">{{ __('lang.advancedSearchBtn') }}</span>
                                                                                                 <div id="advanced-search-box" <?php if(empty($advance_search_submit)) { ?>style="display:none;"<?php } ?>>
                                                                                                    <!--<label class="search-label">Αναζήτηση με Διεύθυνση:</label>
                                                                                                    <div>
                                                                                                            <input type="text" name="crf1" id="crf1" class="demoInputBox" action="index.php"  	/>
                                                                                                    </div>
                                                                                                    <label class="search-label">Αναζήτηση με ΤΚ:</label>
                                                                                                    <div>
                                                                                                            <input type="text" name="crf2" id="crf2" class="demoInputBox" value="<?php echo $crf2; ?>"	/> 
                                                                                                      
                                                                                                                   </form>

                                                                                                    </div>   -->
                                                                                                   <form id="selectOrgtype" name="selectOrgtype" method="get" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest3">
                                                                                                        <table width="300" border="1">
                                                                                                          <tr>
                                                                                                            <td><label>Επιλογή εταιρικού τύπου:</label>&nbsp;</td>
                                                                                                            <td><select id="selectOrgtype"  name="selectOrgtype[]" size="6" multiple="multiple" tabindex="1">
                                                                                                              <option value="FR">Ελ. Επαγγ.</option>
                                                                                                              <option value="PLC*">ΑΕ</option>
                                                                                                              <option value="GP">ΟΕ</option>
                                                                                                              <option value="LP">ΕΕ</option>
                                                                                                              <option value="LTD*">ΕΠΕ</option>
                                                                                                              <option value="PC*">ΙΚΕ</option>
                                                                                                              <option value=" ">Άγνωστο</option>
                                                                                                              
                                                                                                            </select>
                                                                                                            </td>
                                                                                                          </tr>
                                                                                                         <!-- <tr>
                                                                                                            <td>&nbsp;</td>
                                                                                                            <td><input type="submit" name="selectOrgtype" value="selectOrgtype" /></td>
                                                                                                          </tr>-->
                                                                                                        </table>
                                                                                                      </form> 
                                                                                                    

                                                                                                    
                                                                                                    <form id="showOnlyActive" method="post" align="right" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest3">
                                                                                                        
                                                                                                         <!--<input type="checkbox" class="searchSubmit" id="showOnlyActive" name="showOnlyActive"  value="showOnlyActive" /> <label>Show only Active</label>-->  
                                                                                                       <!-- <input type="submit" name="showOnlyActive" value="Yes" />-->  
                                                                                                       <!-- <input type="checkbox" name="showOnlyActive" value="showOnlyActive"> <label>showOnlyActive</label> -->                                                                                                                                                                                          
                                                                                                         <input type="submit" name="showOnlyActive" value="Ενεργές" />
                                                                                                    </form>
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                              <div>
                                                                                           <!--  <div> <input type="submit" name="Go" class="btnSearch"  value="Search" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest3"  method="post" accept-charset="UTF-8" >
                                                                                                 <input type="submit" name="Go" class="btnSearch"  value="Search" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest3"  method="post" accept-charset="UTF-8" >
                                                                                              
                                                                                             </div>  -->  
                                                                                            </div>
                                                                                            </div>
											</form>				
										</div>										
									</div>
									@if ($isdirector == 1)
										<div class="tab-pane active" id="2a">
									@else 
										<div class="tab-pane" id="2a">											
									@endif											
										<div class="search">
											<form method="post" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest3" id="searchFormDirectors">
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
												<div style="margin:20px 0px; display:inline-block; width:100%;">
													<input type="text" id="searchKey" name="searchKey" value="{{ $varKeyword }}" class="searchText" placeholder='{{ __('lang.advancedSearchPlaceholder_managers_directors') }}'>
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
																				searchPlaceholder: "{{ __('lang.advancedSearchPlaceholderDatatables') }} ",
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
																				searchPlaceholder: "{{ __('lang.advancedSearchPlaceholderDatatables') }} ",
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
            $( "#showOnlyActive" ).submit();
            $( "#selectOrgtype" ).submit();
	});

	$("#tab2").click(function(){
	    //alert("Tab 2 clicked.");
	    $( "#searchFormDirectors" ).submit();
	});

</script>
<script>
    function showHideAdvanceSearch() {
        if(document.getElementById("advanced-search-box").style.display=="none") {
            document.getElementById("advanced-search-box").style.display = "block";
	    document.getElementById("advance_search_submit").value= "1";
             document.getElementById("showOnlyActive").value= "1";
             document.getElementById("selectOrgtype").value= "1";
            }
            else {
		document.getElementById("advanced-search-box").style.display = "none";
		document.getElementById("showOnlyActive").value= "" 
		//document.getElementById("crf2").value= "";
		//document.getElementById("crf3").value= "";
		//document.getElementById("search_in").value= "";
		document.getElementById("advance_search_submit").value= "";
                document.getElementById("selectOrgtype").value= "";
	    }
   }
</script>
<footer>
</footer>
	
@endsection	