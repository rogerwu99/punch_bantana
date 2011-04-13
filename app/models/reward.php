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
	var $validate = array(
    	'description' => array(
    							'rule'=>'notEmpty',
	   							'message' => 'Must have a description.',
    							'last'=>true,
							  ),
    	/*'end_date' => array(
    							'rule'=>array('dateorder','start_date'),
	   							'message' => 'End date must be after start date.',
    							'last'=>true,
							  ),
		*/
		'threshold' => array
					(
					'rule' => array('comparison', '>=', 1),
					'message' => 'Must have at least one point.'
					)
  		);
    



	function getRewards($id=null) {
		
// 		 return $this->Merchant->find('first');//, array('conditions'=>array('MerchantsRewards.merchant_id'=>$id)));
	return $this->Merchant->find('all',array('conditions'=>array('Merchant.id'=>$id)));
	
	 }
	 
	 function dateorder($field=array(), $compare_field=null ) 
    {
		foreach( $field as $key => $value )
        {
            $v1 = date('Ymd',strtotime($value));
            $v2 = date('Ymd',strtotime($this->data[$this->name][ $compare_field ]));                 
            if($v1 < $v2) 
            {
                return false;
            } 
            else 
            {
                continue;
            }
        }
        return true;
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
