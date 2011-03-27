                <div id="leftcolumn">
          
                    <div class="bodycopy">Add a Reward:</div>
                 <? echo '<div class="bodycopy" style="color:red">'.$form->error('User.accept').'</div><br />'; ?>
			<? $session->flash(); ?>
		<?php $points=range(0,100); 
		 echo $form->create(null, array('url' => array('controller'=>'merchants','action' => 'rewards'))); ?>
                    <div class="bodycopy">Description (required)</div>
                  <div class='bodycopy' style='color:red'><?php echo $form->input('reward', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?></div>
                  <div class="bodycopy"># of Points needed</div>
                  <div class='bodycopy' style='color:red'><?php echo $form->input('points',array('label'=>false,'type'=>'select','options'=>$points)); ?>
</div>

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
	    
           
                      
                      
                      
                    <div class="content1">
                    <div class="content18">
                      <div class="floatleft"><? echo $html->image("create_my_account_button.jpg", array('alt'=>'Create my account', 'width'=>'205', 'height'=>'38')); ?></div><div class="floatleft"><?php echo $form->submit('submit_now_button.jpg');?></div>
                    </div></div>
		<?php echo $form->end(); ?>
                  
                  
                  
                </div>
                <div id="rightcolumn">
                </div>



