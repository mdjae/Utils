<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
        
/*
* Check if file exist 
*/
        function checkFile($file) {
            if (file_exists($file))
                unlink($file);
                
	         $handle = fopen($file, 'w+');

           if(handle){
               return true;
            } else {
                echo "Unable to open stdout for writing.\n";
                return false;
            }

        }
        
/*
* Execute cUrl on fqdn 
*/
        function crawl($url) {
          	$url = urlencode(trim($url));

           (array) $ch = curl_init();
          		$options = array(
                  	CURLOPT_URL            => $url,
                  	CURLOPT_RETURNTRANSFER => true,
                  	CURLOPT_HEADER         => true,
                  	CURLOPT_FOLLOWLOCATION => true,
                  	CURLOPT_ENCODING       => "",
                  	CURLOPT_AUTOREFERER    => true,
                  	CURLOPT_CONNECTTIMEOUT => 1,
                  	CURLOPT_TIMEOUT        => 120,
              			CURLOPT_MAXREDIRS      => 10
          		);
            curl_setopt_array($ch, $options);
            $res = curl_exec($ch);
      	    $info = curl_getinfo($ch);
            $httpCode = $info['http_code'];
        		print 'Status HTTTP : '. $httpCode;
              
            curl_close($ch);

            return $httpCode;
        }

//Recuperation du fichier fqdn
checkFile('urls.txt');
$lines = file('urls.txt');

//Check Url 
    foreach ($lines as $line => $url){
        $url = trim($url);
        echo $line,' ',$url.PHP_EOL;
        $code = crawl($url); var_dump($code);

      	$file = fopen('status_http.csv','a');
      	$elt= $url.','.$line.','.$code.','.PHP_EOL;	
      	fwrite($file,$elt);
      	fclose($file);
     }

?>
