<?php

namespace App;
use Lang;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of showResults
 *
 * @author dimitris negkas
 */
class showResults3 {
    function presentResults($solrPath, $Results, $isdirector, $lang,$advChoiceArea,$advChoiceAmount, $totals ) {
    //test 090166291
        require_once 'collectData3.php';
        $checkData = new collectData3();
        //global $Results;
        #print_r($Results);
        
       
        #$source = ' ';
        $basicUrl = $this->getBasicUrl();
        #$i = 0;
     
        #$uniqueResults = array_filter($uniqueResults);
       
        //print_r($uniqueResults);
        
        #echo "results number:".$sumResults.PHP_EOL; 
        $sumSpend = 0;
        $sumAward = 0;
        $sumContracts = 0;
        $sumPayments = 0;
        $counterContracts = 0;
       # $sumAwardSel = 0;
       # $sumSpendSel = 0;
        $table_str = "";
       
        
        //$table_str = "<table id='searchResults' class='display'><thead><tr><th></th><th></th> </tr></thead>";  
        //if ($isdirector == 1) {
        //    $table_str = "<table id='searchResults2' class='display'><thead><tr><th></th></tr></thead>"; 
        //} else {
            $table_str = "<table id='searchResults' class='display'><thead><tr><th></th><th></th></tr></thead>"; 
        //}


        $table_str .= "<tbody>";
        
        //wrong or unassigned vat
        $table_str .= "<tr>";
                $table_str .= "<td style=\" text-align:left; border-left: 0px solid #ccc; font-size:15px; padding-right:0px;\">"; 
                $table_str .=   " <font  color='#FF0000' >Σύνολο:</font> ";  
                $table_str .= " ";
                $table_str .= $totals;
                $table_str .= " ";
                $table_str .= "Εταιρίες";
                $table_str .= "</td>";

                $table_str .= "<td style=\" text-align:left; border-left: 0px solid #ccc; font-size:15px; padding-right:0px;  width:80px;\">";
               # $table_str .= $Results[0]['score']; //hidden
                $table_str .= '';
                $table_str .= "</td>";



                 $table_str .= "</tr>"; 
        
        
        
     
       
        
       
         
        $table_str .= "</tbody>";
        $table_str .= "</table>";
            
        return $table_str;
    }
    
    
    
    function groupResults($Results){
        $checkData = new collectData();
        $uniqueResults= [[]];
        #$this->saveCsvCloud($uniqueResults, '/home/negkas/searchLaravel/'.date('Y-m-d H:i:s').'.csv');
       # $uniqueResults[] = $Results[0];
        foreach ($Results as $newdata) {
              if (!isset($uniqueResults[$newdata['vat']])) {
                  $uniqueResults[$newdata['vat']] = [
                      'vat'=>$newdata['vat'],                      
                      'name' => $newdata['name'],
                      'name_eng' => $newdata['name_eng'],
                      'link' => $newdata['link'],
                      'db' => $newdata['db'],
                      'corporation_id' => $newdata['corporation_id'],
                      'country_code' => $newdata['country_code'],
                      'score' => $newdata['score'],
                      'address' => $newdata['address'],
                      'pc' => $newdata['pc'], 
                      'city' => $newdata['city'], 
                      'gemhNumber' => $newdata['gemhNumber'] , 
                      'cpaTitle' => $newdata['cpaTitle'] , 
                      'orgType' =>$newdata['orgType'] , 
                      'orgTypeFront' => $newdata['orgTypeFront'] , 
                      'chamber' =>  $newdata['chamber'],
                      'chamber_eng' =>  $newdata['chamber_eng'],
                      'gemhDate' => $newdata['gemhDate'],     
                      'status' => $newdata['status'],     
                      'dataNoGemh'=> $newdata['dataNoGemh'],  
                      'dataGemh'=>  $newdata['dataGemh'],
                      'dataTed' => $newdata['dataTed'],
                      'dataDiaugeia'=>  $newdata['dataDiaugeia'],
                      'dataKhmdhs'=>  $newdata['dataKhmdhs'],
                      'dataEspa'=>  $newdata['dataEspa'],  
                      'dataAustralia'=>  $newdata['dataAustralia'],  
                     
                      
                      
                      ///////TED
                      'tedSumofAmounts' => $newdata['tedSumofAmounts'],
                      'tedContracts' => $newdata['tedContracts'],
                      
                      //////diaugeia                      
                      'award0' => $newdata['award0'],
                      'award1'=> $newdata['award1'] ,
                      'award2'=> $newdata['award2'] ,
                      'awardCnt0'=> $newdata['awardCnt0'] ,
                      'awardCnt1'=> $newdata['awardCnt1'],
                      'awardCnt2'=> $newdata['awardCnt2'] ,                    
                      'spend0'=> $newdata['spend0']  ,
                      'spend1'=> $newdata['spend1'] ,
                      'spend2'=> $newdata['spend2'],
                      'spendCnt0'=>  $newdata['spendCnt0'] ,
                      'spendCnt1'=>  $newdata['spendCnt1'] ,
                      'spendCnt2'=> $newdata['spendCnt2'] ,
                      'lastUpdate'=> $newdata['lastUpdate']  ,
                      
                      ///khmdhs                      
                      'contractAmountPrev'=> $newdata['contractAmountPrev']  ,
                      'contractAmountCur'=> $newdata['contractAmountCur']  ,                     
                      'paymentAmountPrev'=> $newdata['paymentAmountPrev'] ,
                      'paymentAmountCur'=> $newdata['paymentAmountCur']  ,                      	  
                      'contractItemsNo'=>  $newdata['contractItemsNo']  ,
                      'paymentItemsNo'=>   $newdata['paymentItemsNo'] ,
                      'ks_lastUpdate'=> $newdata['ks_lastUpdate'], 
                      
                      //espa
                      'SubsContractsAmount'=> $newdata['SubsContractsAmount']  ,
                      'SubsPaymentsAmount'=> $newdata['SubsPaymentsAmount']   ,	
                      'SubsContractsCounter'=> $newdata['SubsContractsCounter']  ,
                      'SubsPaymentsCounter'=> $newdata['SubsPaymentsCounter'] ,  
                      'espa_lastUpdate'=> $newdata['espa_lastUpdate']  ,
                      
                       //australia
                      'contractAmount0'=> $newdata['contractAmount0']  ,
                      'contractAmount1'=> $newdata['contractAmount1']  ,
                      'contractAmount2'=> $newdata['contractAmount2']  ,
                      'contractCounter0'=> $newdata['contractCounter0'],
                      'contractCounter1'=> $newdata['contractCounter1'] ,
                      'contractCounter2'=> $newdata['contractCounter2'] ,
                        
                      
                  ];
                      
              }
              else {
                  #$uniqueResults[$newdata['vat']]['dataTed'] = $newdata['dataTed']; 
                  $uniqueResults[$newdata['vat']]['dataNoGemh'] = $checkData->defineSource($newdata['db'], 'dataNoGemh',$uniqueResults[$newdata['vat']]['dataNoGemh'],$newdata['dataTed']);
                  $uniqueResults[$newdata['vat']]['dataGemh'] = $checkData->defineSource($newdata['db'], 'dataGemh',$uniqueResults[$newdata['vat']]['dataGemh'],$newdata['dataTed']);
                  $uniqueResults[$newdata['vat']]['dataTed'] = $checkData->defineSource($newdata['db'], 'dataTed',$uniqueResults[$newdata['vat']]['dataTed'],$newdata['dataTed']);                
                  $uniqueResults[$newdata['vat']]['dataDiaugeia'] = $checkData->defineSource($newdata['db'], 'dataDiaugeia',$uniqueResults[$newdata['vat']]['dataDiaugeia'],$newdata['dataTed']);
                  $uniqueResults[$newdata['vat']]['dataKhmdhs'] = $checkData->defineSource($newdata['db'], 'dataKhmdhs',$uniqueResults[$newdata['vat']]['dataKhmdhs'],$newdata['dataTed']);
                  $uniqueResults[$newdata['vat']]['dataEspa'] = $checkData->defineSource($newdata['db'], 'dataEspa',$uniqueResults[$newdata['vat']]['dataEspa'],$newdata['dataTed']);
                  $uniqueResults[$newdata['vat']]['dataAustralia'] = $checkData->defineSource($newdata['db'], 'dataAustralia',$uniqueResults[$newdata['vat']]['dataAustralia'],$newdata['dataTed']);
                  
                 if  ($uniqueResults[$newdata['vat']]['orgType']=='' || !isset($uniqueResults[$newdata['vat']]['orgType'])){
                      $uniqueResults[$newdata['vat']]['orgType'] =  $newdata['orgType'];
                  }
                  
                 if ($uniqueResults[$newdata['vat']]['orgTypeFront'] == '' || !isset($uniqueResults[$newdata['vat']]['orgTypeFront'])){
                       $uniqueResults[$newdata['vat']]['orgTypeFront'] =  $newdata['orgTypeFront'];
                  }
                      
                 if (($uniqueResults[$newdata['vat']]['corporation_id'] == '' || !isset($uniqueResults[$newdata['vat']]['corporation_id'])) &&  ($newdata['corporation_id']!='') ){
                     $uniqueResults[$newdata['vat']]['corporation_id'] =  $newdata['corporation_id'];
                 }
                 
                 if ($uniqueResults[$newdata['vat']]['address'] == '' || !isset($uniqueResults[$newdata['vat']]['address'])){
                     $uniqueResults[$newdata['vat']]['address'] =  $newdata['address'];
                 }
                 
                 if ($uniqueResults[$newdata['vat']]['pc'] == '' || !isset($uniqueResults[$newdata['vat']]['pc'])){
                     $uniqueResults[$newdata['vat']]['pc'] =  $newdata['pc'];
                 }
                 
                 if ($uniqueResults[$newdata['vat']]['city'] == '' || !isset($uniqueResults[$newdata['vat']]['city'])){
                     $uniqueResults[$newdata['vat']]['city'] =  $newdata['city'];
                 }
                 
                 if ($uniqueResults[$newdata['vat']]['gemhNumber'] == '' || !isset($uniqueResults[$newdata['vat']]['gemhNumber'])){
                     $uniqueResults[$newdata['vat']]['gemhNumber'] =  $newdata['gemhNumber'];
                 }
                 
                 
                  
                if ($newdata['dataDiaugeia'] == 1){
                       $uniqueResults[$newdata['vat']]['award0'] =  $newdata['award0'];
                       $uniqueResults[$newdata['vat']]['award1'] =  $newdata['award1'];
                       $uniqueResults[$newdata['vat']]['award2'] =  $newdata['award2'];
                       
                       $uniqueResults[$newdata['vat']]['awardCnt0'] =  $newdata['awardCnt0'];
                       $uniqueResults[$newdata['vat']]['awardCnt1'] =  $newdata['awardCnt1'];
                       $uniqueResults[$newdata['vat']]['awardCnt2'] =  $newdata['awardCnt2'];
                       
                       if (isset($newdata['spend0'])){
                           $uniqueResults[$newdata['vat']]['spend0'] =  $newdata['spend0'];
                       }
                       else {
                            $uniqueResults[$newdata['vat']]['spend0'] = 0;
                       }
                       
                       $uniqueResults[$newdata['vat']]['spend1'] =  $newdata['spend1'];
                       $uniqueResults[$newdata['vat']]['spend2'] =  $newdata['spend2'];
                       
                       $uniqueResults[$newdata['vat']]['spendCnt0'] =  $newdata['spendCnt0'];
                       $uniqueResults[$newdata['vat']]['spendCnt1'] =  $newdata['spendCnt1'];
                       $uniqueResults[$newdata['vat']]['spendCnt2'] =  $newdata['spendCnt2'];
                       
                       $uniqueResults[$newdata['vat']]['lastUpdate'] =  $newdata['lastUpdate'];
                      
                  }
                  
                if ($newdata['dataKhmdhs'] == 1){
                       $uniqueResults[$newdata['vat']]['contractAmountPrev'] =  $newdata['contractAmountPrev'];
                       $uniqueResults[$newdata['vat']]['contractAmountCur'] =  $newdata['contractAmountCur'];
                       $uniqueResults[$newdata['vat']]['paymentAmountPrev'] =  $newdata['paymentAmountPrev'];
                       $uniqueResults[$newdata['vat']]['contractItemsNo'] =  $newdata['contractItemsNo'];
                       $uniqueResults[$newdata['vat']]['contractItemsNo'] =  $newdata['contractItemsNo'];
                       $uniqueResults[$newdata['vat']]['paymentItemsNo'] =  $newdata['paymentItemsNo'];
                       $uniqueResults[$newdata['vat']]['ks_lastUpdate'] =  $newdata['ks_lastUpdate'];
                       
                  }
                  
                if ($newdata['dataEspa'] == 1) {
                    $uniqueResults[$newdata['vat']]['SubsContractsAmount'] =  $newdata['SubsContractsAmount'];
                    $uniqueResults[$newdata['vat']]['SubsPaymentsAmount'] =  $newdata['SubsPaymentsAmount'];                    
                    $uniqueResults[$newdata['vat']]['SubsContractsCounter'] =  $newdata['SubsContractsCounter'];
                    $uniqueResults[$newdata['vat']]['SubsPaymentsCounter'] =  $newdata['SubsPaymentsCounter'];
                    $uniqueResults[$newdata['vat']]['espa_lastUpdate'] =  $newdata['espa_lastUpdate'];
                } 
                
                if ($newdata['dataAustralia'] == 1){
                    $uniqueResults[$newdata['vat']]['contractAmount0'] =  $newdata['contractAmount0'];
                    $uniqueResults[$newdata['vat']]['contractAmount1'] =  $newdata['contractAmount1'];                    
                    $uniqueResults[$newdata['vat']]['contractAmount2'] =  $newdata['contractAmount2'];
                    $uniqueResults[$newdata['vat']]['contractCounter0'] =  $newdata['contractCounter0'];
                    $uniqueResults[$newdata['vat']]['contractCounter1'] =  $newdata['contractCounter1'];
                    $uniqueResults[$newdata['vat']]['contractCounter2'] =  $newdata['contractCounter2'];
                      
                }
                     
                $uniqueResults[$newdata['vat']]['score'] *= 1.1;
                  
                  #$uniqueResults[$newdata['vat']]['dataGemh'] = $newdata['dataGemh'];
                #$out          [$row     ['dd']]['quantity'] += $row['quantity'];
                 
              }
              
              
           
        }
        $uniqueResults = array_values($uniqueResults);
        #$this->saveCsvCloud($uniqueResults, '/home/negkas/searchLaravel/'.count($uniqueResults).'.csv');
      
        return $uniqueResults;
        
    }
    function fromTextToNumber($text) {
        $numbered = 0;
        if ((strpos($text,'M') !== false) || (strpos($text,'Μ') !== false)) {
            $numbered=str_replace("€", "",$text);
            $numbered=str_replace("$", "",$numbered);
            $numbered=str_replace("£", "",$numbered);
            $numbered=str_replace("M", "",$numbered);
            $numbered*=1000000;
        }
        else 
        if ((strpos($text,'K') !== false) || (strpos($text,'Κ') !== false)) {
            $numbered=str_replace("€", "",$text);
            $numbered=str_replace("$", "",$numbered);
            $numbered=str_replace("£", "",$numbered);
            $numbered=str_replace("K", "",$numbered);
            $numbered*=1000;
        }
        else 
        if ((strpos($text,'B') !== false) || (strpos($text,'Β') !== false)) {
            $numbered=str_replace("€", "",$text);
            $numbered=str_replace("$", "",$text);
            $numbered=str_replace("£", "",$numbered);
            $numbered=str_replace("B", "",$numbered);
            $numbered*=1000000000;
        }
        else {
            $numbered *= 1;
        }

        return $numbered;
    }

    function fromNumberToText($number,$currency) {
        $texted = $currency.'0.0K'; //€0.0K
        $digits = strlen($number);
	if (($digits == 1) || (($digits) == 2)){
            $texted = $currency.'0.0K';
	}
	else
	if ($digits == 3) { //e.g. 860=0.8K
            $dividor = 1000;
            $texted = $currency.number_format(round($number/($dividor),1), 1, '.', '').'K';
	}
	else
	if ($digits == 4) { //e.g 8600->8.6K
	$dividor = 1000;
	//$texted='€'.round($number/($dividor),1).'K';
	$texted = $currency.number_format(round($number/($dividor),1), 1, '.', '').'K';
	}
	else
	if ($digits == 5) { //e.g 86000->86K
	$dividor=1000;
	$texted=$currency.number_format(round($number/($dividor),1), 1, '.', '').'K';
	}
	else
	if ($digits == 6) { //e.g 860000->0.8M (kanonika 0.9)
	$dividor=1000000;
	$texted=$currency.number_format(round($number/($dividor),1), 1, '.', '').'M';
	}
	else
	if ($digits == 7) { //e.g 8.600.000->8.6K  
	$dividor=1000000;
	$texted=$currency.number_format(round($number/($dividor),1), 1, '.', '').'M';
	}
	else
	if ($digits == 8) { //e.g 80.600.000->80.6M  
	$dividor=1000000;
	$texted=$currency.number_format(round($number/($dividor),1), 1, '.', '').'M';
	}
	else
	if ($digits == 9) { //e.g 800.600.000->0.8B  //ok
	$dividor=1000000000;
	$texted=$currency.number_format(round($number/($dividor),1), 1, '.', '').'B';
	}
	else
	if ($digits == 10) { //e.g 8.000.600.000->8B  //ok
	$dividor=1000000000;
	$texted=$currency.number_format(round($number/($dividor),1), 1, '.', '').'B';
	}
	else
	if ($digits == 11) { //e.g 80.000.600.000->80B  //ok
	$dividor=1000000000;
	$texted=$currency.number_format(round($number/($dividor),1), 1, '.', '').'B';
	}
	else {
	$texted=$currency.'0.0K'; //test only
	}

	return $texted;
}

    function hide_not_avail($field){
	if (($field=='Μη Διαθέσιμο') || ($field=='Ο ΑΦΜ δεν έχει καταχωρηθεί') ||($field=='-')){
            $field='';
	}
	return $field;
}
    function hide_not_avail_space($field){
	if (($field=='Μη Διαθέσιμο') || ($field=='') || ($field=='Ο ΑΦΜ δεν έχει καταχωρηθεί') ||($field=='-')){
	$field=' ';
	}
	else {
	$field=($field.' &nbsp');
	}
	
	return $field;
        
        
    } 
    
    function saveCsvCloud($tableName,$fileName){
	$fp = fopen($fileName, 'w');

	foreach ($tableName as $fields) {
            fputcsv($fp, $fields,"~");		
	}

	fclose($fp);	
    }
    function convertDate($date){
        if (substr($date,0,3)== 201){
             $revDate= date("d-m-Y", strtotime($date));
        }
        //$revDate='wrong'.$date;
       
        else {
            $revDate=$date;
        }
            
        return $revDate;

    }
    
    function corpOccur($uniqueResults){
        $totalCorporatesOccs = 0;
        $corpCnt = 0;
        $totalCorporatesArray = [[]];
        foreach ($uniqueResults as $key => $value) {
            if  ($value['corporate_id']!= 0){
                $key = $this->searchForId($value['corporate_id'] , $totalCorporatesArray,'id');
                if ($key === NULL){
                    $totalCorporatesArray[$corpCnt]['id'] = $value['corporate_id'];
                    $totalCorporatesArray[$corpCnt]['cnt'] =  1;
                    $corpCnt++;
                }
                else {
                    $totalCorporatesArray[$key]['cnt']++;
                }
                $totalCorporatesOccs++;
                
                
            }
        }
        #return $totalCorporatesOccs;
        return [$totalCorporatesOccs,$totalCorporatesArray];
        
    }
    function searchForId($id, $array,$index) { 
        foreach ($array as $key => $val) {       
                if ( $val[$index] === $id ) {
                    return $key;

                }
                    //else echo 'not equal';
         }
            return NULL;
    } 
    function getVatLabel($vat,$lang){
        if ($lang ==='gr'){
             $vatLabel ='ΑΦΜ ';
            if (strlen($vat)== 7){
                $vatLabel ='ID';
            }
            if (strlen($vat)>= 10){          
               $vatLabel = 'ABN ';          


            }
        }
        else {
             $vatLabel ='V.A.T. ';
            if (strlen($vat)== 7){
                $vatLabel ='ID';
            }
            if (strlen($vat)>= 10){          
               $vatLabel = 'A.B.N. ';          


            }
        }
        
         return $vatLabel;
               
                       
                                
        
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
   
    function unique_multidim_array($array, $key){
        $temp_array = [[]]; //empty array
        $i = 0;
        $key_array = [[]]; //empty array           

        foreach($array as $val){	

            #if 	(!in_array($val[$key],$key_array))   { 
            if 	(isset($val[$key]) && !in_array($val[$key],$key_array))   { 
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
                $i++;
            }
                    
            else { 
                
            }
                    

        }
        return $temp_array;

    }
    
    function presentConfidence ($countResults, $score){
        if ($countResults ==1){
            return  ['High confidence','#1c4e00'];
        }
        if ($score > 5){
            return ['High confidence','#1c4e00'];
        }
        else {
            if ($score > 1){
               return ['Medium confidence','#8ccc08']; 
            }
            else {
                if ($countResults == 1 && $score == 1 ){
                    return  ['High confidence','#1c4e00'];
                }
                else {
                     if ($score == 1){
                         return ['Low confidence','#f0972a'];
                     }
                     else {
                         return ['No confidence','#f0592a'];
                     }
                }
            }
        }
    }
    
    function defineAmountClass($amount){
        $class = '';
        if ($amount > 2000000000){
            $class = 4;
           # echo $class; 
            return $class;
        }
        else {
            if ($amount > 2000000 && $amount <= 2000000000){
                 $class = 3;
                  #echo $class; 
                 return $class;
            }
            else {
                 if ($amount > 2000 && $amount <= 2000000){
                      $class = 2;
                       #echo $class; 
                      return $class;
                 }
                 else {
                     if ($amount > 0){
                         $class = 1;
                         # echo $class; 
                         return $class;
                     }
                     
                 }
            }
        }
        # echo 'empty class'; 
        return $class;
    }
    
    function getBasicUrl (){
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if (strpos($actual_link,'83.212.86.164:81') !== false){
            $domain = "http://83.212.86.164:81/";
        }
        else {
            $domain = "http://dashboard.linkedbusiness.gr/";
        }
        return $domain;
    }
    
   
    
    
}
