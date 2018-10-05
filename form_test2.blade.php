@extends('layouts.app_nofooter')

@section('content')
<?php

$search_in_area = '';
$search_in_amount = '';
$crf1 = '';
$crf2 = '';
$crf3 = '';
?>
 <style>
     body{
			 <!--width: 900px;-->
			font-family: "Segoe UI",Optima,Helvetica,Arial,sans-serif;
			line-height: 25px;
		}
		.search-box {
			padding: 30px;
			background-color:#C8EEFD;
		}
		.search-label{
			margin:2px;
                        border: 1;
                        border-radius: 4px;
			
		}
		.demoInputBox {    
			padding: 10px;
			border: 2;
			border-radius: 4px;
			margin: 0px 5px 15px;
			width: 250px;
		}
		.btnSearch{    
			padding: 8px;
                        position: relative;
                        /*left: -80px; */
			background: #84D2A7;
			border: 0;
			border-radius: 4px;
			margin: 0px 5px;
			color: #FFF;
			width: 150px;
		}
		#advance_search_link {
			color: #001FFF;
			cursor: pointer;
                       
		}
                #search_link {
			color: #001FFF;
			cursor: pointer;
                       
		}
		.result-description{
			margin: 5px 0px 15px;
		}
                #flags img {
                
                margin-left: 160px;
                }
                .table a
                {
                display:inline;
                text-decoration:none;
                font-size: 6px;
                color: #989898; 
                border: 0;
	        border-radius: 0px;
                align-self: center;
                align-items: center;
                }
 </style>

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
												<!--<span class="advanced_search"><a href="#">{{ __('lang.advancedSearchBtn') }}</a></span>	-->
                                                                                                <span class="advanced_search" onClick="showHideAdvanceSearch()">{{ __('lang.advancedSearchBtn') }}</span>
                                                                                                <div id="advanced-search-box" <?php if(empty($advance_search_submit)) { ?>style="display:none;"<?php } ?>>
                                                                                                    <label class="search-label">Αναζήτηση με Διεύθυνση:</label>
                                                                                                    <div>
                                                                                                            <input type="text" name="crf1" id="crf1" class="demoInputBox" action="index.php"  	/>
                                                                                                    </div>
                                                                                                    <label class="search-label">Αναζήτηση με ΤΚ:</label>
                                                                                                    <div>
                                                                                                            <input type="text" name="crf2" id="crf2" class="demoInputBox" value="<?php echo $crf2; ?>"	/> 
                                                                                                      
                                                                                                                   </form>

                                                                                                    </div> 
                                                                                                     <table  border="0" class="table" >
                                                                                                    <tr>
                                                                                                    <td><I>Example: Name: "Oracle", Search in:  "Australia", Atos, Amount:">2M < 2B" </I></td>     


                                                                                                    </tr> 
                                                                                                    </table> 
                                                                                                    <label class="search-label">Search in:</label>
                                                                                                    <div>
                                                                                                            <select name="advSearch[search_in_area]" id="search_in_area" class="demoInputBox">
                                                                                                                    <option value="">Select:</option>
                                                                                                                    <option value="GR" <?php if($search_in_area=="GR") { echo "selected"; } ?>>Greece</option>	
                                                                                                                    <option value="EU" <?php if($search_in_area=="US") { echo "selected"; } ?>>Europe</option>
                                                                                                                    <option value="AT" <?php if($search_in_area=="AT") { echo "selected"; } ?>>Austria</option>	                                                                                                                    						
                                                                                                                    <option value="AU" <?php if($search_in_area=="AU") { echo "selected"; } ?>>Αustralia</option>
                                                                                                                    <option value="BE" <?php if($search_in_area=="BE") { echo "selected"; } ?>>Belgium</option>
                                                                                                                    <option value="CZ" <?php if($search_in_area=="CZ") { echo "selected"; } ?>>Czech Republic</option>
                                                                                                                    <option value="CY" <?php if($search_in_area=="CY") { echo "selected"; } ?>>Cyprus</option>
                                                                                                                    <option value="DK" <?php if($search_in_area=="DK") { echo "selected"; } ?>>Denmark</option>
                                                                                                                    <option value="EE" <?php if($search_in_area=="EE") { echo "selected"; } ?>>Estonia</option>                                                                                                                   
                                                                                                                    <option value="FI" <?php if($search_in_area=="FI") { echo "selected"; } ?>>Finland</option>
                                                                                                                    <option value="FR" <?php if($search_in_area=="FR") { echo "selected"; } ?>>France</option>
                                                                                                                    <option value="DE" <?php if($search_in_area=="DE") { echo "selected"; } ?>>Germany</option>
                                                                                                                    <option value="HU" <?php if($search_in_area=="HU") { echo "selected"; } ?>>Hungary</option>
                                                                                                                    <option value="IS" <?php if($search_in_area=="IS") { echo "selected"; } ?>>Iceland</option>
                                                                                                                    <option value="IE" <?php if($search_in_area=="IE") { echo "selected"; } ?>>Ireland</option>
                                                                                                                    <option value="IT" <?php if($search_in_area=="IT") { echo "selected"; } ?>>Italy</option>
                                                                                                                    <option value="LV" <?php if($search_in_area=="LV") { echo "selected"; } ?>>Latvia</option>
                                                                                                                    <option value="LT" <?php if($search_in_area=="LT") { echo "selected"; } ?>>Lithuania</option>
                                                                                                                    <option value="LU" <?php if($search_in_area=="LU") { echo "selected"; } ?>>Luxembourg</option>
                                                                                                                    <option value="MT" <?php if($search_in_area=="MT") { echo "selected"; } ?>>Malta</option>
                                                                                                                    <option value="NL" <?php if($search_in_area=="NL") { echo "selected"; } ?>>Netherlands</option>
                                                                                                                    <option value="NO" <?php if($search_in_area=="NO") { echo "selected"; } ?>>Norway</option>
                                                                                                                    <option value="PL" <?php if($search_in_area=="PL") { echo "selected"; } ?>>Poland</option>
                                                                                                                    <option value="PT" <?php if($search_in_area=="PT") { echo "selected"; } ?>>Portugal</option>
                                                                                                                    <option value="RO" <?php if($search_in_area=="RO") { echo "selected"; } ?>>Romania</option>
                                                                                                                    <option value="SK" <?php if($search_in_area=="SK") { echo "selected"; } ?>>Slovakia</option>
                                                                                                                    <option value="SL" <?php if($search_in_area=="SL") { echo "selected"; } ?>>Slovenia</option>
                                                                                                                    <option value="ES" <?php if($search_in_area=="ES") { echo "selected"; } ?>>Spain</option>
                                                                                                                    <option value="SE" <?php if($search_in_area=="SE") { echo "selected"; } ?>>Sweden</option>
                                                                                                                    <option value="SW" <?php if($search_in_area=="SW") { echo "selected"; } ?>>Switzerland</option>
                                                                                                                    <option value="BR" <?php if($search_in_area=="BR") { echo "selected"; } ?>>United Kingdom</option>
                                                                                                                    <option value="US" <?php if($search_in_area=="US") { echo "selected"; } ?>>United States</option>
                                                                                                                     
                                                                                                                    
                                                                                                                    

                                                                                                            </select>
                                                                                                    </div>
                                                                                                    <label class="amount-label">Contract amount:</label>
                                                                                                    <div>
                                                                                                            <select name="advSearch[search_in_amount]" id="search_in_amount" class="demoInputBox">
                                                                                                                    <option value="">Select:</option>
                                                                                                                    <option value="1" <?php if($search_in_amount=="1") { echo "selected"; } ?>> <2K </option>
                                                                                                                    <option value="2" <?php if($search_in_amount=="2") { echo "selected"; } ?>> >2Κ <2M </option>
                                                                                                                    <option value="3" <?php if($search_in_amount=="3") { echo "selected"; } ?>> >2M <2B </option>
                                                                                                                    <option value="4" <?php if($search_in_amount=="4") { echo "selected"; } ?>> >2B </option>

                                                                                                            </select>
                                                                                                    </div>
                                                                                                      <div>
                                                                                             <div> <input type="submit" name="Go" class="btnSearch"  value="Search" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest2"  method="post" accept-charset="UTF-8" >
                                                                                                 
                                                                                             </div> 
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