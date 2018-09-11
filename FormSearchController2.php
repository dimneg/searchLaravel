<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\keyWord;
use App\collectData;
use App\showResults2;
use App\User;
use View;
use App;
use DB;
use Lang;
use Response;


class FormSearchController2 extends Controller
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

        //return 0;
        $isdirector = $request->input("isdirector"); 
        $search =  $request->input("searchKey"); 
       
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

        $newKeyWord = new keyWord();
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
            $search = new collectData();

            if ($isdirector == 1) {
                
                if (is_numeric($varKeyword)) { //probaby afm
//echo "1";                    
                    $searchvar1 = $search->getAllPersonsCouch(config('search.DbPath'),config('search.lucenePath'), config('search.personscouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'vat');  
                    $searchvar2 = NULL;     

                }
                else {

                     if (count($words) === 1){
                            $searchvar1=$search->getAllCorporationsCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.corporationsCouchDB'), 'VatIdOrName', 'VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));      
                            #$searchvar2=$search->getAllPersonsCouch(config('search.DbPath'),config('search.lucenePath'), config('search.MPcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term'); 
                     }
                    else {
                        $termsArray = $newKeyWord->prepareExactKeyword($varKeyword);
                        $exactFullKeyword = $termsArray[3];
                        #$searchvar1=$search->getAllPersonsCouch(config('search.DbPath'),config('search.lucenePath'), config('search.personscouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term');      
                        #$searchvar2=$search->getAllPersonsCouch(config('search.DbPath'),config('search.lucenePath'), config('search.MPcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term'); 
                        $searchvar1=$search->getAllCorporationsCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.corporationsCouchDB'), 'VatIdOrName', 'VatIdOrName', $Wc, $Limit, $Sort,  $exactFullKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                    }
//echo "2";                    
                    // $searchvar1 = $search->getAllPersonsCouch(config('search.DbPath'), config('search.personscouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term'); 
                    // #$search->getAllPersonsCouch(DbPath, MPcouchDB , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, couchUser, couchPass,companiesUrl,'term');
                    // $searchvar2 = $search->getAllPersonsCouch(config('search.DbPath'), config('search.MPcouchDB_2') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'), config('search.companiesUrl'),'term'); 
                }

               # $searchvar = array_merge((array)$searchvar1,(array)$searchvar2);
                 $searchvar = $searchvar1;

                //print_r($searchvar);
                //die;

                $resultsPresentation = new showResults2();
                
                //$resultsPresentation -> presentResults(config('search.solrPath'));

                $table_str = $resultsPresentation->presentResults(config('search.solrPath'), $searchvar, $isdirector);
                
                
                $time_post = microtime(true);
                $exec_time = $time_post - $time_pre;
                $table_str .=  "<div ALIGN='CENTER'>";
                $table_str .= '(Σε '.number_format($exec_time,2).' δευτερόλεπτα)' ;
                $table_str .= "</div>";
               
                $varKeyword =  str_replace('+',' ',$varKeyword);
                $varKeyword =  str_replace('"',' ',$varKeyword);


            } else {
                
                if (is_numeric($varKeyword)) { //probaby afm
                    if (strlen(utf8_decode($varKeyword)) ==9 ) {
                        
                            $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.nonGemhcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'vat',config('search.orgtypescouchDB'));    
                            $searchvar2 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'vat',config('search.orgtypescouchDB'));  
                            $searchvar3 =NULL;                            
                            #$searchvar3 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.nonGemhcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'vat',config('search.orgtypescouchDB')); 
                            #$search->getAllCompaniesCouch(DbPath, nonGemhcouchDB , $DesignDoc, $Index, $Wc, $Limit, $Sort, $varKeyword, $couchUser, $couchPass,companiesUrl);
                            $searchvar = array_merge((array)$searchvar1,(array)$searchvar2);
                    } else {
                        if (strlen(utf8_decode($varKeyword)) == 12 ) {
                            # $search->getAll(solrPath,companiesSolrCore,'gemhNumber', $varKeyword,'',companiesUrl);    
                             # $search->getAll(solrPath,FRSolrCore,'gemhNumber', $varKeyword,'',companiesUrl);  
                            $searchvar1 = $search->getAllCompaniesCouch(config('search.DbPath'),config('search.lucenePath'), config('search.FRcouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'gemhnumber',config('search.orgtypescouchDB'));  
                            $searchvar2 = $search->getAllCompaniesCouch(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB'), 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'gemhnumber',config('search.orgtypescouchDB')); 
                            $searchvar3 =NULL;     
                           
                            $searchvar = array_merge((array)$searchvar1,(array)$searchvar2);
                        } else {
                           # $search->getAllCompaniesCouch(DbPath, FRcouchDB , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, couchUser, couchPass,companiesUrl,'gemhnumber');  
                        }
                    } 
                         
                    #}
                    #else {
                     #   $search->getAllShort(solrPath,personsSolrCore,$varKeyword );   
                    #}
                } else { //name

                     if (count($words) === 1){
                        $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.tedcouchDB') , 'VatIdOrName', 'VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                        $searchvar2 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                        $searchvar3 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.nonGemhcouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                        #$searchvar2 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.australiaSellersCouchDB') , 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                        #$searchvar3 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.diaugeiaSellersCouchDB') , 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                        #$searchvar4 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.espaCouchDB') , 'VatIdOrName', 'by_beneficiaryDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                        #$searchvar5 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.khmdhsSellersCouchDB') , 'sellerVatIdOrName', 'by_sellerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                        #$searchvar6 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.FRcouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $varKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                        
                       

                      }
                    else {
                        $termsArray = $newKeyWord->prepareExactKeyword($varKeyword);
                        $exactFullKeyword = $termsArray[3];
                        $searchvar1 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.tedcouchDB') , 'VatIdOrName', 'VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                        $searchvar2=  $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB') , 'VatIdOrName', 'VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term','');  
                        $searchvar3 = $search->getAllCompaniesCouchOpj(config('search.DbPath'),config('search.lucenePath'), config('search.nonGemhcouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB')); 
                        #$searchvar1 = $search->getAllCompaniesCouch(config('search.DbPath'),config('search.lucenePath'), config('search.FRcouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                        #$searchvar2 = $search->getAllCompaniesCouch(config('search.DbPath'),config('search.lucenePath'), config('search.companiescouchDB') , 'buyerVatIdOrName', 'by_buyerDtls_VatIdOrName', $Wc, $Limit, $Sort, $exactFullKeyword, config('search.couchUser'), config('search.couchPass'),config('search.companiesUrl'),'term',config('search.orgtypescouchDB'));  
                        
                       
                    }


                    

                     #$searchvar = array_merge((array)$searchvar1,(array)$searchvar2,(array)$searchvar3,(array)$searchvar4,(array)$searchvar5,(array)$searchvar6,(array)$searchvar7,(array)$searchvar8);
                    $searchvar = array_merge((array)$searchvar1,(array)$searchvar2,(array)$searchvar3);

            
                }

                $resultsPresentation = new showResults2();
            
                $table_str = $resultsPresentation->presentResults(config('search.solrPath'), $searchvar, $isdirector);
                

                $time_post = microtime(true);
                $exec_time = $time_post - $time_pre;
                $table_str .=  "<div ALIGN='CENTER'>";
                $table_str .= '(Σε '.number_format($exec_time,2).' δευτερόλεπτα)' ;
                $table_str .= "</div>";
               
                $varKeyword =  str_replace('+',' ',$varKeyword);
                $varKeyword =  str_replace('"',' ',$varKeyword);

               
            }
        }      

         return view('search.form_test2')->with(compact('varKeyword', 'table_str', 'monthNum', 'monthName', 'dayName', 'dayMonthNum', 'lang', 'isdirector'));
    }

}
