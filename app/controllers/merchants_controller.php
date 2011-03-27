<?php
App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));
App::import('Vendor', 'facebook');
App::import('Vendor', 'qrcode', array('file'=> 'qrcode'.DS.'phpqrcode.php'));


class MerchantsController extends AppController {

	var $name = 'Merchants';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $components = array('Auth', 'Email','Paypal');//,'Ssl');
	var $uses = array('Merchant', 'Mail', 'Reward','Location');
	//var $facebook;
	//var $twitter_id;

	function _login($username=null, $password=null)
	{
		if ($username && $password){
			$user_record_1=array();
			$user_record_1['Auth']['username']=$username;
			$user_record_1['Auth']['password']=$password;
			$this->Auth->user_model_name = 'Merchant';
			$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
			return;		
		}
	}
	
	function login()
	{
		$this->_login($this->data['Auth']['username'],$this->Auth->hasher($this->data['Auth']['password']));
		$this->redirect(array('action'=>'dashboard'));
	}
	
	function register()
	{
		if(!is_null($this->Auth->getUserId())){
        	$this->redirect('/');  	
		}
		if (!empty($this->data)){
			$email = $this->data['Merchant']['email'];
			$name=$this->data['Merchant']['name'];
			$password = $this->data['Merchant']['new_password'];
			$confirm =$this->data['Merchant']['confirm_password'];
			$accept = $this->data['Merchant']['accept'];
			$this->data=array();
			$this->Merchant->create();
			$this->data['Merchant']['name']=$name;
			$this->data['Merchant']['email'] = (string) $email;
			$this->data['Merchant']['new_password']=$password;
			$this->data['Merchant']['confirm_password']=$confirm;
			$this->data['Merchant']['accept']=$accept;
			$password = $this->data['Merchant']['password'] = $this->Auth->hasher($password); 
			$username = $this->data['Merchant']['username']= (string) $email;
			$this->data['Merchant']['path']='default.png';
			$this->Merchant->set($this->data);
			if ($this->Merchant->validates()){
				$this->Merchant->save();
				$this->_login($username,$password);
				$this->redirect('/users/expressCheckout/1/'.$plan_value.'/co');
			}
			else {
				$this->set('errors', $this->Merchant->validationErrors);
				unset($this->data['Merchant']['new_password']);
		    	unset($this->data['Merchant']['confirm_password']);
			}
		}
		else {
			$this->set('starting',false);
			$this->render();
		}
	}
	
	function logout()
	{
		$user=$this->Auth->getUserInfo();
		$this->Session->destroy();
		if(!empty($session)){
			$this->Auth->logout($url);
		}
		else {
		    $this->Auth->logout();
		}
	}
	private function createConsumer() {
        return new OAuth_Consumer('3PnqSPtc9vf4jj9sXehROw', 'eY8760Xe74NupOEq4Ey9wzp1rahNo85QCXQ8dAtNCq8');
    }
	private function createFacebook(){
		return new Facebook(array(
			'appId'=>'175485662472361',
			'secret'=>'4b66d239e574be89813bba4457b97a36',
			'cookie'=>true
		));
	}
	function getRequestURL(){
		$consumer=$this->createConsumer();
		$requestToken = $consumer->getRequestToken('http://twitter.com/oauth/request_token', ROOT_URL.'/users/twitterCallback');
  		$this->Session->write('twitter_request_token', $requestToken);
		$this->redirect('http://twitter.com/oauth/authenticate?oauth_token='.$requestToken->key);
		exit();
	}
	
	function twitterCallback() {
		$requestToken = $this->Session->read('twitter_request_token');
		$consumer = $this->createConsumer();
		$accessToken = $consumer->getAccessToken('http://twitter.com/oauth/access_token', $requestToken);
		$this->Session->write('twitter_access_token',$accessToken);
		$db_results = $this->User->find('first', array('conditions' => (array('User.tw_access_key'=>$accessToken->key)), 'fields'=>(array('User.username', 'User.password'))));
		if (!empty($db_results)) {
			$this->_login($db_results['User']['username'],$db_results['User']['password']);
			$this->redirect('/');
		}
		$this->layout = 'about';
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
	function view_my_profile(){
		$root_url =ROOT_URL;
		$id = $this->Auth->getUserId();
        $results = $this->User->find('first', array('conditions' => (array('User.id'=>$id))));
		$image_link = ''; 
		$image_can_change = false;
		if ($results['User']['fb_pic_url']==''){
			$image_link=$root_url.'/img/uploads/'.$results['User']['path'];
			$image_can_change = true;
		}
		else {
			$image_link = $results['User']['fb_pic_url'];
		}
		$this->set('image_can_change', $image_can_change);
		$this->set('image_link', $image_link);
		$this->set(compact('results'));
		$disc_array=array();
		$disc_desc=array();
		$db_results=$this->Reward->find('all',array('conditions'=>array('Reward.id'=>$id)));
		if (!empty($db_results)) {
			foreach ($db_results as $key=>$value){
				/*if ($db_results[$key]['Redeem']['hidden']!=1){
					//$disc_results = $this->Discount->findById($db_results[$key]['Redeem']['disc_id']);
					$disc_user = $this->User->findById($disc_results['Discount']['user_id']);
					array_push($disc_array,$disc_results);
					array_push($disc_desc,$disc_user);
			
				}*/
			}
			//$this->set('d_desc',$disc_desc);
			//$this->set('d_results',$disc_array);
		}
		else {
			$this->set('none',true);
		}
		$this->render();
	}
	
	function dashboard(){
		if(is_null($this->Auth->getUserId())){
        	Controller::render('/deny');
        }
		$rewards = $this->Reward->getRewards($this->Auth->getUserId());
		$this->set('reward_list',$rewards[0]['Reward']);
		$locations = $this->Location->getLocations($this->Auth->getUserId());
		$this->set('location_list',$locations);
		//$client = new Services_SimpleGeo('ZJNHYqVpyus8vEwG357mRa8Eh7gwq4WN','yzgWLLsY8QqAB3c2bDhNSCSbDDERaV8E');
			
	}
	function locations(){
		if(is_null($this->Auth->getUserId())){
          	Controller::render('/deny');
        }
		if (!empty($this->data)){
			$parent = $this->Auth->getUserInfo();
			$address_raw = $this->data['Merchant']['Address'];
			$address1 = urlencode($this->data['Merchant']['Address']);
			$city = $this->data['Merchant']['City'];
			$state = $this->data['Merchant']['State'];
			$name=$this->data['Merchant']['name'];
			$this->data=array();
			$this->Location->create();
			$this->data['Location']['description']=$name;
			$this->data['Location']['address']=$address_raw;
			$this->data['Location']['merchant_id']=$this->Auth->getUserId();
			$url = "http://where.yahooapis.com/geocode?line1=".$address1."&line2=".urlencode($city).",+".$state."&gflags=L&flags=J&appid=cENXMi4g";
			$address = json_decode(file_get_contents($url));
			$lat = $address->ResultSet->Results[0]->latitude;
			$long = $address->ResultSet->Results[0]->longitude;
			$zip = $address->ResultSet->Results[0]->uzip;
			$this->data['Location']['lat']=$lat;
			$this->data['Location']['long']=$long;
			
			$this->data['Location']['zip']=$zip;
			$this->set(compact('lat'));
			$this->set(compact('long'));
			$this->set('confirm','true');
			$this->Location->save($this->data);
		}
		else {
				$states = array(
							"AK"=>"AK",
							"AL"=>"AL",
							"AR"=>"AR",
							"AZ"=>"AZ",
							"CA"=>"CA",
							"CO"=>"CO",
							"CT"=>"CT",
							"DC"=>"DC",
							"DE"=>"DE",
							"FL"=>"FL",
							"GA"=>"GA",
							"HI"=>"HI",
							"IA"=>"IA",
							"ID"=>"ID",
							"IL"=>"IL",
							"IN"=>"IN",
							"KS"=>"KS",
							"KY"=>"KY",
							"LA"=>"LA",
							"MA"=>"MA",
							"MD"=>"MD",	
							"ME"=>"ME",
							"MI"=>"MI",
							"MN"=>"MN",
							"MO"=>"MO",
							"MS"=>"MS",
							"MT"=>"MT",
							"NC"=>"NC",
							"ND"=>"ND",
							"NE"=>"NE",
							"NH"=>"NH",
							"NJ"=>"NJ",
							"NM"=>"NM",
							"NV"=>"NV",
							"NY"=>"NY",
							"OH"=>"OH",
							"OK"=>"OK",
							"OR"=>"OR",
							"PA"=>"PA",
							"RI"=>"RI",
							"SC"=>"SC",
							"SD"=>"SD",
							"TN"=>"TN",
							"TX"=>"TX",
							"UT"=>"UT",
							"VA"=>"VA",
							"VT"=>"VT",
							"WA"=>"WA",
							"WI"=>"WI",
							"WV"=>"WV",
							"WY"=>"WY"
							);
			$this->set(compact('states'));
			$this->render();
		}	
		
		
	}
	function edit_location($id=null){
		if (!empty($this->data)){
			$parent = $this->Auth->getUserInfo();
			$name = $this->data['Location']['Description'];
			$address_raw = $this->data['Location']['Address'];
			$zip=$this->data['Location']['Zip'];
		
			$this->data=array();
			$this->Location->read(null, $id);
			$url = "http://where.yahooapis.com/geocode?line1=".urlencode($address_raw)."&line2=".$zip."&gflags=L&flags=J&appid=cENXMi4g";
			$address = json_decode(file_get_contents($url));
			$lat = $address->ResultSet->Results[0]->latitude;
			$long = $address->ResultSet->Results[0]->longitude;
			$zip = $address->ResultSet->Results[0]->uzip;
			$this->Location->set(array(
									   'description'=> $name,
									   'address'=> $address_raw,
									   'zip'=>$zip,
									   'lat'=>$lat,
									   'long'=>$long
									   ));
			$this->Location->save();
			$results = $this->Location->read(null,$id);
			$this->set(compact('results'));
			$this->set('editing',false);		
		}
		else {
			$this->set('editing', true);
			$this->set('div_id',$id);
			$results = $this->Location->read(null, $id);
			$this->set(compact('results'));
			$this->render();
		}	
		
	}
	function delete_location($id=null){
	 		if(is_null($this->Auth->getUserId())){
              Controller::render('/deny');
         }
		 else {
			// should make sure that the user_id matches the owner_id
	
		$this->Location->read(null, $id);
		$this->data['Location']['deleted']=1;
			$this->Location->save($this->data);
		$this->redirect(array('action'=>'dashboard'));
	} 
		}
	
	function rewards(){
		if(is_null($this->Auth->getUserId())){
          	Controller::render('/deny');
        }
		if (!empty($this->data)){
			var_dump($this->data);
			$parent = $this->Auth->getUserInfo();
			$reward = $this->data['Merchant']['reward'];
			$points = $this->data['Merchant']['points'];
			$start=$this->data['Merchant']['start'];
			$start_month=$this->data['Merchant']['smonth'];
			$start_date=$this->data['Merchant']['sdate']+1;
			$start_year=$this->data['Merchant']['syear']+date('Y');
			$expire=$this->data['Merchant']['expires'];
			$expire_month=$this->data['Merchant']['emonth'];
			$expire_date=$this->data['Merchant']['edate']+1;
			$expire_year=$this->data['Merchant']['eyear']+date('Y');
			
			$this->data=array();
			$this->Reward->create();
			$this->data['Reward']['description']=$reward;
			$this->data['Reward']['threshold']=$points;
			$this->data['Merchant']['id']=$this->Auth->getUserId();
			if ($start=="Now") $starting = date('Ymd');
			else $starting = date('Ymd',$start_year.'-'.$start_month.'-'.$start_date);
			$this->data['Reward']['start_date']=$starting;
	
			if ($expire!="No") $this->data['Reward']['end_date'] = $expire_year.' '.$expire_month.' '.$expire_date;
			var_dump($this->data);
			$this->set('confirm','true');
			$this->Reward->save($this->data, false);
			
		}
		else {
				$months = array(
							"Jan"=>"Jan",
							"Feb"=>"Feb",
							"Mar"=>"Mar",
							"Apr"=>"Apr",
							"May"=>"May",
							"Jun"=>"Jun",
							"Jul"=>"Jul",
							"Aug"=>"Aug",
							"Sep"=>"Sep",
							"Oct"=>"Oct",
							"Nov"=>"Nov",
							"Dec"=>"Dec"
							);
				$this->set(compact('months'));
				$this->set('dates',range(1,31));
				$this->set('years',range((int)date('Y'),2020));
				
				
				$this->render();
			}	
		}
		function edit_reward($id=null){
			if (!empty($this->data)){
				$start_month=$this->data['Reward']['smonth'];
				$start_date=(int)$this->data['Reward']['sdate']+1;
				$start_year=$this->data['Reward']['syear']+date('Y');
				$expire=$this->data['Reward']['expires'];
				$expire_month=$this->data['Reward']['emonth'];
				$expire_date=$this->data['Reward']['edate']+1;
				$expire_year=$this->data['Reward']['eyear']+date('Y');
				$this->Reward->read(null, $id);
				$starting = date('Ymd',strtotime($start_date.' '.$start_month.' '.$start_year));
				if ($expire!="No") $end_date = $expire_year.' '.$expire_month.' '.$expire_date;
				$this->Reward->set(array(
									   'description'=> $this->data['Reward']['description'],
									   'threshold'=> $this->data['Reward']['threshold'],
									   'start_date'=>$starting,
									   'end_date'=>$end_date
									   ));
				$this->Reward->save();
				$results = $this->Reward->read(null,$id);
				$this->set(compact('results'));
				$this->set('editing',false);		
			}
			else {
				$this->set('editing', true);
				$this->set('div_id',$id);
				$results = $this->Reward->read(null, $id);
				$months = array(
							"Jan"=>"Jan",
							"Feb"=>"Feb",
							"Mar"=>"Mar",
							"Apr"=>"Apr",
							"May"=>"May",
							"Jun"=>"Jun",
							"Jul"=>"Jul",
							"Aug"=>"Aug",
							"Sep"=>"Sep",
							"Oct"=>"Oct",
							"Nov"=>"Nov",
							"Dec"=>"Dec"
							);
				$this->set(compact('months'));
				$this->set('dates',range(1,31));
				$this->set('years',range((int)date('Y'),2020));
				$this->set(compact('results'));
				$this->render();
			}	
		
		}
		
		
		
		function delete_reward($id=null){
	 		if(is_null($this->Auth->getUserId())){
              Controller::render('/deny');
         }
		 else {
			// should make sure that the user_id matches the owner_id
	
		$this->Reward->read(null, $id);
		$this->data['Reward']['deleted']=1;
			$this->Reward->save($this->data);
		$this->redirect(array('action'=>'dashboard'));
	} 
		}
	function edit(){}
	
function expressCheckout($step=1,$amt=99.95,$type='co'){
 // $this->Ssl->force();
    $this->set('step',$step);
	 //first get a token
	if ($step==1){
        $paymentInfo['Order']['theTotal']= $amt;
        $paymentInfo['Order']['returnUrl']= ROOT_URL."/users/expressCheckout/2/".$amt."/".$type;
        $paymentInfo['Order']['cancelUrl']= ROOT_URL;
		
		if ($type=="co"){
	//		echo 'yes';
			$paymentInfo['Order']['L_BILLINGTYPE0']='RecurringPayments';
			$paymentInfo['Order']['L_BILLINGAGREEMENTDESCRIPTION0']='Premium subscription';
			$paymentInfo['Order']['theTotal']=0;
			  
		}
		
        // call paypal
        $result = $this->Paypal->processPayment($paymentInfo,"SetExpressCheckout");
        $ack = strtoupper($result["ACK"]);
    	    
		//var_dump( $result );
		
		//Detect Errors
        if($ack!="SUCCESS")
            $error = $result['L_LONGMESSAGE0'];
        else {
			// send user to paypal
            $token = urldecode($result["TOKEN"]);
            $payPalURL = PAYPAL_URL.$token;
            $this->redirect($payPalURL);
		 }
    }
    //next have the user confirm
    elseif($step==2){
		//we now have the payer id and token, using the token we should get the shipping address
        //of the payer. Compile all the info into the session then set for the view.
        //Add the order total also
		$result = $this->Paypal->processPayment($this->_get('token'),"GetExpressCheckoutDetails");
        
		$package = $result['AMT'];
		
		$result['PAYERID'] = $this->_get('PayerID');
        $result['TOKEN'] = $this->_get('token');
        $result['ORDERTOTAL'] = $package;
			
        $ack = strtoupper($result["ACK"]);
        //Detect errors
        if($ack!="SUCCESS"){
            $error = $result['L_LONGMESSAGE0'];
            $this->set('error',$error);
        }
        else {
            $this->set('result',$this->Session->read('result'));
			$this->Session->write('type',$type);
			if ($type == 'co'){
					$item = $this->_parsePackage($amt);
				$this->set('item',$item);
				$this->set('package',$amt);	
				$this->set('type',$type);
			}
			else if ($type=='coup') {
				$this->set('package',$amt);
				$item = $this->_parsePackage($amt);
				$this->set('item',$item);
				$this->set('type',$type);
			
			}
	
			else {
				$this->set('package',$package);
				$item = $this->_parseType($type);
				$this->set('item',$item);
				$this->set('type',$type);
	
			}
			$this->Session->write('result',$result);
            /*
             * Result at this point contains the below fields. This will be the result passed 
             * in Step 3. I used a session, but I suppose one could just use a hidden field
             * in the view:[TOKEN] [TIMESTAMP] [CORRELATIONID] [ACK] [VERSION] [BUILD] [EMAIL] [PAYERID]
             * [PAYERSTATUS]  [FIRSTNAME][LASTNAME] [COUNTRYCODE] [SHIPTONAME] [SHIPTOSTREET]
             * [SHIPTOCITY] [SHIPTOSTATE] [SHIPTOZIP] [SHIPTOCOUNTRYCODE] [SHIPTOCOUNTRYNAME]
             * [ADDRESSSTATUS] [ORDERTOTAL]
             */
      }
    }
    //show the confirmation
    elseif($step==3){
		
		
			$type = $this->Session->read('type');
			
			
			//echo $type;
			
			
			if ($type=='co'){
				$result = $this->Session->read('result');
		  		$result['BILLINGPERIOD'] = 'Month';
		  		$result['Description']= 'Premium subscription';
          		$result['BILLINGFREQUENCY']=1;
        		if (true){  //is there a trial period?
					$result['TRIALBILLINGPERIOD']='Month';
        			$result['TRIALBILLINGFREQUENCY']=1;
					$result['TRIALTOTALBILLINGCYCLES']=1;
        			$result['AMT']=$amt;
					$trial_amt = $amt*2;
        			$result['TRIALAMT']=$trial_amt;
				}
				$response = $this->Paypal->processPayment($result,"CreateRecurringPayments");
				
				$ack = strtoupper($response["ACK"]);
        		if($ack!="SUCCESS"){
            		$error = $response['L_LONGMESSAGE0'];
            		$this->set('error',$error);
					$this->logout();
					
					// need to delete this record
					
					
        		}
        		else {
            		$type = $this->Session->read('type');
					$plan_type = $this->_getPlanType($amt);
					$this->User->read(null,$this->Auth->getUserId());
					$this->User->set(array(
									'plan'=>$plan_type,
									'profile_id'=>$response["PROFILEID"]
									));
					$this->User->save();
					
	
					$this->redirect(array('controller'=>'mail', 'action'=>'send_welcome_message', $email, $joe));//$this->data['User']['name']));
			
				
			
			
				}

			}
			else if ($type=='coup') {
				//echo 'ooo';
				$user = $this->Auth->getUserInfo();
				$result['Description']='Premium subscription';
				$result['PROFILEID']=$user['profile_id'];
				$result['AMT']=$amt;
				if ($amt == 0) {
					// cancel the profile and delete the user
					$results = $this->Paypal->processPayment($result,"ManageRecurringPaymentsProfileStatus");
					$ack = strtoupper($results["ACK"]);
        			if($ack!="SUCCESS"){
            			$error = $results['L_LONGMESSAGE0'];
            			$this->set('error',$error);
        			}
        			else {
	        			$this->User->read(null,$this->Auth->getUserId());
						$this->User->set('plan',0);
						$this->User->save();
						$this->User->logout();
       				}
				}
				else {
					$results = $this->Paypal->processPayment($result,"UpdateRecurringPaymentsProfile");
					$ack = strtoupper($results["ACK"]);
        			if($ack!="SUCCESS"){
            			$error = $results['L_LONGMESSAGE0'];
            			$this->set('error',$error);
        			}
        			else {
            			$plan_type = $this->_getPlanType($amt);
						$this->User->read(null,$this->Auth->getUserId());
						$this->User->set('plan',$plan_type);
						$this->User->save();
       				}
				}
			}
			else {
				
				//for consumers 
	        	$result = $this->Paypal->processPayment($this->Session->read('result'),"DoExpressCheckoutPayment");
    
				// credit your account
				$ack = strtoupper($result["ACK"]);
        		if($ack!="SUCCESS"){
            		$error = $result['L_LONGMESSAGE0'];
            		$this->set('error',$error);
        		}
        		else {
            		$type = $this->Session->read('type');
					$this->_creditConsumerAccount($type);
	        		$this->set('result',$this->Session->read('result'));
       			}
				
			}
		}
	}
	
	/*
	public function register(){
		$email = $this->data['Users']['email'];
		$this->data=array();
		$this->User->create();
		$this->data['User']['email'] = (string) $email;
		$password = $this->data['User']['password']= $this->__randomString();
		$username = $this->data['User']['username']= (string) $email;
		$this->User->save($this->data);
		$this->_login($username,$password);
		$this->redirect(array('controller'=>'mail', 'action'=>'send_welcome_message', $email, $username));//$this->data['User']['name']));
		$this->redirect('/');
	
	}
	public function corporate(){
		$this->set('ranges',range(1,25)); 
	}
	
	public function corpReg(){
		if (!empty($this->data)){
			$email = $this->data['User']['email'];
			$address_raw = $this->data['User']['Address'];
			$address1 = str_replace('+','%20',urlencode($this->data['User']['Address']));
			$zip = $this->data['User']['Zip'];
			$range = $this->data['User']['Range'];
			$name=$this->data['User']['Name'];
			$password = $this->data['User']['new_password'];
			$confirm =$this->data['User']['confirm_password'];
			$this->data=array();
			$this->User->create();
			$this->data['User']['name']=$name;
			$this->data['User']['email'] = (string) $email;
			$this->data['User']['address']=$address_raw;
			$this->data['User']['range'] = $range;
			$this->data['User']['new_password']=$password;
			$this->data['User']['confirm_password']=$confirm;
			$url="http://local.yahooapis.com/MapsService/V1/geocode?appid=89YEQTHIkY2SU4r0q7se6KONjW1X8WhRKA--&street=".$address1."&zip=".$zip;
//http://where.yahooapis.com/geocode?q=1600+Pennsylvania+Avenue,+Washington,+DC&appid=[yourappidhere]
			$xmlObject = simplexml_load_string(file_get_contents($url));
			$lat=$xmlObject->Result->Latitude;
			$long=$xmlObject->Result->Longitude;
			$this->data['User']['longitude']=(float) $long;
			$this->data['User']['latitude']= $lat;
			$password = $this->data['User']['password'] = $this->Auth->hasher($password); 
			$username = $this->data['User']['username']= (string) $email;
			$this->data['User']['path']='default.png';
			if ($this->User->save($this->data)) { 
				$this->_login($username,$password);
			
			}	
			else { 
				$this->set('errors', $this->User->validationErrors);
				unset($this->data['User']['new_password']);
		    	unset($this->data['User']['confirm_password']);
			}
		}
		else {
			$this->render();
		}
	
	}
	
	
	
	public function verifyEmailAddress(){
		$type = $this->data['User']['oauth'];
		$email_address = $this->data['User']['Email'];
		$this->data = array();
		$this->User->create();
		$username='';
		$password='';
		$udpate = true;
		$db_results = $this->User->find('first', array('conditions' => (array('User.email'=>$email_address))));
		
		// i already have an account - i'm just updating the data with the 2nd social network
		if (!empty($db_results)) {
				$updated_id = $db_results['User']['id'];
				$this->User->read(null,$updated_id);
				switch ($type){
					case 'twitter':
		
						$accessToken=$this->Session->read('twitter_access_token');
						$consumer = $this->createConsumer();
						$content=$consumer->get($accessToken->key,$accessToken->secret,'http://twitter.com/account/verify_credentials.xml', array());
						$user = simplexml_load_string($content);
						$this->data['User']['twitter_handle'] = (string) $user->screen_name;
						$this->data['User']['tw_user_url'] = (string) $user->url;
						$this->data['User']['tw_uid'] = (int) $user->id;
						$this->data['User']['tw_pic_url'] = (string) $user->profile_image_url;
						$this->data['User']['tw_location'] =  (string) $user->location;
						$this->data['User']['tw_access_key'] =  $accessToken->key;
						$this->data['User']['tw_access_secret'] =  $accessToken->secret;
	
						break;
		
					case 'facebook':
						$facebook = $this->createFacebook();
						$session=$facebook->getSession();
						if(!empty($session)){
							try{
								$user=json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$session['access_token']));
							}
							catch(FacebookApiException $e){
								error_log($e);
							}
							$this->data['User']['fb_uid'] = (int) $user->id;
							$this->data['User']['fb_pic_url'] = 'http://graph.facebook.com/'.$user->id.'/picture';
							$this->data['User']['fb_location'] = '';
							$this->data['User']['fb_access_key'] = $session['access_token'];

							
					}
					break;
				}
				$username = $db_results['User']['username'];
				$password = $db_results['User']['password'];

				
		}
		// new account
		else {
			
			$update = false;
			
			switch ($type){
				case 'twitter':
		
					$accessToken=$this->Session->read('twitter_access_token');
					$consumer = $this->createConsumer();
					$content=$consumer->get($accessToken->key,$accessToken->secret,'http://twitter.com/account/verify_credentials.xml', array());
					$user = simplexml_load_string($content);
					$this->data['User']['type'] = 'twitter';
					$this->data['User']['name'] = (string) $user->name;
					$this->data['User']['email'] = (string) $email_address;
					$this->data['User']['twitter_handle'] = (string) $user->screen_name;
					$this->data['User']['tw_user_url'] = (string) $user->url;
					$this->data['User']['tw_uid'] = (int) $user->id;
					$this->data['User']['tw_pic_url'] = (string) $user->profile_image_url;
					$this->data['User']['tw_location'] =  (string) $user->location;
					$this->data['User']['tw_access_key'] =  $accessToken->key;
					$this->data['User']['tw_access_secret'] =  $accessToken->secret;
	
						
				break;
		
				case 'facebook':
					$facebook = $this->createFacebook();
					$session=$facebook->getSession();
					if(!empty($session)){
						try{
							$user=json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$session['access_token']));
						}
						catch(FacebookApiException $e){
							error_log($e);
						}
						$this->data['User']['type'] = 'facebook';
						$this->data['User']['name'] = (string) $user->name;
						$this->data['User']['email'] = (string) $email_address;
						$this->data['User']['fb_uid'] = (int) $user->id;
						$this->data['User']['fb_pic_url'] = 'http://graph.facebook.com/'.$user->id.'/picture';
						$this->data['User']['fb_location'] = '';
						$this->data['User']['fb_access_key'] = $session['access_token'];
					}
					break;
				}
				$password = $this->data['User']['password']= $this->data['User']['new_password'] = $this->data['User']['confirm_password'] = $this->__randomString();
				$username = $this->data['User']['username']= (string) $email_address;
			
			}
			
			$this->User->save($this->data);
			$id = $this->User->id;
			//echo $id;
			
			$this->_login($username,$password);
	
	
			if (!$update){
				$this->redirect(array('controller'=>'mail', 'action'=>'send_welcome_message', $email_address, $username));//$this->data['User']['name']));
			}
			else {
				$this->redirect('/');
			}
		}
	private  function __randomString($minlength = 20, $maxlength = 20, $useupper = true, $usespecial = false, $usenumbers = true){
        $charset = "abcdefghijklmnopqrstuvwxyz";
        if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($usenumbers) $charset .= "0123456789";
        if ($usespecial) $charset .= "~@#$%^*()_+-={}|][";
        if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
        else $length = mt_rand ($minlength, $maxlength);
        $key = '';
        for ($i=0; $i<$length; $i++){
            $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
        }
        return $key;
    }

	
	

	public function facebookLogin(){
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
		$full_url = ROOT_URL . '/users/fbCallback';
		$login_url = $facebook->getLoginUrl(array('req_perms' => 'email,user_birthday,user_about_me,user_location,publish_stream','next' => $full_url));
		if(!empty($session)){
			$this->Session->write('fb_acces_token',$session['access_token']);
			$facebook_id = $facebook->getUser();
	
			$db_results = $this->User->find('first', array('conditions' => (array('User.fb_uid'=>$facebook_id)), 'fields'=>(array('User.username','User.password'))));

			if (!empty($db_results)) {
				//echo 'results not empty';
				$this->_login($db_results['User']['username'],$db_results['User']['password']);
	
				$this->redirect('/');
			}
			else{
				$this->redirect($login_url);
			}
	
		}
		else{
			$this->redirect($login_url);
		}
	}
	
	public function fbCallback(){
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
			$facebook_id = $facebook->getUser();
	
			$db_results = $this->User->find('first', array('conditions' => (array('User.fb_uid'=>$facebook_id)), 'fields'=>(array('User.username','User.password'))));

			if (!empty($db_results)) {
				$this->_login($db_results['User']['username'],$db_results['User']['password']);
				$this->redirect('/');
			}
		$this->layout = 'page';
	}
	
	
	
	
	
	function edit_pic(){
		 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
		if (!empty($this->data)) {
			//	var_dump($this->data);
			App::import('Vendor', 'upload');
	        
	        
 			$typelist=split('/', $_FILES['data']['type']['User']['photo']);
			$allowed[0]='xxx';
            $allowed[1]='gif';
            $allowed[2]='jpg';
            $allowed[3]='jpeg';
            $allowed[4]='png';
            
			$allowed_val='';
            $allowed_val=array_search($typelist[1], $allowed);

			if (!$allowed_val){
				$this->Session->setFlash('<span class="bodycopy" style="color:red;">Profile picture must be gif, jpg or png only.</span>');
			}
	        
	    	else if(!empty($this->data) && $this->data['User']['photo']['size']>0){
	          
				$file = $this->data['User']['photo']; 
	            $handle = new Upload($file);

	            if ($handle->uploaded){
					if($handle->image_src_x >= 100){
						$handle->image_resize = true;
		    			$handle->image_ratio_y = true;
		    			$handle->image_x = 100;
		    			
		    			if($handle->image_y >= 100){
		    				$handle->image_resize = true;
			    			$handle->image_ratio_x = true;
			    			$handle->image_y = 100;
		    			}
					}
	    			$handle->Process('img/uploads');
				
				}
	            if(!is_null($handle->file_dst_name) && $handle->file_dst_name!=''){
					$user_path = $handle->file_dst_name;
				}
               
  	            $handle->clean();
	            $this->User->read(null,$this->Auth->getUserId());
				$this->User->set('path', $user_path);
  	        	$this->User->save();
  	        }
         
	        //$this->redirect(array('controller'=>'beta', 'action'=>'view_my_profile'));
	        exit;
	    }
	}*/
	
	
	/*function forgot() {
  		if(!empty($this->data)) {
   			 $this->User->contain();
    			$user = $this->User->findByEmail($this->data['User']['email']);
    		if($user) {
      			$user['User']['tmp_password'] = $this->User->createTempPassword(7);
      			$user['User']['password'] = $this->Auth->password($user['User']['tmp_password']);
      			if($this->User->save($user, false)) {
       			 $this->__sendPasswordEmail($user, $user['User']['tmp_password']);
        			$this->Session->setFlash('An email has been sent with your new password.');
        			$this->redirect($this->referer());
      			}
    		} else {
     		 $this->Session->setFlash('No user was found with the submitted email address.');
    		}
  		}
	}
	*/
	
	
	

	
	
	


	
}

?>