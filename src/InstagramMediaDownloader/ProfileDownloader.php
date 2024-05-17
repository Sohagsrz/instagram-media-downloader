<?php 
namespace InstagramMediaDownloader;
use InstagramMediaDownloader\Downloader;
class ProfileDownloader extends Downloader
{
    
    function __construct() {
        parent::__construct();
    }
    public function getProfile($username): array {
        $url= "https://i.instagram.com/api/v1/users/web_profile_info/?username=$username";
        parent::set_user_agent('Instagram 273.0.0.16.70 (iPad13,8; iOS 16_3; en_US; en-US; scale=2.00; 2048x2732; 452417278) AppleWebKit/420+');
        
        $data= $this->request($url);
         
        if($data['status'] == 200){
            $data = json_decode($data['result'], true);
             
            if(isset($data['data']['user']) 
            && is_array($data['data']['user'])
            && !is_null($data['data']['user'])){ 
                
                $this->result = $data['data']['user'];
            }else{
                $this->status = 404;
                $this->result = ['error' => 'User not found'];
            }
        }else{
            $this->status = $data['status'];
            $this->result = ['error' => 'User not found'];
        }
        
        return $this->result;
        
    }
}