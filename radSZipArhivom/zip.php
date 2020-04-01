<?php

$zip = new ZipArchive();
if ($zip->open('GUNJA OSS 2018-0114197 201811140940 - SPP.zip')) {
    //print_r($zip);
    //$zip->extractTo('raspakirano/');
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i) ;
        if(substr($filename,strlen($filename)-4)!=='.gml'){
            continue;
        }
        $contents = '';
        echo $filename . '<br />';
        $zip->extractTo('raspakirano',$filename);
//        $fp = $zip->getFromName($filename);
        //while (!feof($fp)) {
        //    $contents .= fread($fp, 2);
        //}
       // fclose($fp);

        $reader = new XMLReader;
        $reader->open('raspakirano'. DIRECTORY_SEPARATOR . $filename);
        
        while($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->name === 'gml:featureMember') {
              print_r($reader);
              echo '<br />';
          }
        }
          
          $reader->close();
          
        
      // print_r($z);
echo '<hr />';
        //echo $filename . '<br />';
        // ...
    }
    
    $zip->close();


   



    echo 'ok';
} else {
    echo 'failed';
}