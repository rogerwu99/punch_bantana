<div id="leftcolumn_user" class="bodycopy-b">
     <div class="base-layer">
                    
                 	<h4 class="table-caption">&nbsp;&nbsp;&nbsp;EDIT INFORMATION </h4>
                	<h4 class="table-caption-mobile">&nbsp;&nbsp;&nbsp;EDIT INFORMATION </h4>
	                
                    <div class="table-profile-edit-settings-for-user">
                    	<div class="form_name">
                        <? //var_dump($user); ?>
						<? echo $form->create('User', array('action'=>'edit')); ?>
						Name:</div>
                        <div class="left-layer41">
						<?php echo $form->input('name', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'big_mobile_1','value'=>$user['name'])); ?>
                        </div>
                    	<div class="left-layer41">
                        Password:</div>
                        <div class="left-layer41">
						<?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'big_mobile_1', 'title'=>'Enter a password greater than 6 characters')); ?>
                        </div>
                    	<div class="left-layer41">
                        Confirm Password:</div>
						<div class="left-layer41">
						<?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'big_mobile_1', 'title'=>'Enter the same password for confirmation')); ?>
                        </div>
                       <div class="left-layer41">
                       Gender

                      </div>
                      <? $gender = array('1'=>'Male','2'=>'Female');
					  $attributes = array('legend'=>false,'value'=>$user['sex']);
					   ?>
					   <div class="left-layer41"><? echo $form->radio('sex',$gender,$attributes); 
 
	 ?>
                       </div>
                    	<div class="left-layer41">Birthday</div>	

						<div class="left-layer41"><? echo $form->select('smonth', $months, array('selected'=>date('M',strtotime($user['birthday']))));?>
	    <? echo $form->select('sdate', $dates,array('selected'=>date('j',strtotime($user['birthday']))-1));?>
	    <? echo $form->select('syear', $years,array('selected'=>date('y',strtotime($user['birthday']))));?>
	</div>
    
    <div class= "social-settings-header">
     Social Settings:
     </div>
    <br />
	
	<div class="smallercopy" style="margin-left:100px;float:left;"> 
		
			
			
	</div>
					    <div class="left-layer41">Facebook</div>
						<div class="left-layer41"><?php if(empty($_Auth['User']['fb_uid'])):
			echo $html->link($html->image("signin_facebook.gif", array('alt'=>'Login With FB', 'style'=>'margin-left:-650px;position:relative;top:-17px;', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'facebookLogin/1'), array('escape'=>false));?>	            <? else: ?>
            <? echo "Facebook Connected"; ?>	<!--	<br><br>   -->
	
		<?php endif;?>	</div>
        <div class="left-layer41">Twitter</div>
						<div class="left-layer41"><?php if(empty($_Auth['User']['tw_uid'])): 
			echo $html->link($html->image("signin_twitter.gif", array('alt'=>'Login With Twitter', 'style'=>'margin-left:-650px;position:relative;top:-17px;', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'getRequestURL'),array('escape'=>false));?>
            <? else: ?>
            <? echo "Twitter Connected"; ?>	<!--	<br><br>   -->
		<?php endif;?>	</div>
						<div class="left-layer42">	
                    	<?php echo $form->submit('SAVE'); ?>
                        <?php echo $form->end(); ?>
                        <? echo $html->link('Cancel','/users/view_my_profile'); ?>
	
						</div>
		                </div>	
    		<hr />
                    <h4 class="table-caption">&nbsp;&nbsp;&nbsp;EDIT MY PICTURE </h4>
                    <h4 class="table-caption-mobile">&nbsp;&nbsp;&nbsp;EDIT MY PICTURE </h4>
                    <div class="table-profile-edit">
        				<div class="left-layer41a">
           					<? 	echo $form->create('User', array('type' => 'file', 'action'=>'edit_pic'));
								echo $form->file('photo', array('style'=>'height:25px;position:relative;left:-20px')); ?>
                    	
                        </div>
	      				<div class="left-layer41b">
  							<?	echo $form->submit('UPLOAD');
								echo $form->end();
							?>
  						</div>
                    </div>
                    
 			  	<br />
        			
        <div  style="display: block; width: auto; height: float: left;">
<!--	        <div id="fade" class="black_overlay" style="display: block; float: left;height: 887px; top: 51px; left: 158px; width: 851px;z-index:1;"></div>
    -->        <? //echo $this->element('feedback',array("user_type" => "User")); ?>     
    <!-- taking the feedback link out for now while I figure out the right implementation -->
		</div>    
        </div>
        </div> 
				

    

	
	
