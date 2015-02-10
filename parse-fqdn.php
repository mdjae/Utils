/* TODO : All !!!!!!!!!!!
*
*/

<?php
        error_reporting(E_ALL);
        ini_set('error_reporting', E_ALL);



        function crawl($url) 
        {
          $ch = curl_init($url);

          if(file_exists('html_brut.txt')) 
                  {
                        unlink('html_brut.txt');
                  }

          $html_brut = fopen('html_brut.txt', 'w+') or die("Unable to open stdout for writing.\n");
          echo '======= Curl ========='.PHP_EOL;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      
        curl_setopt($ch, CURLOPT_FILE, $html_brut);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_exec($ch);
          curl_close($ch);
          fclose($html_brut);
          $html = file_get_contents('html_brut.txt');

          $outputfile = "html_brut.txt";
          $cmd = "wget --output-document=$outputfile --tries=1 --timeout=15  $url";
          exec($cmd);
          echo file_get_contents($outputfile);

          echo '##############'.print_r($html,1);
          echo '======= Test ========='.PHP_EOL;
          if(strpos($html, 'PrestaShop') !== false)
                  {
                          $result_file = fopen('result_file.txt', 'a');
                          $elt = $url.', true \n';
                          echo $elt.PHP_EOL;

                          fputs($result_file, $elt);
                          fclose($result_file);
                        } else {
                                $elt = $url.', false';
                          echo $elt.PHP_EOL;

                  }

        }


$lines = file('urls.txt');
foreach ($lines as $line => $url)
        {

                echo $line,' ',$url.PHP_EOL;
                crawl($url);
        }
?>
