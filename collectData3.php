<?php

namespace App;

use Config;


class collectData3 {
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
   
   function getAllCompaniesCouchOpj($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$Url,$term,$orgtypescouchDB,$chamberscouchDB,$advCriteria){
       global $Limit;
       return $this->prepareResultsCouchOpj($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$Url,$term,$orgtypescouchDB,$chamberscouchDB,$advCriteria);       		  
   }
   function getAllCorporationsCouchOpj($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$Url,$term,$orgtypescouchDB){
       global $Limit;
       return $this->prepareResultsCouchCorporationsOpj($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$Url,$term,$orgtypescouchDB);       		  
   }

   
   function prepareResultsCouchPersons($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$lbUrl,$term) {
       $couchUserPwd = $couchUser.':'.$couchPass;
       $ch = curl_init();
       $url = $DbPath.$lucenePath.$Db."/_design/".$DesignDoc."/".$Index."?q=".$term.":".$varKeyword.$Wc."&limit:".$Limit."&sort:".$Sort;
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
    
   

    
   function prepareResultsCouchOpj($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$lbUrl,$term,$orgtypescouchDB,$chamberscouchDB,$advCriteria){
       $couchUserPwd = $couchUser.':'.$couchPass;
       $ch = curl_init();
       $url = $DbPath.$lucenePath.$Db."/_design/".$DesignDoc."/".$Index."?q=".$term.":".$varKeyword.$Wc.$advCriteria."&limit:".$Limit."&sort:".$Sort;
       $this->createLogFileCall($url);
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
                    case "~0.80"; {
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
                    if (isset($r['fields']['chamber'])){
                        require_once 'keyWord.php';
                        $chamberKeyWord = new keyWord();
                        $chamberExactArray = $chamberKeyWord->prepareExactKeyword($r['fields']['chamber']); 
                        $chamberExact = str_replace('&', '', $chamberExactArray[3]);  
                        $chamber_en = $this->getChamberDescEng($DbPath,$lucenePath,$chamberscouchDB,'buyerVatIdOrName','by_buyerDtls_VatIdOrName',$Wc,1,$Sort,$chamberExact,$couchUser,$couchPass,$lbUrl,'chamber_gr',$orgtypescouchDB);
                    }
                    else {
                         $chamber_en = '';
                    }
                    $corporation_id = (isset($r['fields']['corporation_id'])) ? $r['fields']['corporation_id'] : null; 
                    
                    $country_code = (isset($r['fields']['country_code'])) ? $r['fields']['country_code'] : null ; 
                    $isTed = (isset($r['fields']['isTed'])) ? $r['fields']['isTed'] : null ;
                    
                    $newdata =  array (
                        'db' => $Db,
                        'name' => (isset($r['fields']['term'][1])) ? $r['fields']['term'][1] : null ,            
                        'vat' => $r['fields']['term'][0],
                        'name_eng' => (isset($r['fields']['name_eng'])) ? $r['fields']['name_eng'] : null ,  
                        'gemhNumber' => (isset($r['fields']['gemhnumber'])) ?$r['fields']['gemhnumber'] : null , 
                        'cpaTitle' => (isset($r['fields']['cpaTitle'])) ?$r['fields']['cpaTitle'] : null , 
                        'orgType' => (isset($r['fields']['orgType'])) ?$r['fields']['orgType'] : null , 
                        'orgTypeFront' => $orgtypeFront , 
                        'chamber' => (isset($r['fields']['chamber'])) ? $r['fields']['chamber'] : null ,  
                        'chamber_eng' => $chamber_en  , 
                        'gemhDate' => (isset($r['fields']['gemhdate'])) ? $r['fields']['gemhdate'] : null ,  
                        'status' => (isset($r['fields']['status'])) ? $r['fields']['status'] : null ,  
                        'address'=>(isset($r['fields']['address']) ) ? $r['fields']['address'] : null ,
                        'pc'=>(isset($r['fields']['pc']) ) ? $r['fields']['pc'] : null ,   
                        'city'=>(isset($r['fields']['city']) ) ? $r['fields']['city'] : null ,
                        'link' =>    (isset($r['fields']['link']) ) ? $lbUrl.$r['fields']['link'].'/basic?s=1' : null ,
                        #'link' =>   $lbUrl.$r['fields']['link'].'/basic?s=1',
                        'score' =>  $r['score'],
                        'id' => $r['id'],
                        'corporation_id' => $corporation_id,
                        'country_code' => $this->defineCountry($Db, $country_code),
                        
                        'dataNoGemh'=>  $this->defineSource($Db, 'dataNoGemh',0,$isTed),
                        'dataGemh'=>  $this->defineSource($Db, 'dataGemh',0,$isTed),
                        'dataTed'=>  $this->defineSource($Db, 'dataTed',0,$isTed),
                        'dataDiaugeia'=>  $this->defineSource($Db, 'dataDiaugeia',0,$isTed),
                        'dataKhmdhs'=>  $this->defineSource($Db, 'dataKhmdhs',0,$isTed),
                        'dataEspa'=> $this->defineSource($Db, 'dataEspa',0,$isTed),
                        'dataAustralia'=> $this->defineSource($Db, 'dataAustralia',0,$isTed),
                      
                        
                       
                        
                        
                       
                        ///////TED
                       'tedSumofAmounts' => (isset($r['fields']['total_amount']) ) ? $r['fields']['total_amount'] : 0 ,
                       'tedContracts' => (isset($r['fields']['contracts']) ) ? $r['fields']['contracts'] : 0,
                        
                        
                        ////diaugeia
                        'award0'=>(isset($r['fields']['awardAmount0']) ) ? $r['fields']['awardAmount0'] : 0 ,
                        'award1'=> (isset($r['fields']['awardAmount1']) ) ? $r['fields']['awardAmount1'] : 0 ,
                        'award2'=> (isset($r['fields']['awardAmount2']) ) ? $r['fields']['awardAmount2'] : 0 ,
                        'awardCnt0'=> (isset($r['fields']['awardCounter0']) ) ? $r['fields']['awardCounter0'] : 0 ,
                        'awardCnt1'=> (isset($r['fields']['awardCounter1']) ) ? $r['fields']['awardCounter1'] : 0 ,
                        'awardCnt2'=> (isset($r['fields']['awardCounter2']) ) ? $r['fields']['awardCounter2'] : 0 ,                    
                        'spend0'=> (isset($r['fields']['spendAmount0']) ) ? $r['fields']['spendAmount0'] : 0 ,
                        'spend1'=> (isset($r['fields']['spendAmount1']) ) ? $r['fields']['spendAmount1'] : 0 ,
                        'spend2'=> (isset($r['fields']['spendAmount2']) ) ? $r['fields']['spendAmount2'] : 0 ,
                        'spendCnt0'=>  (isset($r['fields']['spendCounter0']) ) ? $r['fields']['spendCounter0'] : 0 ,
                        'spendCnt1'=>  (isset($r['fields']['spendCounter1']) ) ? $r['fields']['spendCounter1'] :0 ,
                        'spendCnt2'=> (isset($r['fields']['spendCounter2']) ) ? $r['fields']['spendCounter2'] : 0 ,
                        'lastUpdate'=> (isset($r['fields']['lastUpdate']) ) ? $r['fields']['lastUpdate'] : null ,
                        
                        
                        //khmdhs
                        
                        'contractAmountPrev'=> (isset($r['fields']['contractsAmount0']) ) ? $r['fields']['contractsAmount0'] : null ,
                        'contractAmountCur'=> (isset($r['fields']['contractsAmount1']) ) ? $r['fields']['contractsAmount1'] : null ,                     
                        'paymentAmountPrev'=> (isset($r['fields']['paymentsAmount0']) ) ? $r['fields']['paymentsAmount0'] : null ,
                        'paymentAmountCur'=> (isset($r['fields']['paymentsAmount1']) ) ? $r['fields']['paymentsAmount1'] : null ,                      	  
                        'contractItemsNo'=> (isset($r['fields']['contractItemsNo']) ) ? $r['fields']['contractItemsNo'] : null ,
                        'paymentItemsNo'=>  (isset($r['fields']['paymentItemsNo']) ) ? $r['fields']['paymentItemsNo'] : null ,
                        'ks_lastUpdate'=> (isset($r['fields']['ks_lastUpdate']) ) ? $r['fields']['ks_lastUpdate'] : null ,
                        
                         ////espa
                        'SubsContractsAmount'=> (isset($r['fields']['SubsContractsAmount']) ) ? $r['fields']['SubsContractsAmount'] : null ,
                        'SubsPaymentsAmount'=>(isset($r['fields']['SubsPaymentsAmount']) ) ? $r['fields']['SubsPaymentsAmount'] : null ,	
                        'SubsContractsCounter'=>(isset($r['fields']['SubsContractsCounter']) ) ? $r['fields']['SubsContractsCounter'] : null ,
                        'SubsPaymentsCounter'=> (isset($r['fields']['SubsPaymentsCounter']) ) ? $r['fields']['SubsPaymentsCounter'] : null,  
                        'espa_lastUpdate'=> (isset($r['fields']['espa_lastUpdate']) ) ? $r['fields']['espa_lastUpdate'] : null ,
                      
                        //australia
                        'contractAmount0'=> (isset($r['fields']['contractAmount0']) ) ? $r['fields']['contractAmount0'] : null ,
                        'contractAmount1'=> (isset($r['fields']['contractAmount1']) ) ? $r['fields']['contractAmount1'] : null ,
                        'contractAmount2'=> (isset($r['fields']['contractAmount2']) ) ? $r['fields']['contractAmount2'] : null ,
                        'contractCounter0'=>(isset($r['fields']['contractCounter0']) ) ? $r['fields']['contractCounter0'] : null ,
                        'contractCounter1'=> (isset($r['fields']['contractCounter1']) ) ? $r['fields']['contractCounter1'] : null ,
                        'contractCounter2'=> (isset($r['fields']['contractCounter2']) ) ? $r['fields']['contractCounter2'] : null ,
                       
                        
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
   function prepareResultsCouchCorporationsOpj($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$varKeyword,$couchUser,$couchPass,$lbUrl,$term,$orgtypescouchDB){
       $couchUserPwd = $couchUser.':'.$couchPass;
       $ch = curl_init();
       $url = $DbPath.$lucenePath.$Db."/_design/".$DesignDoc."/".$Index."?q=".$term.":".$varKeyword.$Wc."&limit:".$Limit."&sort:".$Sort;
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
                    
                    $corporation_id = (isset($r['fields']['code'])) ? $r['fields']['code'] : '00' ; 
                    
                    $country_code = (isset($r['fields']['country_code'])) ? $r['fields']['country_code'] : null ; 
                    
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
                        'id' => $r['id'],
                        'corporation_id' =>  $corporation_id ,
                        'country_code' => $this->defineCountry($Db, $country_code),
                        'industry' =>(isset($r['fields']['industry']) ) ? $r['fields']['industry'] : null ,
                        'visible' =>(isset($r['fields']['visible']) ) ? $r['fields']['visible'] : null ,
                        
                       #'dataDiaugeia'=>  $this->defineSource($Db, 'dataDiaugeia',0),
                       #'dataKhmdhs'=>  $this->defineSource($Db, 'dataKhmdhs',0),
                       #'dataEspa'=> $this->defineSource($Db, 'dataEspa',0),
                       #'dataTed'=>  $this->defineSource($Db, 'dataTed',0),
                       #'dataGemh'=>  $this->defineSource($Db, 'dataGemh',0),
                       #'dataAustralia'=>$this->defineSource($Db, 'dataAustralia',0),
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
    
   function defineSource($db, $field, $status,$isTed){
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
       if ($db == 'yds_corporation_companies_v2'  && $field == 'dataTed' &&  $matchDb == 0 &&  $isTed == 1){
           $matchDb =  1;
           return  $matchDb;
       }
       
       if (($db == 'lb_fr' || $db == 'lb_companies'  ) && $field == 'dataGemh' &&  $matchDb == 0){
            $matchDb =  1;
            return  $matchDb;
       } 
       if (( $db == 'lb_no_gemh' ) && $field == 'dataNoGemh' &&  $matchDb == 0){
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
   function getCorporationCouch($solrPath,$solrCore,$vat){
       $return = 0;
       $ch = curl_init();
       $url = $solrPath.$solrCore."/select?indent=on&q=db_id:".$vat."&wt=json";
       $url = str_replace(' ','%20',$url);
       #echo $url.PHP_EOL;
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_USERPWD, '');			
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
   
   function defineCountry($db,$country_code){
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
           case 'lb_companies':
               $country = 'GR';
               break;
           case 'lb_fr':
               $country = 'GR';
               break;
           case 'lb_no_gemh':
               $country = 'GR';
               break;
           #case 'yds_corporation_companies_v2':
            #   $country = $country_code;
            #   break;

           default:
               $country = $country_code;
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
   
   function getChamberDescEng($DbPath,$lucenePath,$Db,$DesignDoc,$Index,$Wc,$Limit,$Sort,$chamber,$couchUser,$couchPass,$lbUrl,$term,$orgtypescouchDB){
       $couchUserPwd = $couchUser.':'.$couchPass;
       $ch = curl_init();
       #$url = $DbPath.$lucenePath.$Db.'/'.$chamber ;
       $url = $DbPath.$lucenePath.$Db."/_design/".$DesignDoc."/".$Index."?q=".$term.":".$chamber.$Wc."&limit:".$Limit."&sort:".$Sort;
       #$this->createLogFile($url);
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
       if(isset ($json['rows'][0]['fields']['chamber_en'])) { 
           return $json['rows'][0]['fields']['chamber_en']; 
       }
       else{ 
           return '';
       }
       
   }
   
   function createLogFile($url){
        #$settingsFile = '../gsis/gsisProps.txt';
        $settingsFile = '/home/negkas/searchLaravel/chamber.txt' ;
       
        $myfile = fopen($settingsFile, "w") or die("Unable to open file!");
        $txt = $url;
        fwrite($myfile, $txt);
        
        
        #$txt="Output:".gsisApi_pass.PHP_EOL; 
        #fwrite($myfile, $txt);
        fclose($myfile);

    }
    
    function createLogFileCall($url){
        #$settingsFile = '../gsis/gsisProps.txt';
        $settingsFile = '/home/negkas/searchLaravel/lastCall.txt' ;
       
        $myfile = fopen($settingsFile, "w") or die("Unable to open file!");
        $txt = $url;
        fwrite($myfile, $txt);
        
        
        #$txt="Output:".gsisApi_pass.PHP_EOL; 
        #fwrite($myfile, $txt);
        fclose($myfile);

    }
    
}
