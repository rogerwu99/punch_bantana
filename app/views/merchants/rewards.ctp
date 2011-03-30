             <table border>  <tr><td>
         <? if (!$saved): ?>
           <?php $points=range(0,100); 
		// echo  $ajax->form('Merchant',array('type' => 'post', 'update'=>'new_reward','options' => array('url' => array('controller' => 'merchants','action' => 'rewards')))); 
		echo $form->create('Merchant');//,array('url'=>array('controller'=>'merchants','action'=>'rewards'))); 
		 ?>
                    Description (required)
                  <?php echo $form->input('reward', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?><br />
               # of Points needed
                  <?php //echo $form->input('points',array('label'=>false,'type'=>'select','options'=>$points)); 
				  echo $form->select('points',$points);
				  
				  ?><br />

Start Date
 <? $options=array('Now'=>'Now','Later'=>'Later');
		$attributes = array('legend'=>false,'value'=>'Now');
		echo $form->radio('start',$options,$attributes);
 	?>
    <? echo $form->select('smonth', $months);?>
	    <? echo $form->select('sdate', $dates);?>
	    <? echo $form->select('syear', $years);?>
	<br />
     Expires
     <? $options=array('Yes'=>'Yes','No'=>'No');
		$attributes = array('legend'=>false,'value'=>'No');
		echo $form->radio('expires',$options,$attributes);
 	?>
        <? echo $form->select('emonth', $months);?>
	    <? echo $form->select('edate', $dates);?>
	    <? echo $form->select('eyear', $years);?>
	                      
                      
                  <?php echo $ajax->submit('Add',array('url'=>array('controller'=>'merchants','action'=>'rewards'),'update'=>'new_reward')); ?>
                  <?php //echo $form->submit('Add');//,array('url'=>array('controller'=>'merchants','action'=>'rewards'))); ?>
                   
		<?php echo $form->end(); ?>
         <?php echo $html->link('Cancel',array('controller'=>'merchants','action'=>'dashboard')); ?>
         <? else: ?>
        <? 
//		var_dump($results);
		echo $results['Reward']['description'];
			echo $results['Reward']['threshold'];
			echo $results['Reward']['start_date'];
			echo $results['Reward']['end_date'];
?>		
    
    
         <? endif; ?>
</td></tr></table>