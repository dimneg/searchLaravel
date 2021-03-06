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
										<li><a id="tab1" class="left" href="#1a" data-toggle="tab">Κατάλογος</a></li>
										<li><a id="tab2" class="right active" href="#2a" data-toggle="tab"></a></li>
									@else
										<li><a id="tab1" class="left active" href="#1a" data-toggle="tab">Κατάλογος</a></li>
										<li><a id="tab2" class="right" href="#2a" data-toggle="tab"></a></li>
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
													<input type="submit" value='{{ __('lang.advancedSearchPlaceholderDatatables') }}' class="searchSubmit">
													<div class="error" style="float:left; margin-top:5px;">{{ __('lang.field_required') }}</div>
												</div>
												<span class="advanced_search" onClick="showHideAdvanceSearch()">{{ __('lang.advancedSearchBtn') }}</span>
                                                                                                 <div id="advanced-search-box" <?php if(empty($advance_search_submit)) { ?>style="display:none;"<?php } ?>>
                                                                                                   
                                                                                                     <table>
                                                                                                         <tr>
                                                                                                              <td>
                                                                                                                <form id="selectOrgtype" name="selectOrgtype" method="get" action="{{ route('home') }}/{{ $lang }}/advancedsearchtest3">
                                                                                                                     <table width="225" border="1">
                                                                                                                       <tr>
                                                                                                                         <td><label>{{ __('lang.advancedSearchCritOrgtype') }}</label>&nbsp;</td>
                                                                                                                         <td>
                                                                                                                             <select id="selectOrgtype"  name="selectOrgtype[]" size="6" multiple="multiple" tabindex="1">
                                                                                                                                <option value="FR">{{ __('lang.advancedSearchCritOrgtype_FR') }}</option>
                                                                                                                                <option value="PLC*">{{ __('lang.advancedSearchCritOrgtype_PLC') }}</option>
                                                                                                                                <option value="GP">{{ __('lang.advancedSearchCritOrgtype_GP') }}</option>
                                                                                                                                <option value="LP">{{ __('lang.advancedSearchCritOrgtype_LP') }}</option>
                                                                                                                                <option value="LTD*">{{ __('lang.advancedSearchCritOrgtype_LTD') }}</option>
                                                                                                                                <option value="PC*">{{ __('lang.advancedSearchCritOrgtype_PC') }}</option>
                                                                                                                                <option value=" ">{{ __('lang.advancedSearchCritOrgtype_UKN') }}</option>
                                                                                                                             </select>
                                                                                                                         </td>
                                                                                                                       </tr>
                                                                                                                      
                                                                                                                     </table>
                                                                                                                   </form> 

                                                                                                               </td>
                                                                                                                <td>
                                                                                                                    <table>...</table>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                                                                                                             
                                                                                                                        <table width="225" border="1">
                                                                                                                            <tr>
                                                                                                                                <td><label>{{ __('lang.advancedSearchCritStatus') }}</label>&nbsp;</td>
                                                                                                                                <td>
                                                                                                                                    <select id="activeStatus"  name="activeStatus[]" size="6" multiple="multiple"  tabindex="1">
                                                                                                                                        <option value="Active">{{ __('lang.advancedSearchCritStatus_Active') }}</option>
                                                                                                                                        <option value=" "></option>
                                                                                                                                     </select>
                                                                                                                                 </td>
                                                                                                                                
                                                                                                                            </tr>
                                                                                                                            
                                                                                                                        </table>       
                                                                                                                       
                                                                                                              </td>
                                                                                                          </tr>
                                                                                                          
                                                                                                          <tr><table>...</table></tr>
                                                                                                          
                                                                                                           <tr>
                                                                                                              
                                                                                                                <td>
                                                                                                                    <table width="225" border="1">
                                                                                                                        <tr>
                                                                                                                            <td><label>{{ __('lang.advancedSearchCritChamber') }}</label>&nbsp;</td>
                                                                                                                               <td  size="3">
                                                                                                                                     <select id="selectChamber"  name="selectChamber[]" size="6" width ="10" multiple="multiple"  tabindex="1">      
                                                                                                                                    
                                                                                                                                       <?php
                                                                                                                                           $chambersArray =  getShowChambers(config('search.DbPath'),config('search.chamberscouchDB'),config('search.couchUser'), config('search.couchPass')); 
                                                                                                                                           if (isset($chambersArray['rows'] )){
                                                                                                                                                foreach ($chambersArray['rows'] as $chamber){ if (isset($chamber['doc']['chamber_gr'])){ ?>
                                                                                                                                                 <option value="<?= $chamber['doc']['chamber_gr']?>" ><?=  mb_substr($chamber['doc']['chamber_gr'], 0,75, "utf-8")?> </option>
                                                                                                                                           <?php } 
                                                                                                                                           } 
                                                                                                                                           }
                                                                                                                                           
                                                                                                                                            
                                                                                                                                            

                                                                                                                                        ?>
                                                                                                                                  </select>
                                                                                                                               </td>
                                                                                                                        </tr>
                                                                                                                     </table>
                                                                                                                    
                                                                                                               </td>
                                                                                                                </tr>
                                                                                                                 <tr><table>...</table></tr>
                                                                                                                <tr>
                                                                                                                 <td>
                                                                                                                                                                                                                  
                                                                                                                        <table width="10" border="1">
                                                                                                                            <tr>
                                                                                                                                <td  width ="10" ><label>Επιλογή ΚΑΔ</label>&nbsp;</td>
                                                                                                                                <td  width ="10" >
                                                                                                                                    <select id="selectCPA"  name="selectCPA[]" size="6" width ="10" multiple="multiple"  tabindex="1">
                                                                                                                                         <?php
                                                                                                                                           $cpa_l1_Array =  getShowCpa_l1(config('search.DbPath'),config('search.cpa_l1_CouchDB'),config('search.couchUser'), config('search.couchPass')); 
                                                                                                                                           if (isset($cpa_l1_Array ['rows'] )){
                                                                                                                                                foreach ($cpa_l1_Array ['rows'] as $cpa_l1){ if (isset($cpa_l1['doc']['title'])){ ?>
                                                                                                                                        <option value="<?= $cpa_l1['doc']['code']?>" ><?= mb_substr($cpa_l1['doc']['title'], 0,75, "utf-8")?> </option>
                                                                                                                                           <?php } 
                                                                                                                                           } 
                                                                                                                                           }
                                                                                                                                           
                                                                                                                                            
                                                                                                                                            

                                                                                                                                        ?>
                                                                                                                                     </select>
                                                                                                                                 </td>
                                                                                                                                
                                                                                                                            </tr>
                                                                                                                         </tr>    
                                                                                                                        </table>       
                                                                                                                      
                                                                                                                  
                                                                                                                 </td>  
                                                                                                         
                                                                                                    </tr> 
                                                                                                   </table>   
                                                                                                    
                                                                                              <div>
                                                                                         
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
											<form method="post" visible="false"  action="{{ route('home') }}/{{ $lang }}/advancedsearchtest3" id="searchFormDirectors">
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
            $( "#activeStatus" ).submit();
            $( "#selectOrgtype" ).submit();
            $( "#selectCPA" ).submit();
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
             document.getElementById("activeStatus").value= "1";
             document.getElementById("selectOrgtype").value= "1";
             document.getElementById("selectChamber").value= "1";
             document.getElementById("selectCPA").value= "1";
            }
            else {
		document.getElementById("advanced-search-box").style.display = "none";
		document.getElementById("activeStatus").value= "" 
		document.getElementById("advance_search_submit").value= "";
                document.getElementById("selectOrgtype").value= "";
                document.getElementById("selectChamber").value= "";
                document.getElementById("selectCPA").value= "";
	    }
   }
</script>
<footer>
</footer>
<?php
function getShowChambers($DbPath,$Db,$couchUser, $couchPass ){
    $couchUserPwd = $couchUser.':'.$couchPass;
    $ch = curl_init();
    $url = $DbPath.$Db.'/'.'_all_docs?include_docs=true';                                                                                                                                                
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $couchUserPwd );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-type: application/json; charset=utf-8',
    'Accept: */*'
    ));

    $response = curl_exec($ch); 
    curl_close($ch);
    $json = json_decode($response,true);
    return $json;


}
function getShowCpa_l1($DbPath,$Db,$couchUser, $couchPass ){
    $couchUserPwd = $couchUser.':'.$couchPass;
    $ch = curl_init();
    $url = $DbPath.$Db.'/'.'_all_docs?include_docs=true';                                                                                                                                                
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $couchUserPwd );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-type: application/json; charset=utf-8',
    'Accept: */*'
    ));

    $response = curl_exec($ch); 
    curl_close($ch);
    $json = json_decode($response,true);
    return $json;


}

?>
@endsection	