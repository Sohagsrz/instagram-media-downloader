<?php 
namespace InstagramMediaDownloader;

class Downloader
{
    // $result holds the result of the media download
    public $result;

    // $status holds the HTTP status code of the download operation
    public $status;
    // user agent
    public $user_agent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0';


    // $is_proxy indicates whether a proxy is being used for the download
    public $is_proxy = false;

    // $proxy holds the proxy settings if a proxy is being used
    public $proxy = [
        'ip' =>'',    // IP address of the proxy
        'user' => '', // Username for the proxy
        'pass' => ''  // Password for the proxy
    ];

    // The constructor initializes the $result as an empty array and $status as 200
    function __construct(){
        $this->result = [];
        $this->status = 200;
    }
    public function withProxy(){
        $this->is_proxy = true;
    }
    public function setProxy($ip, $user, $pass){
        $this->proxy['ip'] = $ip;
        $this->proxy['user'] = $user;
        $this->proxy['pass'] = $pass;
    }
    public function set_user_agent($user_agent){
        $this->user_agent = $user_agent;
    }
    
    
    public function request($url): array {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        //usern agent 
        curl_setopt($ch, CURLOPT_USERAGENT,  $this->user_agent );
        
        curl_setopt($ch, CURLOPT_HEADER, 1);
    
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if($this->is_proxy){ 
        
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy['ip']);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy['user'].":".$this->proxy['pass']);
        }
        $headers = array();
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            return ['status'=> $httpcode, 'result' => curl_error($ch)];
        }
        // Then, after your curl_exec call:
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);
        $header = substr($result, 0, $header_size);
        $result = substr($result, $header_size);
        return ['status'=> $httpcode, 'result' => $result];
    }
    public function get_by_shortcode($id){
        $params = http_build_query(['query_hash' => '2b0673e0dc4580674a88d426fe00ea90', 'variables' => json_encode([ 
            'shortcode' => $id,
        ])]);
        //random sub domains
        $sub_domains = ['www','api','i'];
        $rand_sub_domain = $sub_domains[array_rand($sub_domains)];
        
        // url build 
        $url = 'https://'.$rand_sub_domain.'.instagram.com/graphql/query/?'. $params;
        $data =  $this->request($url);
        if($data['status'] == 200){
            $data = json_decode($data['result'], true);
            if(isset($data['data']['shortcode_media']) && is_array($data['data']['shortcode_media'])
            && !is_null($data['data']['shortcode_media'])){
                $this->result = $data['data']['shortcode_media'];
            }else{
                $this->status = 404;
                $this->result = $data['result'];
            }
        }else{
            $this->status = $data['status'];
            $this->result = $data['result'];
        }
        
        return $this->result;
    }
    public function get_status(){
        return $this->status;
    }  
    public function get_result() : array {
        return $this->result;
    }
}