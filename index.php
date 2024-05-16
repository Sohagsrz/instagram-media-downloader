<?php 
include 'vendor/autoload.php'; 
use InstagramMedia\Downloader;
$downloader = new Downloader();
 
var_dump(
    $downloader->request('https://www.instagram.com/p/CS1J9Z2J9Z2/')
);