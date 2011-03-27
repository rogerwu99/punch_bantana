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

/*        'User' => array(
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
