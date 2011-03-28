<?php
App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));
App::import('Vendor', 'facebook');
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $components = array('Auth', 'Email','Paypal');//,'Ssl');
	var $uses = array('User', 'Mail', 'Reward','Punch');
	var $facebook;
	var $twitter_id;



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
		$this->redirect('/');
	}
	function register(){
		//var_dump($this->data);
		if (!empty($this->data)){
			$email = $this->data['User']['email'];
			$name=$this->data['User']['name'];
			$password = $this->data['User']['new_password'];
			$confirm =$this->data['User']['confirm_password'];
			$accept = $this->data['User']['accept'];
			$this->data=array();
			$this->User->create();
			$this->data['User']['name']=$name;
			$this->data['User']['email'] = (string) $email;
			$this->data['User']['new_password']=$password;
			$this->data['User']['confirm_password']=$confirm;
			$this->data['User']['accept']=$accept;
			$password = $this->data['User']['password'] = $this->Auth->hasher($password); 
			$username = $this->data['User']['username']= (string) $email;
			$this->data['User']['path']='default.png';
			$this->User->set($this->data);
			if ($this->User->validates()){
				$this->User->save();
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
	
	
	
	
	
	function logout()
	{
		$user=$this->Auth->getUserInfo();
			
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
		$url = $facebook->getLogoutUrl(array('req_perms' => 'email,user_birthday,user_about_me,user_location,publish_stream','next' => ROOT_URL));

		$this->Session->destroy();
		
// when i logout with twitter only, i get redirected to facebook?

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
		$db_results = $this->User->find('first', array('conditions' => (array('User.tw_access_key'=>$accessToken->key)), 'fields'=>(array('User.username', 'User.password'))));
		if (!empty($db_results)) {
			$this->_login($db_results['User']['username'],$db_results['User']['password']);
			$this->redirect('/');
		}
		$this->layout = 'about';
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
	//	$db_results=$this->Punch->find('all',array('conditions'=>array('Punch.user_id'=>$this->Auth->getUserId())));
		if (!empty($db_results)) {
			foreach ($db_results as $key=>$value){
				var_dump($db_results);
				/*if ($db_results[$key]['Redeem']['hidden']!=1){
					//$disc_results = $this->Discount->findById($db_results[$key]['Redeem']['disc_id']);
					$disc_user = $this->User->findById($disc_results['Discount']['user_id']);
					array_push($disc_array,$disc_results);
					array_push($disc_desc,$disc_user);
			
				}*/
			echo 'hi';
			}
			//$this->set('d_desc',$disc_desc);
			//$this->set('d_results',$disc_array);
		}
		else {
			$this->set('none',true);
		}
		$this->render();
	}
	function edit(){
	 	if(is_null($this->Auth->getUserId())){
          Controller::render('/deny');
         }
		if (!empty($this->data)) {
			$name=$this->data['User']['Name'];
			$password = $this->Auth->hasher($this->data['User']['new_password']);

			$this->User->read(null,$this->Auth->getUserId());
			$this->User->set(array(
								   'password'=>$password,
								   'name'=>$name
								   ));
	        $this->User->save();
			$username=$this->User->read('username',$this->Auth->getUserId());
			$this->_login($username['User']['username'],$password);
	
	        $this->redirect(array( 'action'=>'view_my_profile'));
		}
		$user = $this->Auth->getUserInfo();
		$this->set(compact('user'));
	}
	function my_rewards(){
	}
	function my_spots(){
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