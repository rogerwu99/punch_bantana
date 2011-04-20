<div id="leftcolumn" class="bodycopy">
     <div class="base-layer">
     <? //var_dump($user); ?>
                 	<h4 class="table-caption">&nbsp;&nbsp;&nbsp;EDIT INFORMATION </h4>
                    <div class="table-profile-edit-settings">
                    	<div class="form_name">
        				<? echo $form->create('Merchant', array('controller'=>'merchant','action'=>'edit')); ?>
						Contact Name:</div>
                        <div class="left-layer41">
						<?php echo $form->input('Name', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'text_field_edit','style'=>'width:217px','value'=>$user['name'])); ?>
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
                       Business Name:</div>
					   <div class="left-layer41"><?php echo $form->input('business_name', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'text_field_edit','size'=>15,'style'=>'width:217px','value'=>$user['business_name'] )); ?>
                       </div>
                    	<div class="left-layer41">Business Phone:</div>
						<div class="left-layer41"><?php echo $form->input('business_phone', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'text_field_edit','size'=>15,'style'=>'width:217px','value'=>$user['business_phone'] )); ?></div>
					    <div class="left-layer41">Business Website:</div>
						<div class="left-layer41"><?php echo $form->input('website', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'text_field_edit','size'=>15,'style'=>'width:217px','value'=>$user['website'] )); ?></div>
						<div class="left-layer42">	
                    	<?php echo $form->submit('SAVE!'); ?>
                        <?php echo $form->end(); ?>
						</div>
		                </div>	
    		<hr />
                    <h4 class="table-caption">&nbsp;&nbsp;&nbsp;EDIT LOGO </h4>
                    <div class="table-profile-edit">
        				<div class="left-layer41">
           					<? 	echo $form->create('Merchant', array('type' => 'file', 'action'=>'edit_pic'));
								echo $form->file('photo', array('style'=>'height:25px;')); ?>
                    	</div>
	      				<div class="left-layer41" style="position:relative;left:-135px;">
  							<?	echo $form->submit('UPLOAD');
								echo $form->end();
							?>
  						</div>
                    </div>
                    
 			  	<br />
        			
        <div> <!-- style="float: right; position: relative; top: 20px;"> -->
	        <div id="fade" class="black_overlay"></div>
            <? //echo $this->element('feedback',array("user_type" => "Merchant")); ?> 
           <!-- taking the feedback link out for now while I figure out the right implementation -->    
		</div>    
        </div>
        </div> 
				
