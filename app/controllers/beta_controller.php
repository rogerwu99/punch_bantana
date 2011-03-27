<?php
App::import('Vendor', 'simplegeo', array('file' => 'SimpleGeo.php'));
class BetaController extends AppController 
{
    var $name = 'Beta';
    var $uses = array('User', 'Mail','Reward'); 
    var $helpers = array('Html', 'Form', 'Javascript', 'Xml', 'Crumb', 'Ajax');
    var $components = array('Utils', 'Email', 'RequestHandler');
   
    function index($id=null)
    {
	 	if(is_null($this->Auth->getUserId())){
         	Controller::render('/deny');
        }
		$this->User->recursive = -1;
	   	$user = $this->Auth->getUserInfo();
		$this->set(compact('user'));
		
		$this->redirect(array('action'=>'view_my_profile'));
	 }
    
    
    function view_my_profile($page = 1)
    {
		
		if(is_null($this->Auth->getUserId())){
        	Controller::render('/deny');
        }
		$this->redirect(array('controller'=>'users','action'=>'view_my_profile'));
	}
			
    
    function view_my_location($page = 1)
    {
		$my_long=$this->Session->read('my_long');
		$my_lat=$this->Session->read('my_lat');
		$my_address = $this->Session->read('my_address');
		if(is_null($this->Auth->getUserId())){
        	Controller::render('/deny');
        }
		$id = $this->Auth->getUserId();
        $profile = $this->User->findById($id);
		if ($my_long=='' && $my_lat=='' && trim($my_address)==''){
			$client = new Services_SimpleGeo('ZJNHYqVpyus8vEwG357mRa8Eh7gwq4WN','yzgWLLsY8QqAB3c2bDhNSCSbDDERaV8E');
			$ip=$_SERVER['REMOTE_ADDR'];
			if ($ip=='::1') {
				$results = $client->getContextFromIPAddress();
			}
			else {
				$results = $client->getContextFromIPAddress($ip);
			}
			$url = "http://where.yahooapis.com/geocode?q=".$results->query->latitude.",".$results->query->longitude."&gflags=R&flags=J&appid=cENXMi4g";
			$address = json_decode(file_get_contents($url));
			$full_address = $address->ResultSet->Results[0]->line1." ".$address->ResultSet->Results[0]->line2;
			$this->set('simplegeo_address',$full_address);
			$this->set('simplegeo_lat',$results->query->latitude);
			$this->set('simplegeo_long',$results->query->longitude);
			$this->Session->write('my_lat',$results->query->latitude);
			$this->Session->write('my_long',$results->query->longitude);
			$this->Session->write('my_address',$full_address);
			$this->set('show_discounts',true);
		}
		else{
			$this->set('simplegeo_address',$my_address);
			$this->set('simplegeo_lat',$my_lat);
			$this->set('simplegeo_long',$my_long);
			$this->set('show_discounts',true);
		}	
    }
	function manual_location(){
		if(is_null($this->Auth->getUserId())){
        	Controller::render('/deny');
        }
		$url="http://local.yahooapis.com/MapsService/V1/geocode?appid=89YEQTHIkY2SU4r0q7se6KONjW1X8WhRKA--&street=".urlencode($this->data['Beta']['Address']);
		$xmlObject = simplexml_load_string(file_get_contents($url));
		$lat= (string) $xmlObject->Result->Latitude;
		$long=(string) $xmlObject->Result->Longitude;
		$this->Session->write('my_lat',$lat);
		$this->Session->write('my_long',$long);
		$this->Session->write('my_address',$this->data['Beta']['Address']);
		$this->set('address',$this->data['Beta']['Address']);
		$this->set(compact('lat'));
		$this->set(compact('long'));
	}
	function getLocation(){
		$results = $this->params['url'];
		// this function is for auto finding.
		$this->Session->write('my_lat',$results['latitude']);
		$this->Session->write('my_long',$resuls['longitude']);
		$url = "http://where.yahooapis.com/geocode?q=".$results['latitude'].",".$results['longitude']."&gflags=R&flags=J&appid=cENXMi4g";
		$address = json_decode(file_get_contents($url));
		$full_address = $address->ResultSet->Results[0]->line1." ".$address->ResultSet->Results[0]->line2;
		$this->Session->write('my_address',$full_address);
		$this->set('address',$full_address);		
	}
	function addTokens(){
		/*
			1 - 100 tokens ($5.00)
			2 - 250 tokens ($10.00)
			3 - 500 tokens ($18.00)
			4 - 1000 tokens ($31.00)
		
		*/
		
		if (!empty($this->data)) {
			$tokens = $this->data['Beta']['buy_more_tokens'];
			$bills = $this->data['Beta']['buy_more_bills'];
			switch($this->data['Beta']['buy_more_tokens']){
				case 1:
					$valtok=5;
					break;
				case 2:
					$valtok=10;
					break;
				case 3:
					$valtok=18;
					break;
				case 4:
					$valtok=31;
					break;
				default:
					$tokens=0;
			}
			$type = $tokens.'tok';
			switch($this->data['Beta']['buy_more_bills']){
				
				case 1:
					$valbill=5;
					break;
				case 2:
					$valbill=10;
					break;
				case 3:
					$valbill=18;
					break;
				case 4:
					$valbill=31;
					break;
				default:
					$bills = 0;
			}
	    	$type .= $bills.'bill';
			$val = $valtok + $valbill;
			
			$this->redirect(array('controller'=>'users','action'=>'expressCheckout',1,$val,$type));
		}
	}
    function code(){
		if (!empty($this->data)) {
			if ($this->data['DC']['text']=="2011SPR"){
				$this->set('starting','false');
			}
			else {
				$this->set('error','Unrecognized Code');
			}
		}
		$this->render('/elements/pay');
	
	}
}

?>
