<?php
class Merchant extends AppModel {

	var $name = 'Merchant';
    var $actsAs = array('Containable');
	  				
    var $hasAndBelongsToMany = array(
        'Reward' => array(
	        'className'             => 'Reward',
    		'unique'				=> false
    	));
        
	  				
    
	function identicalFieldValues($field=array(), $compare_field=null ) 
    {
        foreach( $field as $key => $value )
        {
            $v1 = $value;
            $v2 = $this->data[$this->name][ $compare_field ];                 
            if($v1 !== $v2) 
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
    
    var $validate = array(
    	
    	'email' => array(
    					'emailFormat' => array(
    							'rule'=>'email',
	   							'required' =>true,
    							'message' => 'Please input valid email address',
    							'last'=>true,
								'on' => 'create'
    					),
						'emailUnique' => array(
							'rule'=>'isUnique',
							'message' => 'This email has already been registered with Bantana.',
							'last'=>true,
							'on' => 'create'
							
						)
    			),
		'new_password' => array
    					(
    					'ruleNotEmpty' => array(
    						'rule' => array('minLength', '8'),
    						'required' =>true,
    						'message' => 'Please provide password of at least 8 characters.',
    						'last'=>true,
							'on' => 'create'
    											), 
    					'newPasswordRule' => array(
    						'rule' => array('identicalFieldValues', 'confirm_password'),
    						'required' =>true,
    						'message' => 'Passwords must match.',
							'on' => 'create'
    					)
    		),
		'accept' => array(
					'rule' => array('equalTo', '1'),
					'message' => 'Must accept terms.',
					'on' => 'create'
					),
		'business_phone' => array(
					'rule'=>array('minLength',10),
					'message'=>'Please provide a phone number.',
					'on'=>'create'
					)
					
  		);
    



}
?>
