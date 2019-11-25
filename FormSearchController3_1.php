<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\keyWord;
use App\collectData3;
use App\showResults3;
use App\User;
use View;
use App;
use DB;
use Lang;
use Response;


class FormSearchController3 extends Controller
{
    protected $user;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        
        $this->middleware(function ($request, $next) {            
            $this->user = Auth::user();            
            return $next($request);
        });
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $lang = null)
    {
        //$isdirector = $request->input("isdirector"); 
        //$search =  $request->input("searchKey"); 
       
        $table_str = "";

        //$urlparam = "";

        $lang = $this->setLanguage($lang);

        $dayName = $this->getDayName($lang);
        $monthName = $this->getMonthName($lang);
        $dayMonthNum = date("d");
        $monthNum = date('n', strtotime("first day of -1 month"));
        $monthNamePrev = $this->getMonthNamePrev($lang);
        
        if ($lang == "en") {
            $qry_lang = "en";
        } else {
            $qry_lang = "el";
        }

    

        return view('search.form')->with(compact('monthNum', 'monthName', 'dayName', 'dayMonthNum', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function index_test(Request $request, $lang = null)
    {
        $newKeyWord = new keyWord();
       $this->createLogFile("all",$request);
       #$allargs = $request->input() ;
      # print_r ( $allargs );
       #$allargs = implode(',', $allargs  );
       #$this->createLogFile("allargs",$allargs );
        //return 0;
        $isdirector = $request->input("isdirector"); 
        $search =  $request->input("searchKey"); 
        $activeStatus = $request->input('activeStatus');
        $selectOrgtype = $request->input('selectOrgtype');
        $selectCPA = $request->input('selectCPA');
        $selectChamber = $request->input('selectChamber');
        
        
        
        $advCriteria = "";
        
        //////status//////
        
        #if (isset($activeStatus)){
            
        #}
        if (is_array($activeStatus)){
            $activeStatusList = implode(',', $activeStatus  );
            $this->createLogFile("activeStatusList",$activeStatusList);
        }
        else {
            $this->createLogFile("activeStatus",$activeStatus);
        }
        if (isset($activeStatus )){
        #if ($activeStatus !=''){
            $activeStatusUrlStem = "%20AND%20status:'Ενεργή'";
        }
        else {
             $activeStatusUrlStem ='';
        }
        
        $advCriteria .= $activeStatusUrlStem;
        
         //////orgtype//////
        
        
        if (is_array($selectOrgtype)){
            $selectOrgtypeList = implode(',', $selectOrgtype );
             $this->createLogFile("selectOrgtypeList",$selectOrgtypeList);
        }
        else {
            $this->createLogFile("selectOrgtype",$selectOrgtype);
        }
        
        
       
     
       if (isset($selectOrgtype)){
           $selectOrgtypeUrlStem ="%20AND%20(";
           
           #$selectOrgtypeUrlStem = "%20AND%20orgtype:'".$selectOrgtype."'";
            #$selectOrgtypeUrlStem = "%20AND%20orgtype:''";
            foreach ($selectOrgtype as $key => $value) {
                if ($key>0){
                    $selectOrgtypeUrlStem .= "%20OR%20";
                }
                $selectOrgtypeUrlStem .= "orgType:".$value."";
               
            }
            #$selectOrgtypeUrlStem ='';
            $selectOrgtypeUrlStem .= ")";
        }
        
        else {
             $selectOrgtypeUrlStem ='';
        } 
                
       $advCriteria .=  $selectOrgtypeUrlStem ; 
       
          //////CPA//////
       
      if (is_array($selectCPA)){
            $selectCPAList = implode(',', $selectCPA );
             $this->createLogFile("selectCPA",$selectCPAList);
        }
        else {
            $this->createLogFile("selectCPA",$selectCPA);
        }
        
        
     
       
       if (isset($selectCPA)){
           $selectCPAUrlStem ="%20AND%20(";
           
           
            foreach ($selectCPA as $key => $value) {
                # $valueFixedArray = $newKeyWord->prepareExactKeyword($value );
                if ($key>0){
                    $selectCPAUrlStem .= "%20OR%20";
                }
                $selectCPAUrlStem .= "level1Code:".$value."";
            }
            #$selectOrgtypeUrlStem ='';
            $selectCPAUrlStem .= ")";
        }
        
        else {
             $selectCPAUrlStem ='';
        } 
                
       $advCriteria .=  $selectCPAUrlStem ; 
       
       
       //////chamber//////
        if (is_array($selectChamber)){
            $selectChamberList = implode(',', $selectChamber );
             $this->createLogFile("selectChamber",$selectChamberList);
        }
        else {
            $this->createLogFile("selectChamber",$selectChamber);
        }
        
        
     
       #if ($selectOrgtype !='' ){
       if (isset($selectChamber)){
           $selectChamberUrlStem ="%20AND%20(";
           
           
            foreach ($selectChamber as $key => $value) {
                 $valueFixedArray = $newKeyWord->prepareExactKeyword($value );
                if ($key>0){
                    $selectChamberUrlStem .= "%20OR%20";
                }
                $selectChamberUrlStem .= "chamber:".$newKeyWord->removeIllegalChars($valueFixedArray[3])."";
            }
            #$selectOrgtypeUrlStem ='';
            $selectChamberUrlStem .= ")";
        }
        
        else {
             $selectChamberUrlStem ='';
        } 
                
       $advCriteria .=  $selectChamberUrlStem ; 
        
        
        
       
        $table_str = "";

        //$urlparam = "";

        $lang = $this->setLanguage($lang);

        $dayName = $this->getDayName($lang);
        $monthName = $this->getMonthName($lang);
        $dayMonthNum = date("d");
        $monthNum = date('n', strtotime("first day of -1 month"));
        $monthNamePrev = $this->getMonthNamePrev($lang);
        
        if ($lang == "en") {
            $qry_lang = "en";
        } else {
            $qry_lang = "gr";
        }


        $time_pre = microtime(true);
        $prefix = '' ;
        $varKeyword = $request->input("searchKey"); 
        $rowKeyword = $varKeyword;
        /*$globalKeyword = $_GET['varKeyword'];
        if (isset($globalKeyword )) {

            $varKeyword = $globalKeyword ;
        } */

        $Db='';  
        $DesignDoc = '';
        $Index ='';
        $Limit = 25;
        $Sort = 'score';
        $Wc = '';
        $Wc_wild = '*';
        $Wc_fuzzy = '~0.80';
        $calls = 0;
        $Results = [[]];
        $AlreadyFound = 0;
        $Boost = 1;
        $Actual_link = '';
        $Lang = '';
        $Domain ='';
        $term1 = '';
        $term2 = '';
        $term12 = '';

        
        $table_str = "";


        #if($_POST['formSubmit'] == "index.php" || (isset($_GET['varKeyword']))) {   

        if ($search) {
            if(strlen($varKeyword) != mb_strlen($varKeyword, 'utf-8')){ #not only english     
                $varKeyword = $newKeyWord->prepareKeyword($varKeyword);   
            }
            else {
                $varKeyword = rtrim(ltrim($varKeyword));  
                $varKeyword = $newKeyWord->prepareKeyword($varKeyword);   
            }
            $words = explode(' ', $varKeyword);  



         #read all data
            $search = new collectData3();

             if ($isdirector == 1) {
                
                if (is_numeric($varKeyword)) { //probaby afm
//echo "1";                    
                    $searchvar1 = $search->getAllPersonsCouch(config('search.DbPath'),config('search.lucenePath'), config('search.personscouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'vat');  
                    $searchvar2 = NULL;       

                }
                else {

                     if (count($words) === 1){
                        $searchvar1=$search->getAllPersonsCouch(config('search.DbPath'),config('search.lucenePath'), config('search.personscouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term');      
                        $searchvar2=$search->getAllPersonsCouch(config('search.DbPath'), config('search.lucenePath'),config('search.MPcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term'); 
                     }
                    else {
                        $termsArray = $newKeyWord->prepareExactKeyword($varKeyword);
                        $exactFullKeyword = $termsArray[3];
                        $searchvar1=$search->getAllPersonsCouch(config('search.DbPath'),config('search.lucenePath'), config('search.personscouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term');      
                        $searchvar2=$search->getAllPersonsCouch(config('search.DbPath'),config('search.lucenePath'), config('search.MPcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term'); 
                    }

                }

               # $searchvar = array_merge((array)$searchvar1,(array)$searchvar2);
                 $searchvar = array_merge((array)$searchvar1,(array)$searchvar2);

                //print_r($searchvar);
                //die;

                $resultsPresentation = new showResults3();
                
                //$resultsPresentation -> presentResults(config('search.solrPath'));

                $table_str = $resultsPresentation->presentResults(config('search.solrPath'), $searchvar, $isdirector,$lang,'','');
                
                
                $time_post = microtime(true);
                $exec_time = $time_post - $time_pre;
                $table_str .=  "<div ALIGN='CENTER'>";
                $table_str .= __('lang.advancedSearchResults_frm_time1').' '.number_format($exec_time,2).' '.__('lang.advancedSearchResults_frm_time2');
                $table_str .= "</div>";
               
                $varKeyword =  str_replace('+',' ',$varKeyword);
                $varKeyword =  str_replace('"',' ',$varKeyword);


            } 
             else { //electoral
                #echo 'active....0....1....'.$active.$selectOrgtype; 
                #print_r($request->input("showOnlyActive") );
                if (is_numeric($varKeyword)) { //probaby afm
                    if (strlen(utf8_decode($varKeyword)) >=8 && strlen(utf8_decode($varKeyword)) <=10 ) {
                        if ($this->checkAFM($varKeyword) != 1){
                            #$table_str .=  "<div ALIGN='CENTER'>";
                           # echo __('lang.advancedSearchIncorrectVat'); 
                            $varKeyword = 'wrong_vat';
                            $searchvar1 = $search->getAllMessagesCouch(config('search.DbPath'),config('search.lucenePath'), config('search.messagesSearch_CouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria);  
                            #$table_str .= "</div>";
                            $searchvar =  $searchvar1;
                           # exit();
                        }
                        else {
                            $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.nonGemhcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'vat',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria);    
                            $searchvar2 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'vat',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria);  
                            $searchvar3 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.tedcouchDB') , 'VatIdOrName', 'VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','','');                           
                            $searchvar4 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.FRcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'vat',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria); 
                            $searchvar5 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.diaugeiaSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria); 
                            $searchvar6 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.khmdhsSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria); 
                            $searchvar7 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.espaCouchDB'), 'VatIdOrName', 'by_beneficiaryDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria); 
                            $searchvar8 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.australiaSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria); 
                            
                            $searchvar = array_merge((array)$searchvar1,(array)$searchvar2,(array)$searchvar3,(array)$searchvar4,(array)$searchvar5,(array)$searchvar6,(array)$searchvar7,(array)$searchvar8);
                            if (empty($searchvar)){
                                  #$table_str .=  "<div ALIGN='CENTER'>"; 
                                  echo   __('lang.advancedSearchVatNotFound'); 
                                  #$table_str .= "</div>";
                            }
                        }
                        
                            
                    } else {
                        if (strlen(utf8_decode($varKeyword)) == 12 ) {
                            $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.FRcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'gemhnumber',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria);  
                            $searchvar2 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'gemhnumber',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria); 
                            #$searchvar3 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.tedcouchDB') , 'VatIdOrName', 'VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                            #$searchvar3 =NULL;     
                            #$searchvar4 =NULL;
                           
                            $searchvar = array_merge((array)$searchvar1,(array)$searchvar2);
                        } else {
                           if (strlen(utf8_decode($varKeyword)) == 11 ) {
                               $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.australiaSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria); 
                               $searchvar = $searchvar1;
                           }
                           else {
                              $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.nonGemhcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'vat',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria);    
                              $searchvar2 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'vat',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria);  
                              $searchvar3 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.tedcouchDB') , 'VatIdOrName', 'VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria);                           
                              $searchvar4 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.FRcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'vat',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria); 
                              $searchvar5 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.diaugeiaSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria); 
                              $searchvar6 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.khmdhsSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria); 
                              $searchvar7 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.espaCouchDB'), 'VatIdOrName', 'by_beneficiaryDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria); 
                              $searchvar8 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.australiaSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','','',$advCriteria); 
                              $searchvar = array_merge((array)$searchvar1,(array)$searchvar2,(array)$searchvar3,(array)$searchvar4,(array)$searchvar5,(array)$searchvar6,(array)$searchvar7,(array)$searchvar8);
                           }
                               
                        }
                    } 
                         
                    #}
                    #else {
                     #   $search->getAllShort(solrPath,personsSolrCore,$varKeyword );   
                    #}
                } else { //name

                     if (count($words) === 1){
                        $searchvar1 = $search->getAllCompaniesCouchEle(config('search.DbPath'),config('search.lucenePath'), 'lb_electoral' , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria);  
                        
                        
                        
                        #$searchvar5 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.khmdhsSellersCouchDB') , 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                       
                      # $searchvar = array_merge((array)$searchvar1,(array)$searchvar2,(array)$searchvar3,(array)$searchvar4,(array)$searchvar5,(array)$searchvar6,(array)$searchvar7,(array)$searchvar8);
                       $searchvar = $searchvar1;
                        # #echo count($searchvar);
                        # $searchvar = array_merge((array)$searchvar1,(array)$searchvar3);
                        ////fuzziness///
                       /* if (count($searchvar == 0 && strlen(utf8_decode($varKeyword)>=4))){
                            $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.nonGemhcouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc_wild, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                            $searchvar2 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc_wild, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                            $searchvar3 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.tedcouchDB') , 'VatIdOrName', 'VatIdOrName', $Wc_wild, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                            $searchvar4 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.FRcouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc_wild, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                            $searchvar5 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.diaugeiaSellersCouchDB') , 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc_wild, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                            $searchvar6 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.khmdhsSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc_wild, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',''); 
                            $searchvar7 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.espaCouchDB') , 'VatIdOrName', 'by_beneficiaryDtls_VatIdOrName', $Wc_wild, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                            $searchvar8 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.australiaSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc_wild, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',''); 
                            
                            $searchvar = array_merge((array)$searchvar1,(array)$searchvar2,(array)$searchvar3,(array)$searchvar4,(array)$searchvar5,(array)$searchvar6,(array)$searchvar7,(array)$searchvar8);
                             if (count($searchvar == 0)){
                                 $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.nonGemhcouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc_fuzzy, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                                 $searchvar2 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc_fuzzy, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                                 $searchvar3 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.tedcouchDB') , 'VatIdOrName', 'VatIdOrName', $Wc_fuzzy, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                                 $searchvar4 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.FRcouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc_fuzzy, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                                 $searchvar5 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.diaugeiaSellersCouchDB') , 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc_fuzzy, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                                 $searchvar6 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.khmdhsSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc_fuzzy, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',''); 
                                 $searchvar7 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.espaCouchDB') , 'VatIdOrName', 'by_beneficiaryDtls_VatIdOrName', $Wc_fuzzy, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                                 $searchvar8 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.australiaSellersCouchDB'), 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc_fuzzy, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',''); 
                                 
                                 $searchvar = array_merge((array)$searchvar1,(array)$searchvar2,(array)$searchvar3,(array)$searchvar4,(array)$searchvar5,(array)$searchvar6,(array)$searchvar7,(array)$searchvar8);
                             } 
                        }*/
                       

                      }
                    else {
                        $termsArray = $newKeyWord->prepareExactKeyword($varKeyword);
                        $exactFullKeyword = $termsArray[3];
                        $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), 'lb_electoral'  , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'),config('search.chamberscouchDB'),$advCriteria);
                       
                       
                        #$searchvar1 = $search->getAllCompaniesCouch(config('search.DbPath'),config('search.lucenePath'), config('search.FRcouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                        #$searchvar2 = $search->getAllCompaniesCouch(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                       # $searchvar = array_merge((array)$searchvar1,(array)$searchvar2,(array)$searchvar3,(array)$searchvar4,(array)$searchvar5,(array)$searchvar6,(array)$searchvar7,(array)$searchvar8);
                       $searchvar =  $searchvar1;
                    }


                    

                     #$searchvar = array_merge((array)$searchvar1,(array)$searchvar2,(array)$searchvar3,(array)$searchvar4,(array)$searchvar5,(array)$searchvar6,(array)$searchvar7,(array)$searchvar8);
                   

            
                }

                $resultsPresentation = new showResults3();
            
                $table_str = $resultsPresentation->presentResults(config('search.solrPath'), $searchvar, $isdirector,$lang,'','');
                

                $time_post = microtime(true);
                $exec_time = $time_post - $time_pre;
                $table_str .=  "<div ALIGN='CENTER'>";
                $table_str .= __('lang.advancedSearchResults_frm_time1').' '.number_format($exec_time,2).' '.__('lang.advancedSearchResults_frm_time2');
                       
                $table_str .= "</div>";
               
                $varKeyword =  str_replace('+',' ',$varKeyword);
                $varKeyword =  str_replace('"',' ',$varKeyword);

               
            }
        }     
         $lastSearched = DB::select(DB::raw("SELECT * 
                                            FROM searches_by_user 
                                            WHERE sbu_user = ".$this->user->id." 
                                            ORDER BY sbu_datetime DESC 
                                            LIMIT 10")); 

         return view('search.form_test3')->with(compact('adv','returnsearch','lastSearched', 'stst', 'varKeyword', 'table_str', 'monthNum', 'monthName', 'dayName', 'dayMonthNum', 'lang', 'isdirector'));    }
    
    public function checkAFM($afm) {
   
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
    function createLogFile($i,$txt){
        #$settingsFile = '../gsis/gsisProps.txt';
        $settingsFile = '/home/negkas/searchLaravel/'.$i.'.txt' ;
       
        $myfile = fopen($settingsFile, "w") or die("Unable to open file!");
        #$txt = $url;
        fwrite($myfile, $txt);
        
        
        #$txt="Output:".gsisApi_pass.PHP_EOL; 
        #fwrite($myfile, $txt);
        fclose($myfile);

    }
    
    

}
