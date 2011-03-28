<?php
App::import('Vendor', 'simplegeo', array('file' => 'SimpleGeo.php'));
class BetaController extends AppController 
{
    var $name = 'Beta';
    var $uses = array('User', 'Mail','Reward','Location','Merchant','Punch'); 
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
			if(is_null($this->Auth->getUserId())){
				echo 'yes id, not logged in';
         		$this->Session->write('hash_value',$id);
				$this->redirect(array('controller'=>'users','action'=>'checkinlogin'));
			
				// create a login screen for mobile only
			}
			else {
				echo $id;
				
				//echo 'yes id, yes logged in';
				$picture_name = 'QRCode_'.$id.'.png';
				$db_results = $this->Location->find('first',array('conditions'=>array('Location.qr_path'=>$picture_name)));
			//	var_dump($db_results);
				if (!empty($db_results)){
				
				//do the lat long check
				// redirect you back to another function
				
				// assuming you pass
				//$this->redirect(array('action'=>'record_punch'));
					$this->Punch->create();
					$this->data['Punch']['user_id']=$this->Auth->getUserId();
					$this->data['Punch']['location_id']=$db_results['Location']['id'];
					$this->Punch->save($this->data);
				}
				else {
					echo 'that venue does not exist';
				}
			}
		}
	}
    function record_punch(){
		
	}
    
    
}

?>
