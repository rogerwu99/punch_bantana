             
         <? if (!$saved): ?>
         <? $session->flash(); ?>
       <? foreach($errors as $key=>$value){ ?>
       <div class='smallercopy_err' style='color:red'> 	<? echo $errors[$key]; ?> </div>
	   <? } ?>
           <?php $points=range(0,100); 
		
		echo $form->create('Merchant');
		 ?>
              
               <div class="left-layer14">
      
                  <?php echo $form->input('reward', array('label'=>false, 'class'=>'required', 'style'=>'width:200px')); ?>
        </div>
        <div class="left-layer22">
                  <?php  
				  echo $form->select('points',$points);
				  
				  ?>
        </div>
        <div class="left-layer22">
       <? $options=array('Now'=>'Now','Later'=>'Later');
		$attributes = array('legend'=>false,'value'=>'Now');
		echo $form->radio('start',$options,$attributes);
 	?>
    <? echo $form->select('smonth', $months);?>
	    <? echo $form->select('sdate', $dates);?>
	    <? echo $form->select('syear', $years);?>
	
        </div>
        <div class="left-layer22">
        <? $options=array('Yes'=>'Yes','No'=>'No');
		$attributes = array('legend'=>false,'value'=>'No');
		echo $form->radio('expires',$options,$attributes);
 	?>
        <? echo $form->select('emonth', $months);?>
	    <? echo $form->select('edate', $dates);?>
	    <? echo $form->select('eyear', $years);?>
        </div>
        <div class="left-layer22">
       <?php echo $ajax->submit('Add',array('url'=>array('controller'=>'merchants','action'=>'rewards'),'update'=>'new_reward')); ?>
     
                   </div>
        <div class="right-layer11">
                <?php echo $html->link('Cancel',array('controller'=>'merchants','action'=>'dashboard')); ?>
  <?php echo $form->end(); ?>
        </div>
        
		
         <? else: ?>
         <div class="table-row-even">&nbsp;
        		<div class="left-layer24"><? echo $results['Reward']['description']; ?></div>
				<div class="left-layer22"><? echo $results['Reward']['threshold']; ?></div>
				<div class="left-layer22"><? echo date('m/d/y',strtotime($results['Reward']['start_date'])); ?></div>
                <? $end_date = (is_null($results['Reward']['end_date'])) ? 'none' : date('m/d/y',strtotime($results['Reward']['end_date'])); ?>
				<div class="left-layer22"><? echo $end_date; ?></div>	
				<div class="left-edit-layer22">&nbsp;</div>	
				<div class="right-layer11">&nbsp;</div>	
	</div>                
	
    
         <? endif; ?>
