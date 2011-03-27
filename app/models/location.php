<?php
class Location extends AppModel {

	var $name = 'Location';
    var $actsAs = array('Containable');
	//var $hasOne = array('Merchant'=> array('dependent'=>true)); 
	
	  				
	function getLocations($id=null) {
		return $this->find('all',array('conditions'=>array('Location.merchant_id'=>$id)));
	}



}
?>
