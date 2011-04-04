<div id="leftcolumn" class="bodycopy">
     <div class="base-layer">
                 	<h4 class="table-caption">&nbsp;&nbsp;&nbsp;EDIT INFORMATION </h4>
              		<div class="table-profile-edit-settings-for-user">
                    	<div class="left-layer41">
        				<? echo $form->create('User', array('action'=>'edit')); ?>
						Name:</div>
                        <div class="left-layer41">
						<?php echo $form->input('Name', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'text_field_edit','style'=>'width:217px')); ?>
                        </div>
                    	<div class="left-layer41">
                        Password:</div>
                        <div class="left-layer41">
						<?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'text_field_edit','style'=>'width:217px', 'title'=>'Enter a password greater than 6 characters')); ?>
                        </div>
                    	<div class="left-layer41">
                        Confirm Password:</div>
						<div class="left-layer41">
						<?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'text_field_edit','size'=>15, 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?>
                        </div>
                       <div class="left-layer41">
                       Gender

                      </div>
					   <div class="left-layer41"><? echo $form->radio('Gender',array('1'=>'Male')); 
	 echo $form->radio('Gender',array('2'=>'Female')); 
	 
	 ?>
                       </div>
                    	<div class="left-layer41">Birthday</div>	

						<div class="left-layer41"><? echo $form->select('smonth', $months, array('selected'=>date('M',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('sdate', $dates,array('selected'=>date('j',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('syear', $years,array('selected'=>date('Y',strtotime($results['Reward']['start_date']))));?>
	</div>
    
    
     Social Settings
    <br />
	
	<div class="smallercopy" style="margin-left:100px;float:left;"> 
		
			
			
	</div>
					    <div class="left-layer41">Facebook</div>
						<div class="left-layer41"><?php if(empty($_Auth['User']['fb_uid'])):
			echo $html->link($html->image("signin_facebook.gif", array('alt'=>'Login With FB', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'facebookLogin'), array('escape'=>false));?>	            <? else: ?>
            <? echo "Facebook Connected"; ?>	<!--	<br><br>   -->
	
		<?php endif;?>	</div>
        <div class="left-layer41">Twitter</div>
						<div class="left-layer41"><?php if(empty($_Auth['User']['tw_uid'])): 
			echo $html->link($html->image("signin_twitter.gif", array('alt'=>'Login With Twitter', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'getRequestURL'),array('escape'=>false));?>
            <? else: ?>
            <? echo "Twitter Connected"; ?>	<!--	<br><br>   -->
		<?php endif;?>	</div>
						<div class="left-layer42">	
                    	<?php echo $form->submit('SAVE!'); ?>
                        <?php echo $form->end(); ?>
                        <? echo $html->link('Cancel','/users/view_my_profile'); ?>
	
						</div>
		                </div>	
    		<hr />
                    <h4 class="table-caption">&nbsp;&nbsp;&nbsp;EDIT MY PICTURE </h4>
                    <div class="table-profile-edit">
        				<div class="left-layer41">
           					<? 	echo $form->create('User', array('type' => 'file', 'action'=>'edit_pic'));
								echo $form->file('photo', array('style'=>'height:25px;')); ?>
                    	</div>
	      				<div class="left-layer41">
  							<?	echo $form->submit('SAVE!');
								echo $form->end();
							?>
  						</div>
                    </div>
                    
 			  	<br />
        			
        <div style="float:right;">
	        <div id="fade" class="black_overlay"></div>
            <? echo $this->element('feedback',array("user_type" => "User")); ?>     
		</div>    
        </div>
        </div> 
				

    

	
	
