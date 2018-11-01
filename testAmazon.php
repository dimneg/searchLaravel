<?php
echo prepareResultsCouchOpj;
function prepareResultsCouchOpj(){
       $couchUserPwd = $couchUser.':'.$couchPass;
       $ch = curl_init();
       $url = "http://18.202.218.98:5986/_fti/local/elod_australia_sellers/_design/sellerVatIdOrName/by_sellerDtls_VatIdOrName?q=term:801037724&limit:25&sort:score";
       #$this->createLogFileCall($url);
       #echo $url.PHP_EOL;
   
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_USERPWD, 'dimneg:darcy9698' );
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                       'Content-type: application/json; charset=utf-8',
                       'Accept: */*'
                    ));

       $response = curl_exec($ch);
        curl_close($ch);
       return $response;
}

