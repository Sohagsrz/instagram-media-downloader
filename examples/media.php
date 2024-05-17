<?php 
include '../vendor/autoload.php';
use InstagramMediaDownloader\Downloader;
$downloader = new Downloader();
// $downloader->withProxy();
// $downloader->setProxy(
//     'proxy.example.com',
//     'username',
//     'password'
// );
// $downloader->set_user_agent('Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0');
$result = $downloader->get_by_shortcode('C16ErQiLCJm');
    
var_dump($result);