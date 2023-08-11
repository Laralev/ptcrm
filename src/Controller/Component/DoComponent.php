<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;

use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Mailer\Email; 
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;

class DoComponent extends Component {
	
	public function get($id, $params=null){
        $res='';
		switch($id){
				
			case 'uid':
				$res = md5(env('HTTP_USER_AGENT') .  env('REMOTE_ADDR'));
				break;
                
			case 'app_folder':
				$res = Configure::read('app_folder');
				break;
				
			case 'days':
				$res = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
				break;
				
			case 'gender':
				$res = [1=>__('female'), 2=>__('male')];
				break;
                
			case 'bool':
				$res = ["0"=>__("no"), "1"=>__("yes")];
				break;
                
			case 'salt':
				$res = Security::getSalt();
				break;
				
			case 'langs':
				$res = Configure::read('languages');
				break;
                
			case 'langs_ids':
				$res = Configure::read('languages_ids');
				break;

            default:
				$res = empty(Configure::read($id)) ? [] : Configure::read($id);
				break;
		}
		return $res;
	}
	
	public function cat($key)
    {
        return Configure::read($key);
	}

	public function get_last_rec_number($table, $tar='Auto_increment')
    {
        $conn = ConnectionManager::get('default');
        $dbName = Configure::read('isLocal') ? 'listings' : 'myhomeinturkey_listings';
        $q = $conn->execute("SHOW TABLE STATUS FROM `".$dbName."` WHERE `name` LIKE '".$table."' ")->fetchAll('assoc');
        // debug($q);die();
        return $q[0][$tar];
	}
    
    // function getCurrencyRate($from_to, $amount=1, $date='', $endDate='')
    // {
    //     $apikey_pr = 'pr_542cbbd95dbf4ee691bd4b107481b5ba';
    //     $apikey = 'e14995a81a15e151f3c6';//'d0c3570c67592dc00ef7';
    //     $url = ("https://free.currconv.com/api/v7/convert?q=".$from_to."&compact=ultra&apiKey=".$apikey."&date=".$date."&endDate=".$endDate);
    //     if(!$json = file_get_contents($url)){
    //         return false;
    //     }
    //     $obj = json_decode($json, true);
    //     return number_format($obj[$from_to], 3, '.', '');
    // }

    function getCurrencyRate($from_to, $amount=1, $date='')
    {
        $from_to_arr = explode('_', $from_to);
        $from = $from_to_arr[0];
        $to = $from_to_arr[1];
        
        $apikey = 'I4rgPzfUcIHUUfhiY3QoNtfAVrNz6W20';
        $url = ("https://api.apilayer.com/currency_data/convert?from={$from}&to={$to}&amount={$amount}&date={$date}&apikey={$apikey}");

        if(!$json = file_get_contents($url)){
            return false;
        }
        $obj = json_decode($json, true);
        
        return number_format($obj['result'], 3, '.', '');
    }
    
    function getCountryByIP($IP, $field=null)
    {
        if($IP == '127.0.0.1'){return 'Turkey';}
        $apikey = '383dd504dd30405480f368d0b32be23a';
        $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$apikey."&ip=".$IP;
        $json = file_get_contents($url);
        if(!$json){
            return $json;
        }
        $obj = json_decode($json, true);
        if($field){ return $obj[$field]; }
        return $obj;
    }

    public function getConf($key)
    {
		$model = TableRegistry::getTableLocator()->get('Configs');
        $isSearch = strpos($key, '%') === false ? '' : ' LIKE';
		$config = $model->find('all')->where([
            'config_key'.$isSearch=>$key
        ])->toArray();
        if( !(strpos($key, '%') === false) ){
            return $config;
        }
		return !empty($config[0]->config_value) ? $config[0]->config_value : null;
	}

    public function currencyConverter($from, $to, $sum)
    {
        if($from == $to){return $sum;}// no need convertion if the same currency
        if($from == 'USD'){// reverse db ratio and multiply it by sum
            $toReverse = 1 / $this->getConf($to.'_USD');
            return $sum * $toReverse;
        }
        if($to == 'USD'){// this match our ratio values from X to USD
            return $sum * $this->getConf($from.'_'.$to);
        }
        $toUsd = $sum * $this->getConf($from.'_USD');// convert X to USD
        $toReverse = 1 / $this->getConf($to.'_USD');// reverse db ratio
        return $toUsd * $toReverse;// multiplay with the sum
	}

    public function sendEmail($to=[], $subject='', $dt=[], $tmplt='default')
    {
        $email = new Email();
        $email->setFrom( ['noreplay@devzonia.com'=>__('sitename')] )
            ->setSubject($subject)
			->setTo( trim($to[0]) )
            ->setEmailFormat('html')
            ->setViewVars(['content' => $dt])
            ->viewBuilder()
                ->setLayout('default')
                ->setTemplate($tmplt);
        for($i=1; $i<count($to); $i++){
			$email->addTo( trim( $to[$i] ) );
		}
        if($email->send()){
            return true;
        }
        return false;
    }

    public function CookiesHandler($val, $operation='read')
    {
        if($operation=='read'){
            if(!isset($_COOKIE[$val])){return false;}
            $res = $_COOKIE[$val];
            if($res[0] == '[' || $res[0] == '{'){
                $res = json_decode($res, true);
            }
            return $res;
        }
        if($operation=='delete'){
            if(!isset($_COOKIE[$val])){return false;}
            setcookie($val, "", 
                strtotime('-1 hour'), 
                (empty($this->app_folder) ? '/' : $this->app_folder), 
                env('SERVER_NAME'), 
                false, 
                (env('SERVER_NAME') == 'localhost' ? true : false)
            );
            return null;
        }
        if($operation=='write'){
            if(!is_array($val)){return false;}
            $k = array_keys($val)[0];
            $v = array_values($val)[0];
            if(is_object( $v ) || is_array($v)){
                $v = json_encode($v, JSON_UNESCAPED_UNICODE);
            }
            if(!isset($_COOKIE[$v])){
                setcookie($k, $v.'', 
                    strtotime('+1 year'), 
                    (empty($this->app_folder) ? '/' : $this->app_folder), 
                    env('SERVER_NAME'), 
                    false, 
                    (env('SERVER_NAME') == 'localhost' ? true : false)
                );
            }else{
                $_COOKIE[$k] = $v;
            }
            return $this->CookiesHandler($k);
        }
        return null;
    }

	public function convertJson($obj){
        
        if(is_object($obj)){ $obj = $obj->toArray(); }
        
        $user = @$_SESSION['Auth']['User'];
        $obj_user_id = empty($obj['user_id']) ? null : $obj['user_id'];

        foreach($obj as $k=>&$elm){
            
            if($elm instanceof FrozenTime && $k == 'stat_updated'){ 
                if( 
                    date($elm->format('Y-m-d H:i:s')) < date("Y-m-d H:i:s", strtotime("-1 months")) &&
                        ( 
                            $user['id'] == $obj_user_id || 
                            in_array($user['user_role'], ['admin.admin', 'admin.root', 'admin.supervisor']) 
                        )
                    )
                { 
                    $obj['stat_expired'] = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s", strtotime("-1 months"))) - strtotime($elm));
                }
            }

            if(is_object($elm) && !($elm instanceof FrozenDate) && !($elm instanceof FrozenTime)){ 
                $elm = $elm->toArray(); 
            }

            // recurtion into sub arrays
            if(is_array($elm)){
                $elm = $this->convertJson($elm);
                continue ;
            }

            // convert json string into json obj
            if(is_string($elm)){
                if( in_array( $k, ['param_units_size_range'] ) ){
                    if( !isset( $elm[1]) ){ $elm = '0,0' ; }
                }else{
                    if(strlen($elm) == 0){ continue; }
                }
                if( $elm[0] == '{' || $elm[0] == '['){
                    $elm =  json_decode($elm, true);
                }
                if( in_array( $k, ['doc_allowed_roles', 'property_videos', 'property_usp', 'features_ids', 'project_photos', 'property_photos', 'param_units_size_range', 'param_unit_types', 'project_videos', 'seo_keywords'])){
                    $elm = array_filter( explode(",", $elm) );
                }
            }

            // convert date object into readable date
            if($elm instanceof FrozenTime){
                $elm = $elm->format('Y-m-d H:i:s');
            }

            // convert number to strings
            if(is_numeric($elm)){
                $elm = $elm.'';
            }
        }
        return $obj;
    }
    
	public function isBrowserSupported($returnObj=false){
        $u_agent = env('HTTP_USER_AGENT');
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
            $bname = 'IE';
            $ub = "MSIE";
        }elseif(preg_match('/Firefox/i',$u_agent)){
            $bname = 'Firefox';
            $ub = "Firefox";
        }elseif(preg_match('/OPR/i',$u_agent)){
            $bname = 'Opera';
            $ub = "Opera";
        }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
            $bname = 'Chrome';
            $ub = "Chrome";
        }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
            $bname = 'Safari';
            $ub = "Safari";
        }elseif(preg_match('/Netscape/i',$u_agent)){
            $bname = 'Netscape';
            $ub = "Netscape";
        }elseif(preg_match('/Edge/i',$u_agent)){
            $bname = 'Edge';
            $ub = "Edge";
        }elseif(preg_match('/Trident/i',$u_agent)){
            $bname = 'IE';
            $ub = "MSIE";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
        }
        $i = count($matches['browser']);
        if ($i != 1) {
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= @$matches['version'][0];
            }else {
                $version= @$matches['version'][1];
            }
        }else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        $b = array(
//            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
//            'pattern'    => $pattern
        );
        if($returnObj){ return $b; }
        $isSupported = true;
        if( $b['name'] == 'IE' ||  $b['name'] == 'Firefox' && $b['version'] < 45  ||  $b['name'] == 'Firefox' && $b['version'] < 53 ){
            $isSupported = false;
        }
        return $isSupported;
    }
    
	public function getExt($file)
    {
        $file_arr = explode(".", $file);
		$fileext = $file_arr[count($file_arr)-1];
		switch($fileext){
			case 'jpeg':
			case 'jpg':
			$res = 'jpg';
			break;
			
			default:
			$res = $fileext;
			break;
		}
		return $res;
	}

    public function slugger($url)
    {
        $url = trim($url);
        // $text = preg_replace('{(.)\1+}','$1',$url);
		$text = preg_replace('/ /', '-', $url);
		$text = preg_replace('/أ|إ|آ/', 'ا', $text);
		$text = preg_replace('/~/', '-', $text);
		$text = preg_replace('/`|\!|\@|\#|\^|\&|\(|\)|\|/', '', $text);
		$text = preg_replace('/{|}|\[|\]/', '', $text);
		$text = preg_replace('/\+|\*|\/|\=|\%|\$|×/', '', $text);
		$text = preg_replace('/,|\.|\'|;|\?|\؟|\<|\>|"|:/', '', $text);
		$text = preg_replace('/^_/', '', $text);
		$text = preg_replace('/_$/', '', $text);
		$text = preg_replace('/_/', '', $text);

        return (mb_strtolower($text, 'UTF-8'));
    }
    
    public function keywordMaker($t)
    {
		$text = preg_replace('{(.)\1+}','$1',$t);
		$text = preg_replace('/ /', ' ', $text);
		$text = preg_replace('/أ|إ|آ/', 'ا', $text);
		$text = preg_replace('/~/', ' ', $text);
		$text = preg_replace('/`|\!|\@|\#|\^|\&|\(|\)|\|/', '', $text);
		$text = preg_replace('/{|}|\[|\]/', '', $text);
		$text = preg_replace('/\+|\-|\*|\/|\=|\%|\$|×/', '', $text);
		$text = preg_replace('/,|\.|\'|;|\?|\<|\>|"|:/', '', $text);
		$text = preg_replace('/^_/', '', $text);
		$text = preg_replace('/_$/', '', $text);
		$text = preg_replace('/_/', '', $text);
		$valArr = explode(" ", $text);
		$res = [];

		foreach($valArr as $itm){
			if(strlen($itm)>3 && !in_array($itm, $res)){ 
				$res[] = $itm;
			}
		}
        
		return implode(",",$res);
    }

    public function getIP() 
    {
        $ip = env("REMOTE_ADDR");
        if( !empty( env("HTTP_CLIENT_IP") ) ) {
            $ip = env("HTTP_CLIENT_IP");
        } elseif( !empty( env("HTTP_X_FORWARDED_FOR") ) ) {
            $ip = env("HTTP_X_FORWARDED_FOR");
        }
        return $ip == '127.0.0.1' ? '46.2.228.144' : $ip;
    }

    public function getUinfo($isJson=true){
        $info = [
            "agent"=> $this->isBrowserSupported(true)["name"], 
            "ip"=>$this->getIP(), 
            "lang"=>@env('HTTP_ACCEPT_LANGUAGE'), 
            "connection"=>@env('HTTP_CONNECTION')
        ];
        return $isJson ? json_encode($info) : $info;
    }

	public function lcl($arr, $isComplex=false, $isKey=true){
		$res=[];
		foreach($arr as $k=>$v){
            if(is_array($v)){
                if($isComplex){
                    $res[$k] = $this->lcl( $v ); 
                }else{
                    foreach($v as $k2=>$v2){
                        $res[$isKey ? $k2 : $v2] = __($v2.'', true);
                    }
                }
                continue;
            }
			$res[$isKey ? $k : $v] = __($v.'', true);
		}
        asort($res);
		return $res;
	}
	
	public function setPW($length = 8, $type=1){
        $chrs = ["abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789", "0123456789"];
		$pass = array(); 
		$alphaLength = strlen($chrs[$type]) - 1; 
		for ($i = 0; $i < $length; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $chrs[$type][$n];
		}
		return implode($pass); 
    }
	
	public function getMachineLang($val=null){
        $langs = $this->get('langs');
        if(!$val){ return substr(env('HTTP_ACCEPT_LANGUAGE'), 0, 2); }
		foreach($langs as $lang){
			if(strpos($val, $lang) !== false){
				return $lang;
			}
		}
	}
	
	public function adder($dt, $mdl){

		$model = TableRegistry::getTableLocator()->get($mdl);
		$record = $model->newEmptyEntity();
        $errors = [];

        $newRecs = $saveNewRecs = [];
        $existRecs = $saveExistRecs = [];
        if(is_array(@$dt[0])){//save or update multiple records
            
            for($i=0; $i<count($dt); $i++){
                if(isset($dt[$i]['id'])){
                    $record = $model->get($dt[$i]['id']);
                    $existRecs[] = $model->patchEntity($record, $dt[$i]);
                }else{
                    $newRecs[] = $dt[$i];
                }
            }
            // return $newRecs;
            if(!empty($newRecs)){
                $saveNewRecs = $model->saveMany($model->newEntities($newRecs));
            }
            if(!empty($existRecs)){
                $saveExistRecs = $model->saveMany($existRecs);
            }
            if(!empty( $saveExistRecs ) || !empty( $saveNewRecs )){
                return $saveExistRecs + $saveNewRecs;
            }

            return false;
        }else{//save or update one record
            if(isset($dt['id'])){
                $record = $model->get($dt['id']);
            }
            foreach($dt as $k => $v){
                if($v == "--escape"){continue;}
                $record[$k] = $v;
            }
            if($newRec = $model->save($record)){
                return $newRec;
            }
            return false;
        }
	}
	
	public function captchaCheck($dt){
		$salt=Security::getSalt();
		$code = str_replace(substr($salt, 0, 21),'', $dt['CaptchaCodeSource']);
		$code = str_replace(substr($salt, 21),'', $code);
		if($code == @$dt['CaptchaCode']){
			return true;
		}
		return false;
	}
	
}

?>


