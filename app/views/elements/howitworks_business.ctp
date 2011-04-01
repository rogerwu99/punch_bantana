<div style="margin-left:60px;">
<h4>Bantana for Businesses</h4></div>
<div class="business-background" id="consumer" style="display:block;">
<div class="lightbox_content">
       <? echo '<div class="smallercopy_reg" style="color:red">'.$form->error('User.accept').'</div><br />'; ?>
			<? $session->flash(); ?>
            Sign up
		<?php echo $form->create('Merchant', array('action' => 'register')); ?>
                  <div class="smallercopy_reg">Name</div>
                  <div class='smallercopy_reg' style='color:red'><?php echo $form->input('name', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?></div>
                  <div class="smallercopy_reg">Email Address</div>
 				  <div class='smallercopy_reg' style='color:red'><?php echo $form->input('email', array('class'=>'required', 'title'=>'Please enter a valid email address', 'style'=>'width:217px', 'label'=>false)); ?></div>
			      <div class="smallercopy_reg">Password</div>
 				  <div class='smallercopy_reg' style='color:red'><?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'required validate-password', 'style'=>'width:217px', 'title'=>'Enter a password greater than 6 characters')); ?></div>
                  <div class="smallercopy_reg">Re-type Password</div>
                  <div class='smallercopy_reg' style='color:red'><?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'required validate-password-confirm', 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="smallercopy_reg">Business Name</div>
                  <div class='smallercopy_reg' style='color:red'><?php echo $form->input('business_name', array('label'=>false, 'class'=>'required validate-password-confirm', 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="smallercopy_reg">Business Phone</div>
                  <div class='smallercopy_reg' style='color:red'><?php echo $form->input('business_phone', array('label'=>false, 'class'=>'required validate-password-confirm', 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="smallercopy_reg">Website</div>
                  <div class='smallercopy_reg' style='color:red'><?php echo $form->input('website', array('label'=>false, 'class'=>'required validate-password-confirm', 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="smallercopy_reg">
                      <?php echo $form->checkbox('Merchant.accept', array('class'=>'required validate-one-required', 'title'=>'Please agree to terms and conditions'));?>Please read our <?php echo $html->link('Terms of Use', array('controller'=>'pages', 'action'=>'terms')); ?> and our <?php echo $html->link('Privacy Policy', array('controller'=>'pages', 'action'=>'privacy')); ?> before accepting.
                      </div>
                  <div class="smallercopy_reg">
    	<?php echo $form->submit('Create my Account!', array('name'=>'shorten', 'class'=>'button_green'));?>
 	   	<?php echo $form->end(); ?>
                  
</div>                   
                  
                </div>
               






</div>	

</div>
	