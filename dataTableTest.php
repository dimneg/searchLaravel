
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
 
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
 
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<div class="">
		<table id="example" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>postalCode</th>
                <th>region</th>
				
               
            </tr>
        </thead>
 
        <tfoot>
            <tr>
               <th>postalCode</th>
                <th>region</th>
				
                
            </tr>
        </tfoot>
    </table>
    </div>


<?php
 $tabledata=[[]];

 $postalCodeArray = getShowPostalCode('http://83.212.86.158:5984/','lb_postal_codes','dimneg','fujintua0)');
 $cnt = 0;
 if (isset($postalCodeArray['rows'] )){
     foreach ($postalCodeArray['rows'] as $key => $row) {
          $tabledata[$cnt] ['postalCode']=$row['doc']['postCode']; 
          $tabledata[$cnt] ['region']=$row['doc']['county']; 
          $cnt++;
     }
 }
 else {
     $tabledata[0] ['postalCode']='9999';
     $tabledata[0] ['region']='test';
 }
#https://stackoverflow.com/questions/29440812/how-to-send-json-encoded-php-array-to-datatables-on-same-page
 #https://stackoverflow.com/questions/16980477/how-to-select-multiple-checkbox-in-jquery-datatable-with-pagination
function getShowPostalCode($DbPath,$Db,$couchUser, $couchPass ){
    
   
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
    #print_r($json);
    return $json;


}
?>
<script>
 var tableData = <?php echo json_encode($tabledata);  ?>;  
$( document ).ready(function() {
$('#example').dataTable({
				 "bProcessing": true,
                 "aaData": tableData,     
				 "aoColumns": [
						{ mData: 'postalCode' } ,
                        { mData: 'region' }
                ]
        });   
});
</script>