<?php
class Reward extends AppModel {

	var $name = 'Reward';
    var $actsAs = array('Containable');
	  				
     var $hasAndBelongsToMany = array(
	 						'User'=>array(
	 							'className'=>'User',
								'unique'=>false,
							),
							'Merchant'=> array(
    							'className' => 'Merchant',
    							'unique' => false,
  							));

	function getRewards($id=null) {
		
// 		 return $this->Merchant->find('first');//, array('conditions'=>array('MerchantsRewards.merchant_id'=>$id)));
	return $this->Merchant->find('all',array('conditions'=>array('Merchant.id'=>$id)));
	
	 }

/*   

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

     'User' => array(
        'className'             => 'User',
        'joinTable'             => 'users_rewards',
        'foreignKey'            => 'reward_id',
        'associationForeignKey' => 'user_id',
		'unique'				=> false
    ),
        'Merchant' => array(
        'className'             => 'Merchant',
        'joinTable'             => 'merchants_rewards',
        'foreignKey'            => 'reward_id',
        'associationForeignKey' => 'mechant_id',
		'unique'				=> false
    )); 
	*/



}
?>
