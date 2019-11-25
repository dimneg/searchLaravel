@extends('layouts.app_nofooter')

@section('content')

<div id="wrapper">

	<iframe src="http://linkedbusiness.eu/en/advancedsearch" id='searchBox_advanced' frameborder="0"></iframe>

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
	
@endsection	