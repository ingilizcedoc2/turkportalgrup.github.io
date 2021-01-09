<?php
$link = "https://www.canlitv.me/yayin.php?kanal=cnn-turk-canli-yayin&amp;security=12a711fa2e6ce9d8802ac10d4758fd97";
$veri = file_get_contents($link);
preg_match('@\file: \'(.*?)\'@s',$veri,$veritemp);
 
