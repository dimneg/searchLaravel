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
									@if ($isdirector == 2) 
                    <li><a id="tab0" class="left active" href="#0a" data-toggle="tab">{{ __('lang.companies') }}  ({{ __('lang.advancedSearchVat')}})</a></li>
                    <li><a id="tab1" class="left" href="#1a" data-toggle="tab">{{ __('lang.companies') }} </a></li>
                    <li><a id="tab2" class="right" href="#2a" data-toggle="tab">{{ __('lang.managers_directors') }} </a></li>
									@elseif ($isdirector == 1) 
                    <li><a id="tab0" class="left" href="#0a" data-toggle="tab">{{ __('lang.companies') }}  ({{ __('lang.advancedSearchVat')}})</a></li>
										<li><a id="tab1" class="left" href="#1a" data-toggle="tab">{{ __('lang.companies') }} </a></li>
										<li><a id="tab2" class="right active" href="#2a" data-toggle="tab">{{ __('lang.managers_directors') }} </a></li>
									@else
                    <li><a id="tab0" class="left" href="#0a" data-toggle="tab">{{ __('lang.companies') }}  ({{ __('lang.advancedSearchVat')}})</a></li>
										<li><a id="tab1" class="left active" href="#1a" data-toggle="tab">{{ __('lang.companies') }}</a></li>
										<li><a id="tab2" class="right" href="#2a" data-toggle="tab">{{ __('lang.managers_directors') }}</a></li>
									@endif
								</ul>

								<div class="tab-content clearfix">
                   @if ($isdirector == 2)
                    <div class="tab-pane fade show active" id="0a">
                  @else 
                    <div class="tab-pane fade" id="0a">                      
                  @endif                      
                    <div class="search">
                      <form method="post" action="{{ route('home') }}/{{ $lang }}/pro" id="searchFormGemh">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div style="margin:20px 0px; display:inline-block; width:100%;">
                          <input type="text" id="searchKey" name="searchKey" value="{{ $varKeyword }}" class="searchText" placeholder='{{ __('lang.advancedSearchPlaceholder_gemh_vat_only') }}'>
                          <input type="hidden" name="isdirector" value="2">
                          <input type="submit" value='{{ __('lang.advancedSearchPlaceholderDatatables') }}' class="searchSubmit">
                          <div class="error" style="float:left; margin-top:5px;">{{ __('lang.field_required') }}</div>
                        </div>                      
                      </form>    
                      <form method="post" action="{{ route('home') }}/{{ $lang }}/search" id="searchFormGEMH2">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <input type="hidden" name="isdirector" value="2">
                      </form>            
                    </div>
                    <div class="searchCloud">
                  
                  @foreach ($lastSearched as $item)
                    @if(substr($item->sbu_vatid,0,7)=="company" ||  substr($item->sbu_vatid,0,6)=="person")
                    <a href="{{ route('home') }}/{{ $lang }}/{{ $item->sbu_vatid }}/basic?s=1" class="cloudlink">{{ $item->sbu_title }}</a>
                    @endif
                  @endforeach
                </div>  
                <div style="text-align: left;">
                      <br><img src="/images/slb.png" width="22"> Aν βιάζεστε και είστε σίγουροι για τον ΑΦΜ που ψάχνετε, τότε εδώ είναι το κατάλληλο σημείο. Θα οδηγηθείτε αμέσως στο προφίλ της επιχείρησης.
                    </div>  
                  </div>
									@if ($isdirector == 3) 
										<div class="tab-pane fade show active" id="1a">
									@else 
										<div class="tab-pane fade" id="1a">											
									@endif
										<div class="search">
										@if($adv=="adv")	<form method="post" action="{{ route('home') }}/{{ $lang }}/search/adv" id="searchFormCompanies">
                    @else             <form method="post" action="{{ route('home') }}/{{ $lang }}/search" id="searchFormCompanies">
                    @endif
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
												<div style="margin:20px 0px; display:inline-block; width:100%;">
													<input type="text" id="searchKey" name="searchKey" value="{{ $varKeyword }}" class="searchText" placeholder='{{ __('lang.advancedSearchPlaceholder') }}'>
                                                                                                        <input type="hidden" name="isdirector" value="3">
													<input type="submit" value='{{ __('lang.advancedSearchPlaceholderDatatables') }}' class="searchSubmit">
													<div class="error" style="float:left; margin-top:5px;">{{ __('lang.field_required') }}</div>
												</div>
                        
											<div style="width:100%;">  
                  @if(isset($adv) && $isdirector==3)  @if($adv=='adv')                     
                      @if(isset($returnsearch["search"]))
                        <table onclick="cosr1('search',0)" id="purs" class="btn-primary fuse-ripple-ready text-auto" title="searchterm" data-toggle="modal" style="margin-left: 2px; float:left; border-radius: 5px; border: 8px solid black; border-color: #642D90; background-color: #bfbfbf; font-size:75%; height: 2.5rem; line-height: 1.2rem;">&nbsp;                         
                            <tr>
                              <th style="height:12px; color: #000000;">Κλειδί:</th>
                              <th rowspan="2" style="height:12px; text-align: center; vertical-align: middle;"><img src="{{route('home')}}/images/x.png" width=20 height=20></th>
                            </tr>
                            <tr>
                              <td style="height:8px; color: #000000;"> {{ $returnsearch["search"] }} </td>
                            </tr>
                          </table>
                       <!--  </span>&nbsp; -->
                        @endif
                         
                        @if(isset($returnsearch["search"]))                          
                        <table onclick="cosr1('status',0)" id="purs" class="btn-primary fuse-ripple-ready text-auto" title="searchterm" data-toggle="modal" style="margin-left: 2px; float:left; border-radius: 5px; border: 8px solid black; border-color: #642D90; background-color: #bfbfbf; font-size:75%; height: 2.5rem; line-height: 1.2rem;">&nbsp;
                            <tr>
                              <th style="height:12px; color: #000000;"> Κατάσταση:</th>
                              <th rowspan="2" style="height:12px; text-align: center; vertical-align: middle;"><img src="{{route('home')}}/images/x.png" width=20 height=20></th>
                            </tr>
                            <tr>
                               <td style="height:8px; color: #000000;"> @if(isset($returnsearch["status"])) @if($returnsearch["status"][0]=="Active")  Ενεργή @else Όλες @endif @else Όλες @endif </td>
                            </tr>
                        </table>
                        @endif
                        
                        @if(isset($returnsearch["org"])) 
                         @foreach($returnsearch["org"] as $k=>$v) 
                        <table onclick="cosr1('org','{{$v}}')" id="purs" class="btn-primary fuse-ripple-ready text-auto" title="searchterm" data-toggle="modal" style="margin-left: 2px; float:left; border-radius: 5px; border: 8px solid black; border-color: #642D90; background-color: #bfbfbf; font-size:75%; height: 2.5rem; line-height: 1.2rem;">&nbsp;
                            <tr>
                              <th style="height:12px; color: #000000;"> Εταιρικός Τύπος: </th>
                              <th rowspan="2" style="height:12px; text-align: center; vertical-align: middle;"><img src="{{route('home')}}/images/x.png" width=20 height=20></th>
                            </tr>
                            <tr>
                               <td style="height:8px; color: #000000;"> {{__('lang.advancedSearchCritOrgtype_'.$v) }} </td>
                            </tr>
                          </table>
                         @endforeach
                        @endif
                        
                         @if(isset($returnsearch["cpa"])) 
                         @foreach($returnsearch["cpa"] as $k=>$v) 
                        <table onclick="cosr1('cpa',0)" id="purs" class="btn-primary fuse-ripple-ready text-auto" title="searchterm" data-toggle="modal" style="margin-left: 2px; float:left; border-radius: 5px; border: 8px solid black; border-color: #642D90; background-color: #bfbfbf; font-size:75%; height: 2.5rem; line-height: 1.2rem;">&nbsp;
                            <tr>
                              <th style="height:12px; color: #000000;"> 
                        <?php
                                                                                                                                           $cpa_l1_Array =  getShowCpa_l1(config('search.DbPath'),config('search.cpa_l1_CouchDB'),config('search.couchUser'), config('search.couchPass')); 
                                                                                                                                           if (isset($cpa_l1_Array ['rows'] )){
                                                                                                                                                foreach ($cpa_l1_Array ['rows'] as $cpa_l1){ if (isset($cpa_l1['doc']['title'])){ if($cpa_l1['doc']['code']==$v) { ?>  Δραστηριότητα (ΚΑΔ):</th><th rowspan="2" style="height:12px; text-align: center; vertical-align: middle;"><img src="{{route('home')}}/images/x.png" width=20 height=20></th>
                            </tr>
                            <tr>
                               <td style="height:8px; color: #000000;">
                                                                                                                                                  <?= mb_substr($cpa_l1['doc']['title'], 0,75, "utf-8")?></td></tr></table>
                                                                                                                                           <?php } }
                                                                                                                                           } 
                                                                                                                                           }
                                                                                                                                           
                                                                                                                                            
                                                                                                                                            

                                                                                                                                        ?>
                         @endforeach
                        @endif
                        
                        @if(isset($returnsearch["chamber"])) 
                         @foreach($returnsearch["chamber"] as $k=>$v) 
                          <table onclick="cosr1('chamber',0)" id="purs" class="btn-primary fuse-ripple-ready text-auto" title="searchterm" data-toggle="modal" style="margin-left: 2px; float:left; border-radius: 5px; border: 8px solid black; border-color: #642D90; background-color: #bfbfbf; font-size:75%; height: 2.5rem; line-height: 1.2rem;">&nbsp;
                            <tr>
                              <th style="height:12px; color: #000000;"> Επιμελητήριο: </th>
                              <th rowspan="2" style="height:12px; text-align: center; vertical-align: middle;"><img src="{{route('home')}}/images/x.png" width=20 height=20></th>
                            </tr>
                            <tr>
                               <td style="height:8px; color: #000000;">{{ $v }}</td>
                            </tr>
                          </table>
                         @endforeach
                        @endif                        

                        @if(isset($returnsearch["address"])) 
                         @foreach($returnsearch["address"] as $k=>$v) 
                         <table onclick="cosr1('address',0)" id="purs" class="btn-primary fuse-ripple-ready text-auto" title="searchterm" data-toggle="modal" style="margin-left: 2px; float:left; border-radius: 5px; border: 8px solid black; border-color: #642D90; background-color: #bfbfbf; font-size:75%; height: 2.5rem; line-height: 1.2rem;">&nbsp;
                            <tr>
                              <th style="height:12px; color: #000000;">Αναζήτηση σε:</th>
                              <th rowspan="2" style="height:12px; text-align: center; vertical-align: middle;"><img src="{{route('home')}}/images/x.png" width=20 height=20></th>
                            </tr>
                            <tr>
                               <td style="height:8px; color: #000000;"> @if($v=="address") Διεύθυνση @elseif($v=="basic") Μόνο βασικά στοιχεία @elseif($v=="tk") Τ.Κ. @elseif($v=="region") Περιοχή @endif </td>
                            </tr>
                          </table>
                         @endforeach
                        @endif
                      </div>
                

 <script type="text/javascript">
  function url_redirect(options){
    // console.log(options);
    // alert(options);

       var $form = $("<form />");
       
       $form.attr("action",options.url);
       $form.attr("method",options.method);
       
       $form.append('<input type="hidden" name="isdirector" value="3" />');

       for (var data in options.data) {
         if(data=="activeStatus[]" || data=="selectChamber[]" || data=="selectCPA[]") {
             $form.append('<select type="hidden" id="activeStatus"  name="'+data+'" tabindex="1"><option value="'+options.data[data]+'">'+options.data[data]+'</option></select>');
         } else {
          if(data=="tmp") {
            for (var data2 in options.data.tmp) {
               $form.append('<input type="hidden" name="'+data2+'" value="'+options.data.tmp[data2]+'" />');
            }
          } else $form.append('<input type="hidden" name="'+data+'" value="'+options.data[data]+'" />');
           }
       }
        
       $("body").append($form);
       $form.submit();
  }

  function cosr1(dt,dt2) {
    switch(dt) {
      case "search":
                    $(function(){
                    /*jquery statements */      
                    url_redirect({url: "{{ route('home') }}/{{ $lang }}/search/{{$adv}}",
                      method: "post",
                      data: {"_token":"{{ csrf_token() }}", "searchKey":"{{$returnsearch["search"]}}", @if(isset($returnsearch["org"])) @foreach($returnsearch["org"] as $k=>$v) "selectOrgtype{{$v}}":"{{$v}}", @endforeach @endif @if(isset($returnsearch["status"])) "activeStatus[]": "{{$returnsearch["status"][0]}}", @endif @if(isset($returnsearch["chamber"])) "selectChamber[]": "{{$returnsearch["chamber"][0]}}", @endif @if(isset($returnsearch["cpa"])) "selectCPA[]": "{{$returnsearch["cpa"][0]}}", @endif @if(isset($returnsearch["address"])) "searchAddress[]": "{{$returnsearch["address"][0]}}", @endif }
                     });
                   }); 
                   break;
       case "status":
                    $(function(){
                    /*jquery statements */      
                    url_redirect({url: "{{ route('home') }}/{{ $lang }}/search/{{$adv}}",
                      method: "post",
                      data: {"_token":"{{ csrf_token() }}", "searchKey":"{{$returnsearch["search"]}}", @if(isset($returnsearch["org"])) @foreach($returnsearch["org"] as $k=>$v) "selectOrgtype{{$v}}":"{{$v}}", @endforeach @endif @if(isset($returnsearch["status"])) "activeStatus[]": "Όλα", @endif @if(isset($returnsearch["chamber"])) "selectChamber[]": "{{$returnsearch["chamber"][0]}}", @endif @if(isset($returnsearch["cpa"])) "selectCPA[]": "{{$returnsearch["cpa"][0]}}", @endif @if(isset($returnsearch["address"])) "searchAddress[]": "{{$returnsearch["address"][0]}}", @endif}
                     });
                   }); 
                   break;
         case "org":
                    $(function(){
                    /*jquery statements */  
                   var tmp={};
                    @if(isset($returnsearch["org"])) 
                      @foreach($returnsearch["org"] as $k=>$v)                             
                        if("{{$v}}"!=dt2) { 
                           tmp["selectOrgtype{{$v}}"]="{{$v}}";                       
                        } 
                      @endforeach 
                    @endif 
                    if(tmp==null) tmp["selectOrgtypeUKN"]="UKN"; 
                    
                    url_redirect({url: "{{ route('home') }}/{{ $lang }}/search/{{$adv}}",
                      method: "post",
                      data: {"_token":"{{ csrf_token() }}", "searchKey":"{{$returnsearch["search"]}}", tmp, @if(isset($returnsearch["status"])) "activeStatus[]": "{{$returnsearch["status"][0]}}", @endif @if(isset($returnsearch["chamber"])) "selectChamber[]": "{{$returnsearch["chamber"][0]}}", @endif @if(isset($returnsearch["cpa"])) "selectCPA[]": "{{$returnsearch["cpa"][0]}}", @endif @if(isset($returnsearch["address"])) "searchAddress[]": "{{$returnsearch["address"][0]}}", @endif}
                     });
                   }); 
                   break;
       case "chamber":
                    $(function(){
                    /*jquery statements */      
                    url_redirect({url: "{{ route('home') }}/{{ $lang }}/search/{{$adv}}",
                      method: "post",
                      data: {"_token":"{{ csrf_token() }}", "searchKey":"{{$returnsearch["search"]}}", @if(isset($returnsearch["org"])) @foreach($returnsearch["org"] as $k=>$v) "selectOrgtype{{$v}}":"{{$v}}", @endforeach @endif @if(isset($returnsearch["status"])) "activeStatus[]": "{{$returnsearch["status"][0]}}", @endif "selectChamber[]": "Όλα", @if(isset($returnsearch["cpa"])) "selectCPA[]": "{{$returnsearch["cpa"][0]}}", @endif @if(isset($returnsearch["address"])) "searchAddress[]": "{{$returnsearch["address"][0]}}", @endif}
                     });
                   }); 
                   break;
      case "cpa":
                    $(function(){
                    /*jquery statements */      
                    url_redirect({url: "{{ route('home') }}/{{ $lang }}/search/{{$adv}}",
                      method: "post",
                      data: {"_token":"{{ csrf_token() }}", "searchKey":"{{$returnsearch["search"]}}", @if(isset($returnsearch["org"])) @foreach($returnsearch["org"] as $k=>$v) "selectOrgtype{{$v}}":"{{$v}}", @endforeach @endif @if(isset($returnsearch["status"])) "activeStatus[]": "{{$returnsearch["status"][0]}}", @endif  "selectCPA[]": "Όλα", @if(isset($returnsearch["chamber"])) "selectChamber[]": "{{$returnsearch["chamber"][0]}}", @endif @if(isset($returnsearch["address"])) "searchAddress[]": "{{$returnsearch["address"][0]}}", @endif }
                     });
                   }); 
                   break;   
       case "address":
                    $(function(){
                    /*jquery statements */      
                    url_redirect({url: "{{ route('home') }}/{{ $lang }}/search/{{$adv}}",
                      method: "post",
                      data: {"_token":"{{ csrf_token() }}", "searchKey":"{{$returnsearch["search"]}}", @if(isset($returnsearch["org"])) @foreach($returnsearch["org"] as $k=>$v) "selectOrgtype{{$v}}":"{{$v}}", @endforeach @endif @if(isset($returnsearch["status"])) "activeStatus[]": "{{$returnsearch["status"][0]}}", @endif @if(isset($returnsearch["chamber"])) "selectChamber[]": "{{$returnsearch["chamber"][0]}}", @endif @if(isset($returnsearch["cpa"])) "selectCPA[]": "{{$returnsearch["cpa"][0]}}", @endif "searchAddress[]": "basic", }
                     });
                   }); 
                   break;                       
      default:
                   break;
    }
   }

</script>
 @endif @endif                       
                  @if(isset($adv)) @if($adv=="adv")  <div class="advanced_search"  onClick="showHideAdvanceSearch()" style="margin-top: 90px;">{{ __('lang.advancedSearchBtn') }}</div> @endif @endif




												
                                                                                              <!--  <span class="advanced_search" style="display:none;" onClick="showHideAdvanceSearch()">{{ __('lang.advancedSearchBtn') }}</span> -->
                                                                                                 <div id="advanced-search-box" style="text-align: left; <?php if(empty($advance_search_submit)) { ?>display:none;<?php } ?>"> <!--<style="display:none;"-->

                                                                                                   <form id="selectOrgtype" name="selectOrgtype" method="get" action="{{ route('home') }}/{{ $lang }}/search/adv">
                                                                                                    

                                                                                                    <label><span style="font-weight: bold;">{{ __('lang.advancedSearchCritOrgtype') }}:</span></label>&nbsp;<br>
                                                                                                    <table id="orgs" style="width:100%;">
                                                                                                    <tr>
                                                                                                      <td><br>
                                                                                                        <input type="checkbox" name="selectOrgtypeFR" id="selectOrgtypeFR" value="FR"> 
                                                                                                        <label class="form-check-label" for="selectOrgtypeFR" ></label>    
                                                                                                      </td>
                                                                                                      <td>       
                                                                                                        <label class="form-check-label" for="selectOrgtypeFR" >{{__('lang.advancedSearchCritOrgtype_FR') }}&nbsp;&nbsp;</label>
                                                                                                      </td>
                                                                                                      <td width="30"><br>
                                                                                                      </td>
                                                                                                      <td><br>
                                                                                                        <input type="checkbox" name="selectOrgtypePLC" id="selectOrgtypePLC" value="PLC"> 
                                                                                                        <label class="form-check-label" for="selectOrgtypePLC" ></label>    
                                                                                                      </td>
                                                                                                      <td>       
                                                                                                        <label class="form-check-label" for="selectOrgtypePLC">&nbsp;{{__('lang.advancedSearchCritOrgtype_PLC') }}</label>
                                                                                                      </td>
                                                                                                      <td width="30"><br>
                                                                                                      </td>
                                                                                                      <td><br>
                                                                                                        <input type="checkbox" name="selectOrgtypeGP" id="selectOrgtypeGP" value="GP"> 
                                                                                                        <label class="form-check-label" for="selectOrgtypeGP" ></label>    
                                                                                                      </td>
                                                                                                      <td>       
                                                                                                        <label class="form-check-label" for="selectOrgtypeGP">&nbsp;{{__('lang.advancedSearchCritOrgtype_GP') }}</label>
                                                                                                      </td>   
                                                                                                    </tr>

                                                                                                    <tr>
                                                                                                      <td><br>
                                                                                                        <input type="checkbox" name="selectOrgtypeLP" id="selectOrgtypeLP" value="LP"> 
                                                                                                        <label class="form-check-label" for="selectOrgtypeLP" ></label>    
                                                                                                      </td>
                                                                                                      <td>       
                                                                                                        <label class="form-check-label" for="selectOrgtypeLP" >{{__('lang.advancedSearchCritOrgtype_LP') }}&nbsp;&nbsp;</label>
                                                                                                      </td>
                                                                                                      <td width="30"><br>
                                                                                                      </td>
                                                                                                      <td><br>
                                                                                                        <input type="checkbox" name="selectOrgtypeLTD" id="selectOrgtypeLTD" value="LTD"> 
                                                                                                        <label class="form-check-label" for="selectOrgtypeLTD" ></label>    
                                                                                                      </td>
                                                                                                      <td>       
                                                                                                        <label class="form-check-label" for="selectOrgtypeLTD">&nbsp;{{__('lang.advancedSearchCritOrgtype_LTD') }}</label>
                                                                                                      </td>
                                                                                                      <td width="30"><br>
                                                                                                      </td>
                                                                                                      <td><br>
                                                                                                        <input type="checkbox" name="selectOrgtypePC" id="selectOrgtypePC" value="PC"> 
                                                                                                        <label class="form-check-label" for="selectOrgtypePC" ></label>    
                                                                                                      </td>
                                                                                                      <td>       
                                                                                                        <label class="form-check-label" for="selectOrgtypePC">&nbsp;{{__('lang.advancedSearchCritOrgtype_PC') }}</label>
                                                                                                      </td>
                                                                                                    </tr>

                                                                                                     <tr>
                                                                                                      <td><br>
                                                                                                        <input type="checkbox" name="selectOrgtypeUKN" id="selectOrgtypeUKN" value="UKN"> 
                                                                                                        <label id="uncall" class="form-check-label" for="selectOrgtypeUKN" ></label>    
                                                                                                      </td>
                                                                                                      <td>       
                                                                                                        <label id="uncall1" class="form-check-label" for="selectOrgtypeUKN" >{{__('lang.advancedSearchCritOrgtype_UKN') }}&nbsp;&nbsp;</label>

                                                                                                        <script>
                                                                                                          
                                                                                                          
  $('#selectOrgtypeUKN').click(function() {
    var checked = $('#selectOrgtypeUKN').prop('checked');
    if(!checked) {
    $('#orgs').find('input:checkbox').prop('checked', false);
    $('#orgs').find('input:checkbox').prop('disabled', true);
    document.getElementById("selectOrgtypeUKN").disabled = false;
    document.getElementById("selectOrgtypeUKN").checked = true;
    } else {
    $('#orgs').find('input:checkbox').prop('checked', false);
    $('#orgs').find('input:checkbox').prop('disabled', false);
    document.getElementById("selectOrgtypeUKN").disabled = false;
    document.getElementById("selectOrgtypeUKN").checked = false;
    }
  });

   $('#uncall').click(function() {
    var checked = $('#selectOrgtypeUKN').prop('checked');
    if(!checked) {
    $('#orgs').find('input:checkbox').prop('checked', false);
    $('#orgs').find('input:checkbox').prop('disabled', true);
    document.getElementById("selectOrgtypeUKN").disabled = false;
    document.getElementById("selectOrgtypeUKN").checked = true;
    } else {
    $('#orgs').find('input:checkbox').prop('checked', false);
    $('#orgs').find('input:checkbox').prop('disabled', false);
    document.getElementById("selectOrgtypeUKN").disabled = false;
    document.getElementById("selectOrgtypeUKN").checked = false;
    }
  });

   $('#uncall1').click(function() {
   
    var checked = $('#selectOrgtypeUKN').prop('checked');
    if(!checked) {
    $('#orgs').find('input:checkbox').prop('checked', false);
    $('#orgs').find('input:checkbox').prop('disabled', true);
    document.getElementById("selectOrgtypeUKN").disabled = false;
    document.getElementById("selectOrgtypeUKN").checked = true;
    } else {
    $('#orgs').find('input:checkbox').prop('checked', false);
    $('#orgs').find('input:checkbox').prop('disabled', false);
    document.getElementById("selectOrgtypeUKN").disabled = false;
    document.getElementById("selectOrgtypeUKN").checked = false;
    }
  });


                                                                                                        </script>
                                                                                                      </td>
                                                                                                      <td width="30"><br>
                                                                                                      </td>
                                                                                                      <td><br>
                                                                                                        
                                                                                                      </td>
                                                                                                      <td>       
                                                                                                        
                                                                                                      </td>
                                                                                                      <td width="30"><br>
                                                                                                      </td>
                                                                                                      <td><br>
                                                                                                          
                                                                                                      </td>
                                                                                                      <td>       
                                                                                                       
                                                                                                      </td>
                                                                                                    </tr>
                                                                                              </table>

                                                                                                   

                                                                                                                  
                                                                                                                 <!--   <select id="selectOrgtype"  name="selectOrgtype[]" multiple="multiple" size="6" tabindex="1">
                                                                                                                      <option value="FR">{{ __('lang.advancedSearchCritOrgtype_FR') }}</option>
                                                                                                                      <option value="PLC*">{{ __('lang.advancedSearchCritOrgtype_PLC') }}</option>
                                                                                                                      <option value="GP">{{ __('lang.advancedSearchCritOrgtype_GP') }}</option>
                                                                                                                      <option value="LP">{{ __('lang.advancedSearchCritOrgtype_LP') }}</option>
                                                                                                                      <option value="LTD*">{{ __('lang.advancedSearchCritOrgtype_LTD') }}</option>
                                                                                                                      <option value="PC*">{{ __('lang.advancedSearchCritOrgtype_PC') }}</option>
                                                                                                                      <option value=" ">{{ __('lang.advancedSearchCritOrgtype_UKN') }}</option>
                                                                                                                   </select> -->
                                                                                                         </form> 
                                                                                                   <br><br>
                                                                               


                                                                                                   
                                                                                                                           <label>Κατάσταση<!--{{ __('lang.advancedSearchCritStatus') }}--></label>&nbsp;
                                                                                                                                
                                                                                                                                    <select id="activeStatus"  name="activeStatus[]" tabindex="1">
                                                                                                                                        <option value="Όλα">Όλες</option>
                                                                                                                                        <option value="Active">{{ __('lang.advancedSearchCritStatus_Active') }}</option>
                                                                                                                                        
                                                                                                                                     </select>
                                                                                                         
                                                                                                    <br><br>  

                                                                                                   <label>{{ __('lang.advancedSearchCritChamber') }}</label>&nbsp;
                                                                                                                                     <select style="width:70%;" id="selectChamber"  name="selectChamber[]" tabindex="1">      
                                                                                                                                    
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

                                                                                                    <br><br>  

                                                                                                   <label>{{ __('lang.advancedSearchCritCPA') }}</label>&nbsp;
                                                                                                                                    <select style="width:70%;" id="selectCPA"  name="selectCPA[]" tabindex="1">
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
                                                                                                                                   
                                                                                                    <br><br>  

                                                                                                    <label>Αναζήτηση σε</label>&nbsp;
                                                                                                                                   <select id="searchAddress"  name="searchAddress[]" tabindex="1">
                                                                                                                                       <option value="basic">Μόνο βασικά στοιχεία</option>
                                                                                                                                        <option value="address">Διεύθυνση</option>
                                                                                                                                         <option value="tk">Τ.Κ.</option>
                                                                                                                                         <option value="region">Περιοχή</option>
                                                                                                                                       
                                                                                                                                     </select>
                                                                                                                                                                             

                                                                                                     <table>
                                                                                                       <tr>
                                                                                                         <td>
                                                                                                                  <!--<label>Αναζήτηση με Διεύθυνση</label>-->
                                                                                                          </td>    
                                                                                                          <!-- <td>
                                                                                                               <form method="post" action="{{ route('home') }}/{{ $lang }}/search" id="searchFormCompaniesAddresses">
                                                                                                                   <input name="_token" type="hidden" value="">
                                                                                                                     <div style="margin:0px 0px; align:left; display:inline-block; width:70%;">
                                                                                                                          <input type="text" id="searchKey" name="searchKey" value=" " class="searchText" placeholder='Αναζητήστε με διεύθυνση'>
                                                                                                                          <input type="hidden" name="" value="">
                                                                                                                          <input type="submit" value='{{ __('lang.advancedSearchPlaceholderDatatables') }}' class="searchSubmit">
                                                                                                                          <div class="error" style="float:left; margin-top:5px;">{{ __('lang.field_required') }}</div>
                                                                                                                     </div>
                                                                                                                   </form> 
                                                                                                            </td>-->                            
                                                                                                       </tr> 
                                                                                                     
                                                                                                     </table>   
                                                                                                    
                                                                                              <div>
                                                                                         
                                                                                            </div>
                                                                                            </div>
											</form>				
										</div>	

                      <div class="search_results" style="margin-top: 40px;">
                      {!! $table_str !!}
                    </div>	
                    <div style="text-align: left;"> 

                      <br><img src="/images/slb.png" width="22"> Αν δεν γνωρίζετε τον ΑΦΜ της επιχείρησης τότε πληκτρολογήστε την επωνυμία ή τον αριθμό ΓΕΜΗ.   
                      <br><img src="/images/slb.png" width="22"> Αποφεύγετε να εισάγετε λέξεις με λιγότερα από 5 γράμματα.
                      <br><img src="/images/slb.png" width="22"> Στις ατομικές επιχειρήσεις, επιστρέφουμε ορθότερα αποτελέσματα όταν γράψετε πρώτα το επίθετο και μετά το όνομα.
                      <br><img src="/images/slb.png" width="22"> Αν δεν τα καταφέρουμε και τότε, δοκιμάστε να εισάγετε μόνο το επίθετο και μετά στο κουτάκι δεξιά από τον φακό να εισάγετε το μικρό όνομα.
                    </div>								
									</div>
                 
</div>
									@if ($isdirector == 1)
										<div class="tab-pane fade show active" id="2a">
									@else 
										<div class="tab-pane fade" id="2a">											
									@endif											
										<div class="search">
											@if($adv=="adv") <form method="post" action="{{ route('home') }}/{{ $lang }}/search/adv" id="searchFormDirectors">
                      @else            <form method="post" action="{{ route('home') }}/{{ $lang }}/search" id="searchFormDirectors">
                      @endif
												<input name="_token" type="hidden" value="{{ csrf_token() }}">
												<div style="margin:20px 0px; display:inline-block; width:100%;">
													<input type="text" id="searchKey" name="searchKey" value="{{ $varKeyword }}" class="searchText" placeholder='{{ __('lang.advancedSearchPlaceholder_managers_directors') }}'>
													<input type="hidden" name="isdirector" value="1">
													<input type="submit" value='{{ __('lang.advancedSearchPlaceholderDatatables') }}' class="searchSubmit">
													<div class="error" style="float:left; margin-top:5px;">{{ __('lang.field_required') }}</div>
												</div>											
											</form>								
										</div>
                      <div class="search_results" style="margin-top: 40px;">
                      {!! $table_str1 !!}
                      </div>
                      <div style="text-align: left;"> 

                      <br><img src="/images/slb.png" width="22"> Αν δεν γνωρίζετε τον ΑΦΜ του μετόχου τότε πληκτρολογήστε το ονοματεπώνυμό του.   
                      <br><img src="/images/slb.png" width="22"> Αποφεύγετε να εισάγετε λέξεις με λιγότερα από 5 γράμματα.
                      <br><img src="/images/slb.png" width="22"> Επιστρέφουμε ορθότερα αποτελέσματα όταν γράψετε πρώτα το επίθετο και μετά το όνομα.
                      <br><img src="/images/slb.png" width="22"> Αν δεν τα καταφέρουμε και τότε, δοκιμάστε να εισάγετε μόνο το επίθετο και μετά στο κουτάκι δεξιά από τον φακό να εισάγετε το μικρό όνομα.
                    </div>  
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
																				"lengthMenu": "{{ __('lang.advancedSearchResults_lengthMenu') }}",
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
							</div>

							
                        </div>
                    </div>
				</div>		
			</div>
		</div>
	</div>


	@include('sidebar')

</div>
<script type="text/javascript">
            
 </script>
<script type="text/javascript">
                            $('#searchResults').DataTable({
                                "dom": '<"top"if>rt<"bottom"lp><"clear">',
                                "aaSorting": [[ 1, "desc" ]],
                                "responsive": true,                           
                                "searching": true,
                                "lengthChange": true,                           
                                "paging": true,
                                "pagingType": "simple",
                                "info": true,
                                //"ordering": true,
                                "language": {   "sSearch": "<i class='icon icon-magnify'></i>", 
                                        "searchPlaceholder": "{{ __('lang.searchLabel') }}",
                                        "lengthMenu": "{{ __('lang.records_per_page1') }} _MENU_ {{ __('lang.records_per_page2') }}",
                                        "paginate": { "previous": "<", "next": ">" },
                                        "info": "_START_ - _END_ {{ __('lang.of') }} _TOTAL_",
                                        "sInfoEmpty": "_START_ - _END_ {{ __('lang.of') }} _TOTAL_",
                                        "emptyTable": "{{ __('lang.empty_table') }}",
                                        "decimal": ".",
                                              "thousands": "."                          
                                      }, 
                                "aoColumnDefs": [{ "bVisible": false, "aTargets": [ 1 ] }] 


                            // "aaSorting": [[ 1, "desc" ]],

                            //     "responsive": true,                 
                            //     "lengthChange": true,
                            //     "paging": true,
                            //     "pagingType": "simple",
                            //     "info": true,
                                
                            //     //"ordering": true,
                            //     "language": {   "sSearch": "<i class='icon icon-magnify'></i>", 
                            //             searchPlaceholder: "{{ __('lang.advancedSearchPlaceholderDatatables') }}",
                            //             "info": "{{ __('lang.records_per_page1') }} _MENU_ {{ __('lang.records_per_page2') }}",
                            //             "paginate": { "previous": "<", "next": ">" },
                            //             "lengthMenu": "_START_ - _END_ από _TOTAL_",
                            //             "sInfoEmpty": "0 - _END_ από _TOTAL_",
                            //             "emptyTable": "{{ __('lang.empty_table') }}",
                            //             "decimal": ".",
                            //                   "thousands": ""                         
                            //           },
                                
                            //     "aoColumnDefs": [{ "bVisible": false, "aTargets": [ 1 ] }]
                            });                         
 </script>
	
<script>
	$("#tab1").click(function(){
	    //alert("Tab 1 clicked.");
	    // $( "#searchFormCompanies" ).submit();
     //        $( "#activeStatus" ).submit();
     //        $( "#selectOrgtype" ).submit();
     //        $( "#selectCPA" ).submit();
     var element1 = document.getElementById("0a");
    element1.classList.remove("active");
    var element2 = document.getElementById("2a");
    element2.classList.remove("active");
	});

	$("#tab2").click(function(){
	    //alert("Tab 2 clicked.");
	    //$( "#searchFormDirectors" ).submit();
      var element1 = document.getElementById("0a");
    element1.classList.remove("active");
    var element2 = document.getElementById("1a");
    element2.classList.remove("active");
  
	});

  $("#tab0").click(function(){
      //alert("Tab 2 clicked.");
      // $( "#searchFormGEMH2" ).submit();
      var element1 = document.getElementById("1a");
    element1.classList.remove("active");
    var element2 = document.getElementById("2a");
    element2.classList.remove("active");
  });

  
</script>
<script>
    function showHideAdvanceSearch() {
        if(document.getElementById("advanced-search-box").style.display=="none") {
            document.getElementById("advanced-search-box").style.display = "block";
	   // document.getElementById("advance_search_submit").value= "1";
            // document.getElementById("activeStatus").value= "1";
             //document.getElementById("selectOrgtype").value= "1";
             //document.getElementById("selectChamber").value= "1";
             //document.getElementById("selectCPA").value= "1";
              //document.getElementById("searchAddress").value= "1";
            }
            else {
		document.getElementById("advanced-search-box").style.display = "none";
		//document.getElementById("activeStatus").value= "" ;
		//document.getElementById("advance_search_submit").value= "";
               // document.getElementById("selectOrgtype").value= "";
                //document.getElementById("selectChamber").value= "";
                //document.getElementById("selectCPA").value= "";
                //document.getElementById("searchAddress").value= "";
	    }
   }
</script>

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