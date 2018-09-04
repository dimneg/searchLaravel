<?php

namespace App;

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
class showResults2 {
    function presentResults($solrPath, $Results, $isdirector = null)
    { //test 090166291
        require_once 'collectData.php';
        //global $Results;
        #print_r($Results);
        #$this->saveCsvCloud($Results, '/var/log/results.csv');
       
        #$source = ' ';
        $basicUrl = $this->getBasicUrl();
        $i = 0;
        $uniqueResults = array_filter($Results); //let 's see if there is need to group
        //print_r($uniqueResults);
        $sumResults = count($uniqueResults);
        #echo "results number:".$sumResults.PHP_EOL; 
        $sumSpend = 0;
        $sumAward = 0;
        $sumContracts = 0;
        $sumPayments = 0;
        $counterContracts = 0;
        $sumAwardSel = 0;
        $sumSpendSel = 0;
        $table_str = "";
       
        
        //$table_str = "<table id='searchResults' class='display'><thead><tr><th></th><th></th> </tr></thead>";  
        //if ($isdirector == 1) {
        //    $table_str = "<table id='searchResults2' class='display'><thead><tr><th></th></tr></thead>"; 
        //} else {
            $table_str = "<table id='searchResults' class='display'><thead><tr><th></th><th></th></tr></thead>"; 
        //}


        $table_str .= "<tbody>";
        
        //corporation
        
     
        
        
        while ($i < $sumResults) { 
            
            $name = $this->unaccent(mb_convert_case($uniqueResults[$i]['name'],MB_CASE_UPPER, "UTF-8"));
            $url = $uniqueResults[$i]['link'];
            # $corporation = $uniqueResults[$i]['corporate_id'];
           
            
            
          
           # echo 'amount:'.preg_replace('/\D/', '',$uniqueResults[$i]['tedSumofAmounts']).'class: '.$uniqueResults[$i]['amountClass'].'</br>';
            
            if  (isset($uniqueResults[$i]['vat']) ||  ($uniqueResults[$i]['db'] === 'lb_mp' || $uniqueResults[$i]['db'] === 'lb_mp_2') ) {    
                
                if  (!is_numeric($uniqueResults[$i]['vat'])) { //boost step 2
                    $uniqueResults[$i]['score'] = bcmul(0.75,$uniqueResults[$i]['score'] ,4) ;
                }
                
            
                $table_str .= "<tr>";

                //....basic view 1...\\
                $table_str .= "<td style=\" text-align:left; border-left: 0px solid #ccc; font-size:15px; padding-right:0px;\">"; 
                
                $table_str .='<font class="dataset" color="#FF0000" style="font-size: 0.77em">[Corporate Group]</font>';
                $table_str .='<font class="dataset" color="#006621" style="font-size: 0.77em">High confidence</font>';
                
                
               	
                $table_str .= ' ';
                $scorePresentation = $this->presentConfidence($sumResults,$uniqueResults[$i]['score']);             
                $table_str .= " <span style='font-size: 0.77em; color:$scorePresentation[1]'>$scorePresentation[0]</span>";
                //....alt names...\\
                #if ($uniqueResults[$i]['corporate_id'] !==''){
                  #  echo " <font class='dataset' color='#006621' style='font-size: 0.77em'>$corporation</font></br> ";
                #}
                #if (!empty($uniqueResults[$i]['altNames'])) {
                 #    echo 'Eμφανίζεται και ως: '.$uniqueResults[$i]['altNames']."</br>";
                     
                #}
                 //....basic view 2...\\
                $table_str .= '<div class="info">';
                $table_str .= $this->hide_not_avail($uniqueResults[$i]['address']);
                $table_str .= ' ';
                $table_str .= $this->hide_not_avail($uniqueResults[$i]['pc']);
                $table_str .= ' ';
                $table_str .= $this->hide_not_avail_space($uniqueResults[$i]['city']); 
                $table_str .= ' ';
                //echo $this->hide_not_avail($uniqueResults[$i]['locality']); 
                //echo ' ';
               # echo $this->hide_not_avail_space($uniqueResults[$i]['countryName']); 
                #echo ' ';
                 if ($uniqueResults[$i]['db'] === 'lb_mp' || $uniqueResults[$i]['db'] === 'lb_mp_2') {
                     $table_str .= "</br>";
                 }
                 else {
                     $table_str .= $this->getVatLabel($uniqueResults[$i]['vat']). $this->hide_not_avail($uniqueResults[$i]['vat']."</br>");
                 }
                
                $table_str .= '</div>';
                //....show diaugeia...\\
               
                
                   
                if ($uniqueResults[$i]['db'] === 'lb_fr' || $uniqueResults[$i]['db'] === 'lb_companies' ){
                    $table_str .= $this->hide_not_avail($uniqueResults[$i]['orgTypeFront']);
                    $table_str .= '&nbsp';	
                    $table_str .= $this->hide_not_avail($uniqueResults[$i]['cpaTitle']);
                    $table_str .= '&nbsp';
                    $table_str .= 'Γ.Ε.Μ.Η.: '.$this->hide_not_avail($uniqueResults[$i]['gemhNumber']);	
                    $table_str .= ' &nbsp'.$this->hide_not_avail($uniqueResults[$i]['chamber']);
                    $table_str .=  ' &nbsp [Ημ/νία απόδοσης Γ.Ε.Μ.Η.: '.  $this->convertDate($uniqueResults[$i]['gemhDate']).']</br>';	
                }
                else {
                    if ($uniqueResults[$i]['db'] === 'lb_no_gemh'){
                         $table_str .= $this->hide_not_avail($uniqueResults[$i]['orgTypeFront']);	
                    }
                    else {
                        
                    }
                }
                
                $table_str .=  ' <font class="dataset" color="#006621" style="font-size: 0.77em">ΔΙΑΥΓΕΙΑ</font></br> ';  
                $table_str .= ' <font class="dataset" color="#006621" style="font-size: 0.77em">ΚΗΜΔΗΣ</font></br> '; 
                $table_str .=  ' <font class="dataset" color="#006621" style="font-size: 0.77em">Επιδοτήσεις ΕΣΠΑ</font></br> ';
                $table_str .=  ' <font class="dataset" color="#006621" style="font-size: 0.77em">ΑΥΣΤΡΑΛΙΑ</font></br> '; 
                $table_str .=  ' <font class="dataset" color="#006621" style="font-size: 0.77em">T.E.D.</font></br> '; 
                
               # echo ' <font class="dataset" color="#800080" style="font-size: 0.77em">Γ.Ε.Μ.Η.</font></br> '; 
                
                
               
                #echo 'score :'.$uniqueResults[$i]['score']; 
                #echo 'class: '.$uniqueResults[$i]['amountClass']; 
                
                
                 
                $table_str .= "</td>";

                $table_str .= "<td style=\" text-align:left; border-left: 0px solid #ccc; font-size:15px; padding-right:0px;  width:80px;\">";
                $table_str .= $uniqueResults[$i]['score']; //hidden
                $table_str .= "</td>";
                   
                

                $table_str .= "</tr>"; 
                }
            $i++;
         }
         
        $table_str .= "</tbody>";
        $table_str .= "</table>";
            
        return $table_str;
    }
    
    function fromTextToNumber($text) {
        $numbered=0;
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
        $numbered*=1;
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
    function getVatLabel($vat){
         $vatLabel ='Α.Φ.Μ. ';
         if (strlen($vat)== 7){
             $vatLabel ='ID';
         }
         if (strlen($vat)>= 10){          
            $vatLabel = 'A.B.N. ';          
                
                        
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
