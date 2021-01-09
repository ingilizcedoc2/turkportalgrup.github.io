<?php
$link = "https://master.tvizlehd.com/ahaber.m3u8";
$veri = file_get_contents($link);
preg_match('@\file: \'(.*?)\'@s',$veri,$veritemp);
 
