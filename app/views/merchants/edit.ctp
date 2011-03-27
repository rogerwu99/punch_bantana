<fieldset>
 		<legend>Edit Information</legend>
		<div  style="display:block">
	<? echo $form->create('Merchant', array('action'=>'edit'));
	?>	Name:<br>
		<?php 
			echo $form->input('Name', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'text_field_big','size'=>15 )); 
		?>
		Password:<br><?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'text_field_big', 'size'=>15,'style'=>'width:217px', 'title'=>'Enter a password greater than 6 characters')); ?>
		Confirm Password:<Br><?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'text_field_big','size'=>15, 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?>
	
    <br />
    
<!--    Social Settings
   --> <br /><? //var_dump($user);
	//	if (!$user['fb_uid']):
		//echo 'Login with Facebook';
		//endif;
		?>
        <br />
        <?
	 	//if (!$user['tw_uid']):
		//echo 'Login with Twitter';
		//endif;
		 ?>
    
    	<?php echo $form->submit('GO!', array('name'=>'shorten', 'class'=>'button_green'));
	//echo $html->link('Back','/users/view_my_profile');
	
	
	?>	<?php echo $form->end(); ?>
	
</fieldset>
	<fieldset>
 		<legend>Edit Picture</legend>
		<div class="corp_signup" style="display:block">
		
<?
	echo $form->create('Merhcant', array('type' => 'file',
									'action'=>'edit_pic'));
echo $form->file('photo', array('style'=>'height:25px;'));
?>
<?php echo $form->submit('GO!', array('name'=>'shorten', 'class'=>'button_green'));
		echo $form->end();

?>
</fieldset>
