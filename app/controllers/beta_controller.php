<?php
App::import('Vendor', 'simplegeo', array('file' => 'SimpleGeo.php'));
class BetaController extends AppController 
{
    var $name = 'Beta';
    var $uses = array('User', 'Mail','Reward','Location','Merchant','Punch','Punchcards'); 
    var $helpers = array('Html', 'Form', 'Javascript', 'Xml', 'Crumb', 'Ajax');
    var $components = array('Utils', 'Email', 'RequestHandler');
   
    function index($id=null)
    {
	 	if (is_null($id)){
			if(is_null($this->Auth->getUserId())){
         		Controller::render('/deny');
        	}
			else {
				//echo 'no id, logged in';
				$this->User->recursive = -1;
		   		$user = $this->Auth->getUserInfo();
				$this->set(compact('user'));
				$this->redirect(array('action'=>'view_my_profile'));
	 		}
		}
		
		else {
			$this->Session->write('hash_value',$id);
			if(is_null($this->Auth->getUserId())){
		//		echo 'yes id, not logged in';
         		
				$this->redirect(array('/'));
			
				// create a login screen for mobile only
			}
			else {
				echo $id;
				//echo 'yes id, yes logged in';
			
				//do the lat long check
				// redirect you back to another function
				
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
			}
			
		}
	}
    function send()
	{
		$results = $this->params['url'];
		$lat=$results['latitude'];
		$long=$results['longitude'];
		
		$id = $this->Session->read('hash_value');
		$picture_name = 'QRCode_'.$id.'.png';
		$db_results = $this->Location->find('first',array('conditions'=>array('Location.qr_path'=>$picture_name)));
		
		
		if (!empty($db_results)){
			$earth_radius = 6371;
			$lat_center = $db_results['Location']['lat'];
			$long_center = $db_results['Location']['long'];
			$delta_lat = deg2rad($lat - $lat_center);
			$delta_long = deg2rad($long - $long_center);
			$a = sin($delta_lat/2) * sin($delta_lat/2) + cos(deg2rad($lat)) * cos(deg2rad($lat_center)) * sin($delta_long/2) * sin($delta_long/2);
			$c = 2 * atan2(sqrt($a),sqrt(1-$a));
			$distance = $earth_radius * $c;
			$this->set('distance',sprintf("%.4f",$distance));
			$this->set('lat',sprintf("%.4f",$lat));
			$this->set('long',sprintf("%.4f",$long));
			$this->set('lat_center',sprintf("%.4f",$lat_center));
			$this->set('long_center',sprintf("%.4f",$long_center));
			$db_results2 = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$db_results['Location']['merchant_id'])));
			if ($distance <= 0.25){
				
				$db_results1 = $this->Punchcards->find('first',array('conditions'=>array('Punchcards.user_id'=>$this->Auth->getUserId(),
																						 'Punchcards.location_id'=>$db_results['Location']['id']
																						 )));
				$legal = false;
				if (!empty($db_results1)){
					
					//var_dump($db_results);
					//var_dump($db_results1);	
					if (date('d',$db_results1['Punchcards']['current_punch_at'])==date('d')){
						
						// simple for now -> just more than one visit is illegal
						if ($db_results['Location']['max_visits']>1){
							$legal = true;
						}
					}
				}
				if ($legal){		
					$this->Punch->create();
					$this->data['Punch']['user_id']=$this->Auth->getUserId();
					$this->data['Punch']['location_id']=$db_results['Location']['id'];
					$this->Punch->save($this->data);
					$this->set('message','Your visit has been successfully recorded!');
					$this->set('num_punches',$db_results1['Punchcards']['current_punch']+1); //+1 because we are reading the DB prior to writing it
			
				}
				else {
					$this->set('num_punches',$db_results1['Punchcards']['current_punch']); 
					$this->set('message','This location only allows a maximum number of rewards per day, come back tomorrow!');
				}
			}
			
			else { // too far away
				$this->set('message','There was an error, please contact us with the codes below (#200)');
			}
			
			//var_dump($db_results2);
			$this->set('merchant',$db_results2['Merchant']['name']);
			$this->set('name',$db_results['Location']['description']);
			$this->set('address',$db_results['Location']['address']);
			
		}
		else { // venue doesn't exist
			$this->set('message','There was an error, please contact us with the codes below (#100)');
		}
	}
}

?>
