<?
class page_register_index extends Page {
    function init(){
        parent::init();
        
        echo "==1";
        if(!isset($_GET["error"])){
            echo "==2";
            
            if(isset($_GET["code"])){
                $code = $_GET["code"];    
        echo "==".$code;
                $url = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->api->getConfig('auth/facebook/app_id',0).'&redirect_uri='.urlencode('http://yoursite.com/fb_oauth_return.php').'&client_secret='.$this->api->getConfig('auth/facebook/app_secret',0).'&code='.$code;
                
        echo "==".$url;
                $curl_handle=curl_init();
                curl_setopt($curl_handle,CURLOPT_URL,$url);
                curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,6);
                curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
                $buffer = curl_exec($curl_handle);
                curl_close($curl_handle);    
                if(strpos($buffer, 'access_token=') === 0){
                    //if you requested offline acces save this token to db 
                    //for use later   
                    $token = str_replace('access_token=', '', $buffer);
                      
                    //this is just to demo how to use the token and 
                    //retrieves the users facebook_id
                    $url = 'https://graph.facebook.com/me/?access_token='.$token;
        echo "==".$url;
                    $curl_handle=curl_init();
                    curl_setopt($curl_handle,CURLOPT_URL,$url);
                    curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
                    curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
                    $buffer = curl_exec($curl_handle);
                    curl_close($curl_handle);
                    $jobj = json_decode($buffer);
                    $facebook_id = $jobj->id;
        echo "==";print_r($jobj);
                    
                }else{
                    //do error stuff
                }
            }
        }else{
            // do error stuff
        }
    }

}