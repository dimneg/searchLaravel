<?php

namespace App;

use Config;

class collectData {
   function getAll($solrPath,$solrCore,$field, $varKeyword,$operand,$personsUrl){
       #global $Limit;
       #$this->prepareResults($DbPath,"elod_diaugeia_hybrids","buyerVatIdOrName","by_buyerDtls_VatIdOrName",$LuceneOperand,25,"score",$varKeyword,$couchUser,$couchPass);
       
							
      
       #$this->prepareResultsSolr($solrPath,$solrCore,$field,$varKeyword,$operand,$personsUrl );       
       $this->prepareResultsSolr($solrPath,$solrCore,$field,$varKeyword,$operand,$personsUrl );     
      
       
	
       #
       #
 }
   function getAllCompaniesCouch($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$companiesUrl,$term,$orgtypescouchDB){
       global $Limit;
       return $this->prepareResultsCouch($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,25,"score",$varKeyword,$couchUser,$couchPass,$companiesUrl,$term,$orgtypescouchDB);
   }
   function getAllPersonsCouch($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$Url,$term){
       global $Limit;
       return $this->prepareResultsCouchPersons($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,25,"score",$varKeyword,$couchUser,$couchPass,$Url,$term);
   }
   
   function getAllCompaniesCouchOpj($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$Url,$term){
       global $Limit;
       return $this->prepareResultsCouchOpj($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$Url,$term);       		  
   }

   function prepareResultsCouch($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$lbUrl,$term, $orgtypescouchDB) {
       $couchUserPwd = $couchUser.':'.$couchPass;
       $ch = curl_init();
       $url = $DbPath.$lucenePath.$Db."/_design/".$DesignDoc."/".$Index."?q=".$term.":".$varKeyword.$Wc."&limit:".$Limit."&sort:".$Sort;
       echo $url.PHP_EOL;
   
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
       global $prefix; 
       $Results = array();
       //global $Results;
       //config('search.Results');
       global $Lang;
      
        
       $json = json_decode($response,true);
       if(isset ($json['rows'])) {
           foreach($json['rows'] as $r){     
               global $Boost;
                $Boost = 1.2;
                    switch ($Wc) { //boost step 1
                    case "";{	            
                       $r['score'] *=$Boost;
                       break; 
                    }
                    case "*"; {
                       $r['score'] *=1;
                        break; 

                    }
                    case "~0.75"; {
                       $r['score'] *=1;
                       break; 
                    }
                }
                
                if (isset ($json['rows'])  ){ //rules to show or hide results
                    if (isset($r['fields']['orgType'])){
                        $orgtypeKey = str_replace('/', '_', $r['fields']['orgType']);
                        $orgtypeKey = str_replace('/', '_',  $orgtypeKey);
                        $orgtypeFront = $this->getOrgtypeDesc($DbPath, $orgtypescouchDB, $couchUserPwd, $orgtypeKey);
                    }
                    else {
                        $orgtypeFront = '';
                    }
                    
                    
                    $newdata =  array (
                        'db' => $Db,
                        'name' => (isset($r['fields']['name'])) ? $r['fields']['name'] : null ,            
                        'vat' => $r['fields']['term'][0],
                        'gemhNumber' => (isset($r['fields']['gemhnumber'])) ?$r['fields']['gemhnumber'] : null , 
                        'cpaTitle' => (isset($r['fields']['cpaTitle'])) ?$r['fields']['cpaTitle'] : null , 
                        'orgType' => (isset($r['fields']['orgType'])) ?$r['fields']['orgType'] : null , 
                        'orgTypeFront' => $orgtypeFront , 
                        'chamber' => (isset($r['fields']['chamber'])) ? $r['fields']['chamber'] : null ,  
                        'gemhDate' => (isset($r['fields']['gemhdate'])) ? $r['fields']['gemhdate'] : null ,  
                        'address'=>(isset($r['fields']['address']) ) ? $r['fields']['address'] : null ,
                        'pc'=>(isset($r['fields']['pc']) ) ? $r['fields']['pc'] : null ,   
                        'city'=>(isset($r['fields']['city']) ) ? $r['fields']['city'] : null ,
                        'link' =>   $lbUrl.$r['fields']['link'].'/basic?s=1',
                        'score' =>  $r['score'],
                        'id' => $r['id']
                    );
                   
                }
                $arrayElements = count($Results);
                if  ($arrayElements <= 1000 && isset($newdata)){
                      $key = $this->searchForId($newdata['vat'], $Results,'vat');
                      if ($key === NULL){

                          $Results[] = $newdata;      //insert whole record                              
                          //Config::set('session.driver', $Results);
                      }
                      
                  }
               
           }
       }
       
       return $Results;
   }

   function prepareResultsCouchPersons($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$lbUrl,$term) {
       $couchUserPwd = $couchUser.':'.$couchPass;
       $ch = curl_init();
       $url = $DbPath.$Db."/_design/".$DesignDoc."/".$Index."?q=".$term.":".$varKeyword.$Wc."&limit:".$Limit."&sort:".$Sort;
       #echo $url.PHP_EOL;
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
       global $prefix ; 
       //global $Results;
       $Results = array();
       global $Lang;   
        
       $json = json_decode($response,true);
       if(isset ($json['rows'])) {
           foreach($json['rows'] as $r) {     
               global $Boost;
                $Boost = 1.2;
                    switch ($Wc) { //boost step 1
                    case "";{	            
                       $r['score'] *=$Boost;
                       break; 
                    }
                    case "*"; {
                       $r['score'] *=1;
                        break; 

                    }
                    case "~0.75"; {
                       $r['score'] *=1;
                       break; 
                    }
                }
                
                if (isset ($json['rows'])  ){ //rules to show or hide results
                    if (isset($r['fields']['isCompany'])){
                       if ($r['fields']['isCompany']=='1'){
                           $intUrl = 'http://dashboard.linkedbusiness.gr/gr/company/';
                       } 
                       else {
                           $intUrl = 'http://dashboard.linkedbusiness.gr/gr/person/';
                       }
                    }
                    else {
                        $intUrl='';
                    }
                    $newdata =  array (
                        'db' => $Db,
                        'name' => (isset($r['fields']['name'])) ? $r['fields']['name'] : null ,            
                        'vat' =>  (isset($r['fields']['vat'])) ? $r['fields']['vat'] : null ,  
                        'adt' =>  (isset($r['fields']['adt'])) ? $r['fields']['adt'] : null ,  
                        'isCompany' =>  (isset($r['fields']['isCompany'])) ? $r['fields']['isCompany'] : null ,                      
                        'address'=>(isset($r['fields']['address']) ) ? $r['fields']['address'] : null ,
                        'pc'=>(isset($r['fields']['pc']) ) ? $r['fields']['pc'] : null ,   
                        'city'=>(isset($r['fields']['city']) ) ? $r['fields']['city'] : null ,
                        'managementCnt'=>isset($r['fields']['managementCnt']) ? $r['fields']['managementCnt'] : '',
                        'ownershipCnt'=>isset($r['fields']['ownershipCnt']) ? $r['fields']['ownershipCnt'] : '',
                        's_mgmtCompanyVat'=>isset($r['fields']['s_mgmtCompanyVat']) ? $r['fields']['s_mgmtCompanyVat'] : '',
                        's_mgmtCompanyName'=>isset($r['fields']['s_mgmtCompanyName']) ? $r['fields']['s_mgmtCompanyName'] : '',
                        's_mgmtCompanyLink'=>isset($r['fields']['s_mgmtCompanyLink']) ? $r['fields']['s_mgmtCompanyLink'] : '',
                        's_ownCompanyVat'=>isset($r['fields']['s_ownCompanyVat']) ? $r['fields']['s_ownCompanyVat'] : '',
                        's_ownCompanyName'=>isset($r['fields']['s_ownCompanyName']) ? $r['fields']['s_ownCompanyName'] : '',
                        's_ownCompanyLink'=>isset($r['fields']['s_ownCompanyLink']) ? $r['fields']['s_ownCompanyLink'] : '',
                        #'link' =>  $intUrl.$r['fields']['link'].'/basic?s=1',
                        'link' =>  isset ($r['fields']['link']) ? $intUrl.$r['fields']['link'].'/basic?s=1' : '',
                        'score' =>  $r['score'],
                        'id' => $r['id']
                    );
                   
                }
                $arrayElements = count($Results);
                if  ($arrayElements <= 1000 && isset($newdata)){
                     if ($Db=='lb_mp' ||$Db=='lb_mp_2' ){
                         $Results[] = $newdata;  
                     }
                     else {
                         $key = $this->searchForId($newdata['vat'], $Results,'vat'); 
                         if ($key === NULL ){
                              $Results[] = $newdata; 
                         }
                     }
                     # $key = $this->searchForId($newdata['vat'], $Results,'vat');
                      #if ($key === NULL || $Db=='lb_mp'){
                              //insert whole record
                       #    $Results[] = $newdata; 
                      #}
                      
                  }               
           }
       }
       
       return $Results;
   }
    
   

    
   function prepareResultsCouchOpj($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$lbUrl,$term){
       $couchUserPwd = $couchUser.':'.$couchPass;
       $ch = curl_init();
       $url = $DbPath.$lucenePath.$Db."/_design/".$DesignDoc."/".$Index."?q=".$term.":".$varKeyword.$Wc."&limit:".$Limit."&sort:".$Sort;
       echo $url.PHP_EOL;
   
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
       global $prefix; 
       $Results = array();
       //global $Results;
       //config('search.Results');
       global $Lang;
       
       $json = json_decode($response,true);
       
       if(isset ($json['rows'])) {
           foreach($json['rows'] as $r){     
               global $Boost;
                $Boost = 1.2;
                    switch ($Wc) { //boost step 1
                    case "";{	            
                       $r['score'] *=$Boost;
                       break; 
                    }
                    case "*"; {
                       $r['score'] *=1;
                        break; 

                    }
                    case "~0.75"; {
                       $r['score'] *=1;
                       break; 
                    }
                }
                
                if (isset ($json['rows'])  ){ //rules to show or hide results
                    if (isset($r['fields']['orgType'])){
                        $orgtypeKey = str_replace('/', '_', $r['fields']['orgType']);
                        $orgtypeKey = str_replace('/', '_',  $orgtypeKey);
                        $orgtypeFront = $this->getOrgtypeDesc($DbPath, $orgtypescouchDB, $couchUserPwd, $orgtypeKey);
                    }
                    else {
                        $orgtypeFront = '';
                    }
                    
                    
                    $newdata =  array (
                        'db' => $Db,
                        'name' => (isset($r['fields']['term'][1])) ? $r['fields']['term'][1] : null ,            
                        'vat' => $r['fields']['term'][0],
                        'gemhNumber' => (isset($r['fields']['gemhnumber'])) ?$r['fields']['gemhnumber'] : null , 
                        'cpaTitle' => (isset($r['fields']['cpaTitle'])) ?$r['fields']['cpaTitle'] : null , 
                        'orgType' => (isset($r['fields']['orgType'])) ?$r['fields']['orgType'] : null , 
                        'orgTypeFront' => $orgtypeFront , 
                        'chamber' => (isset($r['fields']['chamber'])) ? $r['fields']['chamber'] : null ,  
                        'gemhDate' => (isset($r['fields']['gemhdate'])) ? $r['fields']['gemhdate'] : null ,  
                        'address'=>(isset($r['fields']['address']) ) ? $r['fields']['address'] : null ,
                        'pc'=>(isset($r['fields']['pc']) ) ? $r['fields']['pc'] : null ,   
                        'city'=>(isset($r['fields']['city']) ) ? $r['fields']['city'] : null ,
                        'link' =>    (isset($r['fields']['link']) ) ? $r['fields']['link'] : null ,
                        'score' =>  $r['score'],
                        'id' => $r['id']
                    );
                   
                }
                $arrayElements = count($Results);
                if  ($arrayElements <= 1000 && isset($newdata)){
                      $key = $this->searchForId($newdata['vat'], $Results,'vat');
                      if ($key === NULL){

                          $Results[] = $newdata;      //insert whole record                              
                          //Config::set('session.driver', $Results);
                      }
                      
                  }
               
           }
       }
       return $Results;
   }
    
   function defineSource($db, $field, $status){
       #echo 'defining source: '.$db.' '.$field.' '.$status.PHP_EOL;
      # 0-> clean 1-> ok 2-> do nothing
       $matchDb = $status;
       
       if (($db == 'elod_buyers' || $db == 'elod_sellers' ) && $field == 'dataKhmdhs'  &&  $matchDb == 0){
          $matchDb = 1;   # echo 'khmdhs matched';
          return  $matchDb;
       }
       if (($db == 'elod_diaugeia_buyers' || $db == 'elod_diaugeia_sellers' ) && $field == 'dataDiaugeia' &&  $matchDb == 0 ){
           $matchDb =  1;
           return  $matchDb;
       }
       
       if (($db == 'elod_australia_buyers' || $db == 'elod_australia_sellers' ) && $field == 'dataAustralia'  &&  $matchDb == 0){
            $matchDb =  1;
            return  $matchDb;
       }       
       if ($db == 'elod_espa_beneficiaries'  && $field == 'dataEspa' &&  $matchDb == 0 ){
            $matchDb =  1;
            return  $matchDb;
       }
       if ($db == 'yds_big_sellers'  && $field == 'dataTed' &&  $matchDb == 0){
           $matchDb =  1;
           return  $matchDb;
       }
       
       if (($db == 'elod_main_orgv4_all' || $db == 'elod_main_orgv4_fr' ) && $field == 'dataGemh' &&  $matchDb == 0){
            $matchDb =  1;
            return  $matchDb;
       } 
      
       return  $matchDb;
      
   } 
   
   function defineProperty($db,$field, $status){
       # $propertiesArray = ['ΦΟΡΕΑΣ','ΑΝΑΔΟΧΟΣ','ΔΙΚΑΙΟΥΧΟΣ'];
       $matchProperty = $status;
       if ($db == 'elod_diaugeia_buyers' && $matchProperty == 0){
          if ($field == 'buyer'){
               $matchProperty = 1;
               return $matchProperty;
          }
       }
       if ($db == 'elod_buyers' && $matchProperty == 0){
          if ($field == 'buyer'){
               $matchProperty = 1;
               return $matchProperty;
          }
       }
       if ($db == 'elod_australia_buyers' && $matchProperty == 0){
          if ($field == 'buyer'){
               $matchProperty = 1;
               return $matchProperty;
          }
       }
       if ($db == 'elod_diaugeia_sellers' ){
           if ($field == 'seller' && $matchProperty == 0){
               $matchProperty = 1;
               return $matchProperty;
           }
       }
       if ($db == 'elod_sellers' ){
           if ($field == 'seller' && $matchProperty == 0){
               $matchProperty = 1;
               return $matchProperty;
           }
       }
       if ($db == 'elod_australia_sellers' ){
           if ($field == 'seller' && $matchProperty == 0){
               $matchProperty = 1;
               return $matchProperty;
           }
       }
       if ($db == 'yds_big_sellers' ){
           if ($field == 'seller' && $matchProperty == 0){
               $matchProperty = 1;
               return $matchProperty;
           }
       }
      return $matchProperty;
   }
   function searchForId($id, $array, $index) { 
    foreach ($array as $key => $val) {       
            if ( $val[$index] === $id ) {
                return $key;
                        
            }
                //else echo 'not equal';
     }
        return NULL;
  } 
   function checkAFM($afm) {
   
        if (!preg_match('/^(EL){0,1}[0-9]{9}$/i', $afm))
            return false;
        if (strlen($afm) > 9)
            $afm = substr($afm, 2);

        $remainder = 0;
        $sum = 0;

        for ($nn = 2, $k = 7, $sum = 0; $k >= 0; $k--, $nn += $nn)
            $sum += $nn * ($afm[$k]);
        $remainder = $sum % 11;

        return ($remainder == 10) ? $afm[8] == '0'
                                  : $afm[8] == $remainder;
    }
    
   function getAltNamesSolr($solrPath,$solrCore,$vat){
       $ch = curl_init();
       $url = $solrPath.$solrCore."/select?indent=on&q=id:".$vat."&wt=json";
       $url = str_replace(' ','%20',$url);	
      # echo $url.PHP_EOL;
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_USERPWD, 'dimneg:dim1978');			
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json; charset=utf-8',
	'Accept: */*'
         ));
       
       $response = curl_exec($ch); 
                
       $json = json_decode($response,true);
       curl_close($ch);	
       if (isset ($json['response']['docs'][0]['alt_names']) ){
           # return implode(', ', $json['response']['alt_names']);
           #echo implode(', ', $json['response']['alt_names']);
          # print_r($json['response']['docs'][0]['alt_names']);
            return implode(', ', $json['response']['docs'][0]['alt_names']);
       }
       #return $json;
       
   } 
   function getCorporationSolr($solrPath,$solrCore,$vat){
       $return = 0;
       $ch = curl_init();
       $url = $solrPath.$solrCore."/select?indent=on&q=db_id:".$vat."&wt=json";
       $url = str_replace(' ','%20',$url);
       #echo $url.PHP_EOL;
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_USERPWD, 'dimneg:dim1978');			
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json; charset=utf-8',
	'Accept: */*'
         ));
       $response = curl_exec($ch);                 
       $json = json_decode($response,true);
       #echo $json['response']['docs'][0]['core'][0].PHP_EOL;
       if (isset ($json['response']['docs'][0]['core']) ){
           /*if ($json['response']['docs'][0]['core'][0] == 1){
               return 'Oracle Corporation';
           }
           else {
               return '';
           }*/
           $return = $json['response']['docs'][0]['core'][0];
           
               
       } 
       curl_close($ch);	
       return $return;
   }
   function getCorporationDetailsSolr($solrPath,$solrCore,$corpId){
       $cnt = 0;
       $ch = curl_init();
       $url = $solrPath.$solrCore."/select?indent=on&q=core:".$corpId."&rows=20&wt=json";
       $url = str_replace(' ','%20',$url);
       #echo $url.PHP_EOL;
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_USERPWD, 'dimneg:dim1978');			
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json; charset=utf-8',
	'Accept: */*'
       ));
       $response = curl_exec($ch);                 
       $json = json_decode($response,true);
       $response = [];
       $responseArray = [
           [
               
           ]];
       curl_close($ch);
       if (isset ($json['response']['docs'][0])){
           foreach ($json['response']['docs'] as $key => $value) {
               $responseArray[$cnt]['db_id'] = $value['db_id'][0];
               $responseArray[$cnt]['name'] = $value['name'][0];
               $responseArray[$cnt]['country'] = $value['country'][0];
               $responseArray[$cnt]['uniqueShow'] = mb_convert_case($value['name'][0].$value['country'][0], MB_CASE_UPPER, "UTF-8");
               #$response[] = '['.$value['db_id'][0];
               #$response[] = $value['name'][0];
               #$response[] = $value['country'][0].']';
            $cnt++;
               
               
           }
           return  [$json['response']['docs'][0]['coreName'][0],$responseArray];
           
           #return [$json['response']['docs'][0]['coreName'][0],implode(', ', $response)];
          
       }
               
   }
   
 
   function getTedDataRDF($vat,$sparqlServer){
      
       $ch = curl_init();
       $url = $sparqlServer."/sparql/?default-graph-uri=http%3A%2F%2Fyourdatastories.eu%2Fvirtual&query=SELECT+%28sum%28xsd%3Adecimal%28%3FcurrencyValue%29%29+as+%3FsumOfAmounts%29%0D%0AFROM+<http%3A%2F%2Fyourdatastories.eu%2FTEDGreece>%0D%0AWHERE+%7B%0D%0A%3Fcontract+elod%3Abuyer+<http%3A%2F%2Flinkedeconomy.org%2Fresource%2FOrganization%2F090025586>+%3B%0D%0Apc%3AagreedPrice+%3FagreedPrice+.%0D%0A%3FagreedPrice+gr%3AhasCurrencyValue+%3FcurrencyValue+.%0D%0A%7D&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on";
       #echo $url.PHP_EOL;
       curl_setopt_array($ch, array(
           CURLOPT_PORT => "8890",
           CURLOPT_URL => $url ,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => "",
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 600,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => "GET",
           CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache",
	    "postman-token: b79e291a-0eef-efe9-3d63-e067a3535154",
            'Content-type: application/json; charset=utf-8',
	    'Accept: */*'
	  ),
          ));
       $response = curl_exec($ch);
       $err = curl_error($ch);
       $json = json_decode($response,true);
       curl_close($ch);
       if (isset ($json['results']['bindings'][0]['sumOfAmounts']) ){
            return $json['results']['bindings'][0] ['sumOfAmounts'];
       }
   }
   
   function transliterate($word){
       $word = mb_convert_case($word, MB_CASE_UPPER, "UTF-8");
       $word = $this->cleanSpecialChar($word);
       
       $word = str_replace("Α", "A",$word);
       $word = str_replace("Β", "B",$word);
       $word = str_replace("Γ", "G",$word);
       $word = str_replace("Δ", "D",$word);
       $word = str_replace("Ε", "E",$word);
       $word = str_replace("Ζ", "Z",$word);
       $word = str_replace("Η", "I",$word);
       
       $word = str_replace("Θ", "TH",$word);
       $word = str_replace("Ι", "I",$word);
       $word = str_replace("Κ", "K",$word);
       $word = str_replace("Λ", "L",$word);
       $word = str_replace("Μ", "M",$word);
       
       $word = str_replace("Ν", "N",$word);
       $word = str_replace("Ξ", "X",$word);
       $word = str_replace("Ο", "O",$word);
       $word = str_replace("Π", "P",$word);
       $word = str_replace("Ρ", "R",$word);
       
       $word = str_replace("Σ", "S",$word);
       $word = str_replace("Τ", "T",$word);
       $word = str_replace("Υ", "Y",$word);
       $word = str_replace("Φ", "F",$word);
       
       $word = str_replace("Χ", "X",$word);
       $word = str_replace("Ψ", "PS",$word);
       $word = str_replace("Ω", "O",$word);
       
       return $word;
   }
   
   function cleanSpecialChar($word){
       $word = str_replace("Ά", "Α",$word);
       $word = str_replace("Έ", "Ε",$word);
       $word = str_replace("Ή", "Η",$word);
       $word = str_replace("Ί", "Ι",$word);
       
       $word = str_replace("Ύ", "Υ",$word);
       $word = str_replace("Ό", "Ο",$word);
       $word = str_replace("Ώ", "Ω",$word);
       $word = str_replace("Ϋ", "Υ",$word);
       $word = str_replace("Ϊ", "Ι",$word);
       return $word;
   }
   
   function defineCountry($db){
       switch ($db) {
           case 'elod_diaugeia_buyers':
               $country = 'GR';
               break;
           case 'elod_diaugeia_sellers':
               $country = 'GR';
               break;
           case 'elod_buyers':
               $country = 'GR';
               break;
           case 'elod_sellers':
               $country = 'GR';
               break;
           case 'elod_espa_beneficiaries':
               $country = 'GR';
               break;
           case 'elod_main_orgv4_all':
               $country = 'GR';
               break;
           case 'elod_main_orgv4_fr':
               $country = 'GR';
               break;
           case 'elod_australia_buyers':
               $country = 'AU';
               break;
           case 'elod_australia_sellers':
               $country = 'AU';
               break;
           case 'yds_big_sellers':
               $country = 'TED';
               break;

           default:
               break;
       }
       return $country;
   }
   
   function unaccent($string) {    
        $string =  str_replace('Ά','Α',$string);
        $string =  str_replace('Έ','Ε',$string);
        $string =  str_replace('Ί','Ι',$string);
        $string =  str_replace('Ή','Η',$string);
        $string =  str_replace('Ύ','Υ',$string);
        $string =  str_replace('Ό','Ο',$string);
        $string =  str_replace('Ώ','Ω',$string);
        return $string;
   }
   
   function getOrgtypeDesc($DbPath,$Db,$couchUserPwd,$orgtypekey  ){
       $ch = curl_init();
       $url = $DbPath.$Db.'/'.$orgtypekey ;
       #echo $url.PHP_EOL;
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
       if(isset ($json['orgtype_front'])) {
           return $json['orgtype_front'];
       }
       else{ 
           return '';
       }
       
   }
}
