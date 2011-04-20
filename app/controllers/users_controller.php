<?php
App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));
App::import('Vendor', 'facebook');
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $components = array('Auth', 'Email','Paypal');//,'Ssl');
	var $uses = array('User', 'Mail', 'Reward','Punch','Punchcard','Location','Merchant','Redemption');
	var $facebook;
	var $twitter_id;


	function index()
	{
		if(is_null($this->Auth->getUserId())){
       		Controller::render('/deny');
        }
		else {
			$this->redirect(array('controller'=>'users','action'=>'view_my_profile'));
		}
		
	}

	function _login($username=null, $password=null)
	{
		if ($username && $password){
			$user_record_1=array();
			$user_record_1['Auth']['username']=$username;
			$user_record_1['Auth']['password']=$password;
			$this->Auth->user_model_name = 'User';
			$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
			return;		
		}
	}
	
	function login(){
		$this->_login($this->data['Auth']['username'],$this->Auth->hasher($this->data['Auth']['password']));
		if ($this->Session->check('hash_value')){
			$this->redirect(array('controller'=>'beta','action'=>'index',$this->Session->read('hash_value')));
		}
		else {
			$this->redirect(array('action'=>'view_my_profile'));
		}
	}
	function register($id=null){
		if (is_null($id)){
			if (!empty($this->data)){
				$email = $this->data['User']['email'];
				$name=$this->data['User']['name'];
				$password = $this->data['User']['new_password'];
				$confirm =$this->data['User']['confirm_password'];
				$accept = $this->data['User']['accept'];
				$fb_uid = $this->data['User']['fb_uid'];
				$month = $this->data['User']['smonth'];
				$date = $this->data['User']['sdate']+1;
				$year = $this->data['User']['syear'];
				$sex = $this->data['User']['sex'];
				$this->data=array();
				$this->User->create();
				$this->data['User']['name']=$name;
				$this->data['User']['email'] = (string) $email;
				$this->data['User']['new_password']=$password;
				$this->data['User']['confirm_password']=$confirm;
				$this->data['User']['accept']=$accept;
				$this->data['User']['sex']=$sex;
				$final_year = (int)date('Y')-$year-13;
				$this->data['User']['birthday']= date('Ymd',strtotime($month.' '.$date.' '.$final_year));
				
				$password = $this->data['User']['password'] = $this->Auth->hasher($password); 
				$username = $this->data['User']['username']= (string) $email;
				$this->data['User']['path']=(is_null($path)) ? 'default.png' : $path;
				if (!is_null($fb_uid)){
					$facebook = $this->createFacebook();
					$session=$facebook->getSession();
					$this->data['User']['fb_access_key'] = $session['access_token'];
					$this->data['User']['fb_uid'] = $fb_uid;
					$this->data['User']['fb_pic_url'] = 'http://graph.facebook.com/'.$fb_uid.'/picture';
				}
				
				$this->User->set($this->data);
				if ($this->User->validates()){
					$this->User->save();
					
					$this->Email->to = $email;
        			$this->Email->replyTo = 'info@bantana.com';
					$this->Email->subject = 'Welcome to Bantana!';
        			$this->Email->from = 'Bantana <info@bantana.com>';
 			       	$this->Email->template = 'welcome';
					$this->set('name',$name);
					$status = $this->Email->send();
					
					$this->_login($username,$password);
					$this->set('intro',true);
				}
				else {
					$this->set('errors', $this->User->validationErrors);
					unset($this->data['User']['new_password']);
		    		unset($this->data['User']['confirm_password']);
				}
			}
			else {
				
			}
		}
		else {
			$this->redirect(array('action'=>'view_my_profile'));
		}
	}
	
	
	function logout()
	{
		$user=$this->Auth->getUserInfo();
			
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
		$url = $facebook->getLogoutUrl(array('req_perms' => 'email,user_birthday,user_about_me,user_location,publish_stream','next' => ROOT_URL));

		$this->Session->destroy();
		

		if(!empty($session)){
			$facebook->setSession(null);
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
		if(is_null($this->Auth->getUserId())){
        	$db_results = $this->User->find('first', array('conditions' => (array('User.tw_access_key'=>$accessToken->key)), 'fields'=>(array('User.username', 'User.password'))));
			if (!empty($db_results)) {
				$this->_login($db_results['User']['username'],$db_results['User']['password']);
				$this->redirect('/');
			}
			$this->layout = 'about';
		}
		else {
			$updated_id = $this->Auth->getUserId();
			$this->User->read(null,$updated_id);
			$content=$consumer->get($accessToken->key,$accessToken->secret,'http://twitter.com/account/verify_credentials.xml', array());
			$user = simplexml_load_string($content);
			$this->data['User']['tw_uid'] = (int) $user->id;
			$this->data['User']['tw_access_key'] =  $accessToken->key;
			$this->data['User']['tw_access_secret'] =  $accessToken->secret;
			$this->User->save($this->data);
		}
	}
	public function facebookLogin($tok=null){
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
		if (is_null($tok)){
			$full_url = ROOT_URL . '/users/fbCallback';
		}
		else {
			$full_url = ROOT_URL . '/users/fbConnectCallback';
		}
		$login_url = $facebook->getLoginUrl(array('req_perms' => 'email,user_birthday,user_about_me,user_location,publish_stream','next' => $full_url));
		if(!empty($session)){
			$this->Session->write('fb_access_token',$session['access_token']);
			$facebook_id = $facebook->getUser();
			if(is_null($this->Auth->getUserId())){
				$db_results = $this->User->find('first', array('conditions' => (array('User.fb_uid'=>$facebook_id,'User.fb_access_key'=>$session['access_token'])), 'fields'=>(array('User.username','User.password'))));

				if (!empty($db_results)) {
					//echo 'results not empty';
					$this->_login($db_results['User']['username'],$db_results['User']['password']);
					$this->redirect('/');
				}
				else{
					$this->redirect($login_url);
				}
			}
			else {
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
		if (is_null($this->Auth->getUserId())){
			$db_results = $this->User->find('first', array('conditions' => (array('User.fb_uid'=>$facebook_id,'User.fb_access_key'=>$session['access_token'])), 'fields'=>(array('User.username','User.password'))));
			if (!empty($db_results)) {
				$this->_login($db_results['User']['username'],$db_results['User']['password']);
				$this->redirect('/');
			}
			else {
				if(!empty($session)){
					try{
						$fb_user=json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$session['access_token']));
						//var_dump($fb_user);
					}
					catch(FacebookApiException $e){
						error_log($e);
					}
					/*$this->data['User']['fb_uid'] = (int) $user->id;
					$this->data['User']['fb_pic_url'] = 'http://graph.facebook.com/'.$user->id.'/picture';
					$this->data['User']['fb_location'] = '';
					$this->data['User']['fb_access_key'] = $session['access_token'];
					*/$this->set('fb_user',$fb_user);
				}
			}
		}
		
		$this->layout = 'about';
	}
	public function fbConnectCallback(){
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
		$facebook_id = $facebook->getUser();
		if (!is_null($this->Auth->getUserId())){
			if(!empty($session)){
				try{
					$fb_user=json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$session['access_token']));
				}
				catch(FacebookApiException $e){
					error_log($e);
				}
				$this->data=array();
				$this->User->read(null,$this->Auth->getUserId());
				$this->data['User']['fb_access_key'] = $session['access_token'];
				$this->data['User']['fb_uid'] = $fb_user->id;
				$this->data['User']['fb_pic_url'] = 'http://graph.facebook.com/'.$fb_user->id.'/picture';
			}
			$this->User->set($this->data);
			if ($this->User->validates()){
				$this->User->save();
			//	$this->_login($username,$password);
			}
			$this->redirect(array('action'=>'view_my_profile'));
		}
	}
	function view_my_profile(){
		if(is_null($this->Auth->getUserId())){
       		Controller::render('/deny');
        }
		else {
			$root_url =ROOT_URL;
			$user = $this->Auth->getUserInfo();
			$image_link = ''; 
			$image_can_change = false;
			if ($user['fb_pic_url']==''){
				$image_link=$root_url.'/img/uploads/'.$user['path'];
				$image_can_change = true;
			}
			else {
				$image_link = $user['fb_pic_url'];
			}
			$this->set('image_can_change', $image_can_change);
			$this->set('image_link', $image_link);
			$this->set(compact('user'));
			$loc_array=array();
			$mer_array=array();
			$mer_id_array=array();
			$mer_array_no_dupes = array();
			$num_points = array();
			$dupe= false;
			$db_results=$this->Punchcard->find('all',array('conditions'=>array('Punchcard.user_id'=>$user['id'])));
			if (!empty($db_results)) {
				foreach ($db_results as $key=>$value){
					$loc = $this->Location->find('first',array('conditions'=>array('Location.id'=>$db_results[$key]['Punchcard']['location_id'])));
					$mer = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$loc['Location']['merchant_id'])));
					$loc['Location']['visits']=$db_results[$key]['Punchcard']['current_punch'];
					array_push($loc_array,$loc);
					array_push($mer_array,$mer);
					if (empty($mer_id_array)){
						array_push($mer_id_array,$mer['Merchant']['id']);
						array_push($mer_array_no_dupes,$mer);
						$visits->merchant_id = $mer['Merchant']['id'];
						$visits->number = $db_results[$key]['Punchcard']['current_punch'];
						$visits->location_id = $db_results[$key]['Punchcard']['location_id'];
						array_push($num_points,$visits);
					}
					else {
						for ($i=0;$i<sizeof($mer_id_array);$i++){
							if ($mer['Merchant']['id']==$mer_id_array[$i]){
								for ($j=0;$j<sizeof($num_points);$j++){
									if ($num_points[$j]->merchant_id == $mer['Merchant']['id']){
										$num_points[$j]->number += $db_results[$key]['Punchcard']['current_punch']; 
										$num_points[$j]->number -= $db_results[$key]['Punchcard']['last_redemption'];
										break;
									}
								}
								$dupe = true;
								break;
							}
						}
						if (!$dupe) {
							array_push($mer_id_array,$mer['Merchant']['id']);
							array_push($mer_array_no_dupes,$mer);
							$visits->merchant_id = $mer['Merchant']['id'];
							$visits->number = ($db_results[$key]['Punchcard']['current_punch'] - $db_results[$key]['Punchcard']['last_redemption']);
							 
							$visits->location_id = $db_results[$key]['Punchcard']['location_id'];
							array_push($num_points,$visits);
						}
					}
					$dupe = false;
				}
				$this->set('num_points',$num_points);
				$this->set('loc_array',$loc_array);
				$this->set('mer_array',$mer_array);
				$this->set('mer_array_no_dupes',$mer_array_no_dupes);
			}
			else {
				$this->set('none',true);
			}
			
			$db_results2 = $this->Redemption->find('all',array('conditions'=>array('Redemption.user_id'=>$this->Auth->getUserId())));
			$rewards_array =array();
			foreach ($db_results2 as $key=>$value){
				$reward = $this->Reward->find('first',array('conditions'=>array('Reward.id'=>$db_results2[$key]['Redemption']['reward_id'])));
				$location = $this->Location->find('first',array('conditions'=>array('Location.id'=>$db_results2[$key]['Redemption']['location_id'])));
				$prize='';
				$prize->description = $reward['Reward']['description'];
				$prize->threshold = $reward['Reward']['threshold'];
				$prize->merchant = $reward['Merchant'][0]['name'];
				$prize->location_des = $location['Location']['description'];
				$prize->location = $location['Location']['address'];
				$prize->zip = $location['Location']['zip'];
				$prize->redeem_date = $db_results2[$key]['Redemption']['created'];
				$prize->key=$key;
				array_push($rewards_array,$prize);
			}
			$this->set('redemptions',$db_results2);
			$this->set('rewards',$rewards_array);
			
			
			$this->render();
		}
	}
	function edit(){
		
	 	if(is_null($this->Auth->getUserId())){
          Controller::render('/deny');
         }
		else {
			if (!empty($this->data)) {
				if ($this->data['User']['new_password']!='' && $this->data['User']['new_password']==$this->data['User']['confirm_password']){
					$this->data['User']['password'] = $this->Auth->hasher($this->data['User']['new_password']); 
				}
				$this->data['User']['birthday']= date('Ymd',strtotime($this->data['User']['smonth'].' '.++$this->data['User']['sdate'].' '.$this->data['User']['syear']));
				$username=$this->User->read(null,$this->Auth->getUserId());
				$this->User->set($this->data);
	    		if ($this->User->validates()){
				    $this->User->save();
					$this->_login($username['User']['email'],$username['User']['password']);
		    	    $this->redirect(array( 'action'=>'view_my_profile'));
				}	
				else {
					$this->set('errors', $this->User->validationErrors);
				}
			}
			else {
				$user = $this->Auth->getUserInfo();
				$this->set(compact('user'));
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
				$this->set('years',range(1900,(int)date('Y')-13));
			}
		}
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
         
	        $this->redirect(array('action'=>'view_my_profile'));
	        exit;
	    }
	}
	function my_rewards(){
		if(is_null($this->Auth->getUserId())){
       		Controller::render('/deny');
        }
		else {
			$user = $this->Auth->getUserInfo();
			$this->set(compact('user'));
			$loc_array=array();
			$mer_array=array();
			$mer_id_array=array();
			$mer_array_no_dupes = array();
			$num_points = array();
			$dupe= false;
			$db_results=$this->Punchcard->find('all',array('conditions'=>array('Punchcard.user_id'=>$user['id'])));
			if (!empty($db_results)) {
				foreach ($db_results as $key=>$value){
					$loc = $this->Location->find('first',array('conditions'=>array('Location.id'=>$db_results[$key]['Punchcard']['location_id'])));
					$mer = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$loc['Location']['merchant_id'])));
					$loc['Location']['visits']=$db_results[$key]['Punchcard']['current_punch'];
					array_push($loc_array,$loc);
					array_push($mer_array,$mer);
					if (empty($mer_id_array)){
						array_push($mer_id_array,$mer['Merchant']['id']);
						array_push($mer_array_no_dupes,$mer);
						$visits->merchant_id = $mer['Merchant']['id'];
						$visits->number = $db_results[$key]['Punchcard']['current_punch'];
						$visits->location_id = $db_results[$key]['Punchcard']['location_id'];
						array_push($num_points,$visits);
					}
					else {
						for ($i=0;$i<sizeof($mer_id_array);$i++){
							if ($mer['Merchant']['id']==$mer_id_array[$i]){
								for ($j=0;$j<sizeof($num_points);$j++){
									if ($num_points[$j]->merchant_id == $mer['Merchant']['id']){
										$num_points[$j]->number += $db_results[$key]['Punchcard']['current_punch']; 
										$num_points[$j]->number -= $db_results[$key]['Punchcard']['last_redemption'];
										break;
									}
								}
								$dupe = true;
								break;
							}
						}
						if (!$dupe) {
							array_push($mer_id_array,$mer['Merchant']['id']);
							array_push($mer_array_no_dupes,$mer);
							$visits->merchant_id = $mer['Merchant']['id'];
							$visits->number = ($db_results[$key]['Punchcard']['current_punch'] - $db_results[$key]['Punchcard']['last_redemption']);
							 
							$visits->location_id = $db_results[$key]['Punchcard']['location_id'];
							array_push($num_points,$visits);
						}
					}
					$dupe = false;
				}
				$this->set('num_points',$num_points);
				$this->set('loc_array',$loc_array);
				$this->set('mer_array',$mer_array);
				$this->set('mer_array_no_dupes',$mer_array_no_dupes);
			}
			else {
				$this->set('none',true);
			}
			
		$this->render();
		}
	}
	function my_redeemed_rewards(){
		if(is_null($this->Auth->getUserId())){
       		Controller::render('/deny');
        }
		else {
			$user = $this->Auth->getUserInfo();
			$this->set(compact('user'));
			
			$db_results2 = $this->Redemption->find('all',array('conditions'=>array('Redemption.user_id'=>$this->Auth->getUserId())));
			$rewards_array =array();
			foreach ($db_results2 as $key=>$value){
				$reward = $this->Reward->find('first',array('conditions'=>array('Reward.id'=>$db_results2[$key]['Redemption']['reward_id'])));
				$location = $this->Location->find('first',array('conditions'=>array('Location.id'=>$db_results2[$key]['Redemption']['location_id'])));
				$prize='';
				$prize->description = $reward['Reward']['description'];
				$prize->threshold = $reward['Reward']['threshold'];
				$prize->merchant = $reward['Merchant'][0]['name'];
				$prize->location_des = $location['Location']['description'];
				$prize->location = $location['Location']['address'];
				$prize->zip = $location['Location']['zip'];
				$prize->redeem_date = $db_results2[$key]['Redemption']['created'];
				$prize->key=$key;
				array_push($rewards_array,$prize);
			}
			$this->set('redemptions',$db_results2);
			$this->set('rewards',$rewards_array);
			
			
			$this->render();
		}
	}
	function my_spots(){
		if(is_null($this->Auth->getUserId())){
       		Controller::render('/deny');
        }
		else {
			$root_url =ROOT_URL;
			$user = $this->Auth->getUserInfo();
			$image_link = ''; 
			$image_can_change = false;
			if ($user['fb_pic_url']==''){
				$image_link=$root_url.'/img/uploads/'.$user['path'];
				$image_can_change = true;
			}
			else {
				$image_link = $user['fb_pic_url'];
			}
			$this->set('image_can_change', $image_can_change);
			$this->set('image_link', $image_link);
			$this->set(compact('user'));
			$loc_array=array();
			$mer_array=array();
			$mer_id_array=array();
			$mer_array_no_dupes = array();
			$num_points = array();
			$dupe= false;
			$db_results=$this->Punchcard->find('all',array('conditions'=>array('Punchcard.user_id'=>$user['id'])));
			if (!empty($db_results)) {
				foreach ($db_results as $key=>$value){
					$loc = $this->Location->find('first',array('conditions'=>array('Location.id'=>$db_results[$key]['Punchcard']['location_id'])));
					$mer = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$loc['Location']['merchant_id'])));
					$loc['Location']['visits']=$db_results[$key]['Punchcard']['current_punch'];
					array_push($loc_array,$loc);
					array_push($mer_array,$mer);
					if (empty($mer_id_array)){
						array_push($mer_id_array,$mer['Merchant']['id']);
						array_push($mer_array_no_dupes,$mer);
						$visits->merchant_id = $mer['Merchant']['id'];
						$visits->number = $db_results[$key]['Punchcard']['current_punch'];
						$visits->location_id = $db_results[$key]['Punchcard']['location_id'];
						array_push($num_points,$visits);
					}
					else {
						for ($i=0;$i<sizeof($mer_id_array);$i++){
							if ($mer['Merchant']['id']==$mer_id_array[$i]){
								for ($j=0;$j<sizeof($num_points);$j++){
									if ($num_points[$j]->merchant_id == $mer['Merchant']['id']){
										$num_points[$j]->number += $db_results[$key]['Punchcard']['current_punch']; 
										$num_points[$j]->number -= $db_results[$key]['Punchcard']['last_redemption'];
										break;
									}
								}
								$dupe = true;
								break;
							}
						}
						if (!$dupe) {
							array_push($mer_id_array,$mer['Merchant']['id']);
							array_push($mer_array_no_dupes,$mer);
							$visits->merchant_id = $mer['Merchant']['id'];
							$visits->number = ($db_results[$key]['Punchcard']['current_punch'] - $db_results[$key]['Punchcard']['last_redemption']);
							 
							$visits->location_id = $db_results[$key]['Punchcard']['location_id'];
							array_push($num_points,$visits);
						}
					}
					$dupe = false;
				}
				$this->set('num_points',$num_points);
				$this->set('loc_array',$loc_array);
				$this->set('mer_array',$mer_array);
				$this->set('mer_array_no_dupes',$mer_array_no_dupes);
			}
			else {
				$this->set('none',true);
			}
			
			$this->render();
		}
	}
	function user_feedback(){
		//echo 'start';
		$message = $this->data['Feedback']['description'];
		$customer = $this->Auth->getUserInfo();
		//echo 'here';
		$this->Email->to = 'rogerwu99@gmail.com';
        $this->Email->replyTo = 'roger@alumni.upenn.edu';
		$this->Email->subject = 'User Feedback!';
        $this->Email->from = 'Bantana <rogerwu99@bantana.com>';
        $this->Email->template = 'feedback';
		//echo 'set';
	    $this->set(compact('customer'));
		$this->set(compact('message'));
		$this->set('mail_sent',true);
		$this->set('user_type','Customer');
		//echo 'send';
		$status = $this->Email->send();
		//echo $status;
		//echo 'unset';
		unset($this->data['Feedback']['description']);
		    	
		$this->render('/elements/feedback');
	}
	/*
	

	
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

	
	
	
	
	
	
	*/
	
	
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