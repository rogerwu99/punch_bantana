                <div id="leftcolumn">

                
                    <div class="bodycopy">Business Sign up:</div>
                 <? echo '<div class="bodycopy" style="color:red">'.$form->error('User.accept').'</div><br />'; ?>
			<? $session->flash(); ?>
		<?php echo $form->create('Merchant', array('action' => 'register')); ?>
                  <div class="bodycopy">Name</div>
                  <div class='bodycopy' style='color:red'><?php echo $form->input('name', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?></div>
                  <div class="bodycopy">Email Address</div>
 				  <div class='bodycopy' style='color:red'><?php echo $form->input('email', array('class'=>'required', 'title'=>'Please enter a valid email address', 'style'=>'width:217px', 'label'=>false)); ?></div>
			      <div class="bodycopy">Password</div>
 				  <div class='bodycopy' style='color:red'><?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'required validate-password', 'style'=>'width:217px', 'title'=>'Enter a password greater than 6 characters')); ?></div>
                  <div class="bodycopy">Re-type Password</div>
                  <div class='bodycopy' style='color:red'><?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'required validate-password-confirm', 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?></div>
                  <div class="content1">
                      <?php echo $form->checkbox('Merchant.accept', array('class'=>'required validate-one-required', 'title'=>'Please agree to terms and conditions'));?><div class="bodycopy">Please read our <?php echo $html->link('Terms of Use', array('controller'=>'pages', 'action'=>'terms')); ?> and our <?php echo $html->link('Privacy Policy', array('controller'=>'pages', 'action'=>'privacy')); ?> before accepting.</div>
                      </div>
                      
                      
                      
                       <fieldset>
    <legend>Plans</legend>
			<input type="radio" name="data[User][plan]" value="Premium" id="UserChooseAPlan1"><span id="prem"></span><br>
<input type="radio" name="data[User][plan]" value="Super" id="UserChooseAPlan2"> <span id="supe"></span><br>
<input type="radio" name="data[User][plan]" value="Starter" id="UserChooseAPlan3"> <span id="star"></span><br />
</fieldset>

	<?php echo $this->element('pay');?>
    <br /><br />
	    	<?php echo $form->submit('Next!', array('name'=>'shorten', 'class'=>'button_green'));
	?>
    <?php echo $form->end(); ?>
    <?php echo $this->element('dcode'); ?>
                      
                      
                    <div class="content1">
                    <div class="content18">
                      <div class="floatleft"><? echo $html->image("create_my_account_button.jpg", array('alt'=>'Create my account', 'width'=>'205', 'height'=>'38')); ?></div><div class="floatleft"><?php echo $form->submit('submit_now_button.jpg');?></div>
                    </div></div>
		<?php echo $form->end(); ?>
                  
                  <script type="text/javascript">
						function formCallback(result, form) {
							window.status = "valiation callback for form '" + form.id + "': result = " + result;
						}
						
						var valid = new Validation('test', {immediate : true, onFormValidate : formCallback});
						Validation.addAllThese([
							['validate-password', 'Your password must be more than 6 characters and not be \'password\' or the same as your name', {
								minLength : 7,
								notOneOf : ['password','PASSWORD','1234567','0123456'],
								notEqualToField : 'field1'
							}],
							['validate-password-confirm', 'Your confirmation password does not match your first password, please try again.', {
								equalToField : 'ps_password'
							}]
						]);
					</script>
                  
                  
                  
                </div>
                <div id="rightcolumn">
                </div>



