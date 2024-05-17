<?php 

include 'vendor/autoload.php'; 
use InstagramMediaDownloader\ProfileDownloader;
$profile = new ProfileDownloader();
$result = $profile->getProfile('sohagsrz');
var_dump($result);