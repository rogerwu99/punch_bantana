<? if (is_null($intro)) : ?>
	<div id="reg_content_user">
       		<?	$months = array(
							"Jan"=>"Jan",
							"Feb"=>"Feb",
							"Mar"=>"Mar",
							"Apr"=>"Apr",
							"May"=>"May",
							"Jun"=>"Jun",
							"Jul"=>"Jul",
							"Aug"=>"Aug",
							"Sep"=>"Sep",
							"Oct"=>"Oct",
							"Nov"=>"Nov",
							"Dec"=>"Dec"
							);
				$dates=range(1,31);
				$years=range((int)date('Y')-13,1900);	
				?> 
				<? $session->flash(); ?>
            	<div class="bodycopy_reg">Sign up</div>
				<?php echo $form->create('User', array('action' => 'register')); ?>
                  <div class="smallercopy_reg">Name</div>
                  <div class='smallercopy_err' style='color:red'><?php echo $form->input('name', array('label'=>false, 'class'=>'big_mobile_signup' )); ?></div>
                  <div class="smallercopy_reg">Email Address</div>
 				  <div class='smallercopy_err' style='color:red'><?php echo $form->input('email', array('class'=>'big_mobile_signup', 'title'=>'Please enter a valid email address',  'label'=>false)); ?></div>
			      <div class="smallercopy_reg">Password</div>
 				  <div class='smallercopy_err' style='color:red'><?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'big_mobile_signup', 'title'=>'Enter a password greater than 6 characters')); ?></div>
                  <div class="smallercopy_reg">Re-type Password</div>
                  <div class='smallercopy_err' style='color:red'><?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'big_mobile_signup', 'title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="smallercopy_reg">
                  	<div class="left-layer51">Gender</div>
					<div class="left-layer52">
						<? 	echo $form->radio('Gender',array('1'=>'Male')); 
	 						echo $form->radio('Gender',array('2'=>'Female')); ?>
                    </div>
                    <div class="left-layer51">Birthday</div>	
					<div class="left-layer52">
						<? echo $form->select('smonth', $months);?>
	    				<? echo $form->select('sdate', $dates);?>
	    				<? echo $form->select('syear', $years);?>
					</div>
                  </div>
                  <div class="smallercopy_reg"><br />
                  <? echo '<div class="smallercopy_err" style="color:red">'.$form->error('User.accept').'</div>'; ?>
                      <?php echo $form->checkbox('User.accept', array('class'=>'required validate-one-required', 'title'=>'Please agree to terms and conditions'));?>Please read our <?php echo $html->link('Terms of Use', array('controller'=>'pages', 'action'=>'terms')); ?> and our <?php echo $html->link('Privacy Policy', array('controller'=>'pages', 'action'=>'privacy')); ?> before accepting.
                      </div>
                  <div class="smallercopy_reg" style="text-align:center;"><br />
    				<?php echo $ajax->submit('Create my Account!', array('url'=>array('controller'=>'users','action'=>'register'),'update'=>'reg_content_user'));?>
 	   				<?php echo $form->end(); ?>        
				  </div>
             </div>      
<? else: ?>
	Thanks for signing up to Bantana!  Earning rewards has never been easier!  
    No more carrying around all of your loyalty cards...three easy steps..
    <ol>
    <li> Look for our QR Code near the register.  </li>
    <li> Scan it with your phone.</li>
    <li> You'll be immediately at the Bantana application to see how far away you are from rewards!  </li>
    </ol>
	<? echo $html->link('Go to my account!',array('controller'=>'users','action'=>'view_my_profile')); ?>
<? endif; ?>
