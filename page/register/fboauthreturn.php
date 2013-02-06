<?
class page_register_fboauthreturn extends Page {
    function init(){
        parent::init();
        
        if(!isset($_GET["error"])){
            
            if(isset($_GET["code"])){
                $code = $_GET["code"];    
                $url = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->api->getConfig('auth/facebook/app_id',0).'&redirect_uri='.urlencode('http://'.$_SERVER['HTTP_HOST'].'/register/fboauthreturn').'&client_secret='.$this->api->getConfig('auth/facebook/app_secret',0).'&code='.$code;
                
                $curl_handle=curl_init();
                curl_setopt($curl_handle,CURLOPT_URL,$url);
                curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,6);
                curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
                $buffer = curl_exec($curl_handle);
                curl_close($curl_handle);
echo $buffer.'---';
                if(strpos($buffer, 'access_token=') === 0){
                    //if you requested offline acces save this token to db 
                    //for use later   
                    $token = str_replace('access_token=', '', $buffer);
                    $expires='';
                    if(strpos($token, '&expires=') > 0){
                        $token=substr($token,0,strpos($token, '&expires='));
                        $expires=substr($token,strpos($token,'&expires=')+8,50);
                    }
echo"--<br />".$token."<br />--".$expires.'<br />--';
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
