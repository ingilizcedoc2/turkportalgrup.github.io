<?php
$link = "https://canlitv.center/yayin/show-tv-izle-3";
$veri = file_get_contents($link);
preg_match('@\file: \'(.*?)\'@s',$veri,$veritemp);
 
