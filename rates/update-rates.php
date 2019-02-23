<?php
    /**************************************/
    /* Amolecoin Exchange Rate API       */
    /*                                    */
    /* Copyright 2018. AdelaideCreative   */
    /* www.adelaidecreative.com.au        */
    /**************************************/
     
     //Enter the $ETB price per AMC
     $ETB_AMC_RATE = '2.0';

    //make the api request for convert currency.
    function currencyConvert($from,$to,$amount){
    $url = "http://finance.google.com/finance/converter?a=$amount&from=$from&to=$to"; 
    $request = curl_init(); 
    $timeOut = 0;
    curl_setopt ($request, CURLOPT_URL, $url); 
    curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1); 

    curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); 
    curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut); 
    $response = curl_exec($request);
    //echo $response;
    curl_close($request);
    $regex  = '#\<span class=bld\>(.+?)\<\/span\>#s';
    preg_match($regex, $response, $converted);
    if(!empty($converted))
    return  strip_tags(preg_replace("/[^0-9,.]/", "", ($converted[0])?$converted[0]:0));

    }


// Add BTC Later on
// {"code":"BTC","n":'.currencyConvert('ETB','BTC', $ETB_AMC_RATE).',"price":"฿'.currencyConvert('ETB','BTC', $ETB_AMC_RATE).'","name":"Bitcoin"}

//Generate the converted rates into a string
$rates_pub = '

[{"code":"AMC","n":1,"name":"AmoleCoin"},
{"code":"ETB","n":'.$ETB_AMC_RATE.',"price":"ETB'.$ETB_AMC_RATE.'","name":"Ethiopian Birr"},
{"code":"USD","n":'.currencyConvert('ETB','USD', $ETB_AMC_RATE).',"price":"$'.currencyConvert('ETB','USD', $ETB_AMC_RATE).'","name":"US Dollar"},
]

';
    
//Write the rates file for iOS & Android Apps to read
$file = 'index.php';

// Write the Updated Rates back to the file
file_put_contents($file, $rates_pub);

echo "Rates Updated!";
?>
