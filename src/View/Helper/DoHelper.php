<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
//use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\View\Helper\HtmlHelper;

class DoHelper extends Helper{
	
	public function get($id){
        
		switch($id){
				
			case 'uid':
				$res = md5($_SERVER['HTTP_USER_AGENT'] .  $_SERVER['REMOTE_ADDR']);
				break;

			case 'bool':
				$res = [1=>__("enabled"), 0=>__("disabled")];
				break;
				
			case 'days':
				$res = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
				break;
				
			case 'socialmedia':
				$res = ['whatsapp', 'facebook', 'twitter', 'linkedin', 'instagram'];
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
	
	public function cat($key){
        return Configure::read($key);
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
        // asort($res);
		return $res;
	}
	
	public function DtSetter($v, $k, $prefix=null){
		if(empty( $v ) && $v != 0){return $v;}
		if(!$prefix){
			$prefix = $this->_View->getName() == 'Properties' ? 'PROP' : 'PROJ';
		}
        if(in_array($k, ["stat_ip", "user_ip"])){ 
            $v = "<a href='https://whatismyipaddress.com/ip/".$v."' target='new'>".$v."</a>";
        }
        if(in_array($k, ["bool"])){ 
            $v = ($v*1) == 1 ? __("yes") : __("no");
        }
        if( $k == "bool2" ){
            $v = ($v*1) == 1 ? "<i class='fa fa-check-circle greenText'></i>" : "<i class='fa fa-times-circle redText'></i>";
        }
        if(in_array($k, ["user_role"])){ 
            $v = __($v);
        }
        if(in_array($k, ["seo_keywords"])){
			if(!is_array( $v )){return $v;}
            $v = implode(',', $v);
        }
        if(in_array($k, ["stat_created", "stat_updated", "stat_publish_at", "stat_lastlogin"])){ 
            $v = !empty($v) ? $v->format("Y-m-d H:i:s") : $v;
        }
        if($k == "language_id"){ 
            $v = !empty($this->get('langs')[$v]) ? __($this->get('langs')[$v]) : $v;
        }
        if($k == "property_currency"){ 
            $v = !empty($this->get('currencies')[$v]) ? __($this->get('currencies')[$v]) : $v;
        }
        if($k == "rec_state"){ 
            $vals = ["disabled", "enabled"];
            $v = __($vals[$v]);
        }
        if(in_array($k, ["param_space", "param_totalunits", "property_price", "property_oldprice", "param_monthlytax", "param_deposit", "param_grossspace", "param_netspace"])){
			$units = ["param_space"=>"m2", "param_totalunits"=>"unit", "property_price"=>"", "property_oldprice"=>"", "param_monthlytax"=>"tl", "param_deposit"=>"tl", "param_grossspace"=>"m2", "param_netspace"=>"m2"];
			if(!empty( $v )){
				$v = $this->num($v).' '.__( $units[$k] );
			}
		}
        if(in_array($k, ["category_id"])){
			$cats = Configure::read($prefix.'_CATEGORIES');
			$v = __( $cats[$v] );
		}
        if(in_array($k, ["features_ids"])){
			
			$cats_prop = $this->lcl ($this->cat('PROP_FEATURES')) ;
			$cats_proj = $this->lcl ($this->cat('PROJ_FEATURES')) ;
			$cats = $cats_prop + $cats_proj;

			$features = array_filter( explode(',', $v) );
			$res = '';
			foreach($features as $feature){
				$res .= '<span class="badge badge-warning">'.__( empty($cats[$feature]) ? $feature : $cats[$feature]).'</span> &nbsp;';
			}
			$v = $res;
		}
        if(in_array($k, ["property_loc", "project_loc"])){
			$gmapKey = Configure::read('gmapKey');
			$v = "
			<div class='gmapImg'>
				<img style='max-width:600px' ng-src='https://maps.googleapis.com/maps/api/staticmap?center=".$v."&zoom=10&size=600x300&maptype=roadmap&markers=color:green%7Clabel:S%7C".$v."&key=".$gmapKey."'/>
			</div>";
		}
        if(in_array($k, ["property_photos", "project_photos"])){
            $pth = strtolower($this->_View->getName());
			$imgs = explode(',', $v);
			$res = '';
			foreach($imgs as $img){
				$res .= '<span class="thumb-img">'.$this->_View->Html->image("/img/".$pth."_photos/thumb/".$img,  ["style"=>"height:70px", "show-img"=>""]).'</span>';
			}
			$v = $res;
        }
        if(strpos( $k, "param_" ) !== false && !in_array($k, ["param_deliverdate", "param_totalunits", "param_space", "property_price", "property_oldprice", "param_monthlytax", "param_deposit", "param_grossspace", "param_netspace"])){
			if(!empty($v)){
				$cats = $this->lcl ($this->cat($prefix.'_SPECS')) ;
				if(isset($cats[ $v ])){
					$v = __( $cats[ $v ] );
				}
			}
		}
        return $v;
    }
    
	public function convertJson($obj){
        $res = $obj->toArray();
		foreach($res as $key=>$elm){
            if(is_array($elm)){
                foreach($elm as $subKey => $subElm){
                    foreach($subElm as $subSubKey => $subSubElm){
                        if(is_string($subSubElm) ){
                            $jsonElm = json_decode($subSubElm, JSON_UNESCAPED_UNICODE);
                            if((json_last_error() == JSON_ERROR_NONE)){ 
                                $res[$key][$subKey][$subSubKey] = $jsonElm;
                            }
                        }
                    }
                }
            }
            if(is_string($elm) ){
                $jsonElm = json_decode($elm, JSON_UNESCAPED_UNICODE);
                if((json_last_error() == JSON_ERROR_NONE)){ 
                    $res[$key] = $jsonElm;
                }
            }
		}
	}

	
	public function getMachineLang($val){
		foreach(Configure::read('I18n.languages') as $lang){
			if(strpos($val, $lang) !== false){
				return $lang;
			}
		}
	}

    
	public function adrs($text){
		$AddHtmlEnd = false;
		$text = trim ($text);
		//$text = preg_replace('{(.)\2+}','$1',$text); 
        $text = preg_replace('{( ?.)\1{2,}}','$1$1',$text);
		$text = preg_replace('/ /', '_', $text);
		$text = preg_replace('/أ|إ|آ/', 'ا', $text);
		$text = preg_replace('/~/', '_', $text);
		$text = preg_replace('/`|\!|\@|\#|\^|\&|\(|\)|\|/', '', $text);
		$text = preg_replace('/{|}|\[|\]/', '_', $text);
		$text = preg_replace('/\+|\*|\/|\=|\%|\$|×/', '', $text);
		$text = preg_replace('/,|\.|\'|;|\?|\<|\>|"|:/', '', $text);
		$text = preg_replace('/^_/', '', $text);
		$text = preg_replace('/_$/', '', $text);
		$text = preg_replace('/_/', '-', $text);
		if ($AddHtmlEnd) {
			$text .= '.html';
		}
		return strtolower($text);
	}
	
	public function appendURL($var, $cond=false){
		$url_arr = @explode('?', $_SERVER['REQUEST_URI']);
		$url = @explode('&', $url_arr[1]) ;
		if (empty($url)) {  return false;  }
		if($cond == 'array'){
			return $url;
		}
		if($cond == 'remove'){
			$ind = array_search($var, $url);
			unset($url[$ind]);
		}else{
			array_push($url, $var);
		}
		$newurl=[]; $complex_arr=[];
		foreach($url as $uVal){
			$ind = @explode('=',$uVal);
			if(!empty($ind[0])){
				$complex_arr[$ind[0]] = [ $ind[0], $ind[1] ];
			}
		}
		
		foreach($complex_arr as $itm){
			$newurl[]= $itm[0].'='.$itm[1] ;
		}
		
		if($cond == 'params'){
			return '?'.implode('&',$newurl);
		}
		return $url_arr[0].'?'.implode('&',$newurl);
	}
    
    public function captcha($tar, $lbl=false, $type='numeric', $chars = 4){
		$salt=Security::getSalt();
//		$secretSource = $this->gen_secret('','','source');
//		$secret = $this->gen_secret();
		$canvas_w = $chars * 20;
		
		echo "
        <table style='width:auto;'>
            <tr>
                <td>
                    <div id='inp".$tar."'></div>".
            
                        $this->_View->Form->control('CaptchaCode'.$tar, 
                             ['id'=>'CaptchaCode'.$tar, 
                              'name'=>'CaptchaCode'.$tar,
                              'ng-model'=>'CaptchaCode'.$tar,
//                              'dt-src'=>$secretSource, 
                              
                              'style'=>'width:120px;display:block-inline;', 
                              'label'=>false,  
                              'maxlength'=>$chars, 
                              'placeholder'=>__('CaptchaCode'), 
                              'class'=>'form-control text-center'])."
                </td>
                <td style='vertical-align: top; padding: 3px'>
                    <a href=\"javascript:void(0);\" onclick=\"setCaptcha('".$salt."', '".$tar."','".$type."', ".$chars.");\" title='".__('click_to_refresh')."' id='captcha_btn_".$tar."' style='height:28px; display:block'>
                        <canvas width='".$canvas_w."' height='30' id='can".$tar."' style='direction:ltr; display:block-inline;'></canvas>
                    </a>
                </td>
            </tr>
        </table>
        
        <script> 
            $( document ).ready(function() {
              setCaptcha('".$salt."', '".$tar."','".$type."', ".$chars.");
            });
        </script>";
	}
	
	public function num($num){
		return number_format(floor($num),0,".",".");
	}
	
}

?>
