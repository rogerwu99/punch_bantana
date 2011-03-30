



<fieldset>
 		<legend>Edit Information</legend>
		<div  style="display:block">
	<? echo $form->create('User', array('action'=>'edit'));
	?>	Name:<br>
		<?php 
			echo $form->input('Name', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'text_field_big','size'=>15 )); 
		?>
		Password:<br><?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'text_field_big', 'size'=>15,'style'=>'width:217px', 'title'=>'Enter a password greater than 6 characters')); ?>
		Confirm Password:<Br><?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'text_field_big','size'=>15, 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?>
	
    <? echo $form->radio('Gender',array('1'=>'male')); 
	 echo $form->radio('Gender',array('2'=>'female')); 
	 
	 ?>

    
    
  
<br />
	Birthday
<? echo $form->select('smonth', $months, array('selected'=>date('M',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('sdate', $dates,array('selected'=>date('j',strtotime($results['Reward']['start_date']))));?>
	    <? echo $form->select('syear', $years,array('selected'=>date('Y',strtotime($results['Reward']['start_date']))));?>
	
    
    
    
    <br />
    
    Social Settings
    <br />
	
	<div class="smallercopy" style="margin-left:100px;float:left;"> 
		<?php if(empty($_Auth['User']['fb_uid'])):
			echo $html->link($html->image("signin_facebook.gif", array('alt'=>'Login With FB', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'facebookLogin'), array('escape'=>false));?>	<!--	<br><br>  -->
		<?php endif;?>	
			
			<?php if(empty($_Auth['User']['tw_uid'])): 
			echo $html->link($html->image("signin_twitter.gif", array('alt'=>'Login With Twitter', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'getRequestURL'),array('escape'=>false));?>	<!--	<br><br>   -->
		<?php endif;?>
	</div>
    
	
	        <br />
    
    	<?php echo $form->submit('GO!', array('name'=>'shorten', 'class'=>'button_green'));
	echo $html->link('Back','/users/view_my_profile');
	
	
	?>	<?php echo $form->end(); ?>
	
</fieldset>
	<fieldset>
 		<legend>Edit Picture</legend>
		<div class="corp_signup" style="display:block">
		
<?
	echo $form->create('User', array('type' => 'file',
									'action'=>'edit_pic'));
echo $form->file('photo', array('style'=>'height:25px;'));
?>
<?php echo $form->submit('GO!', array('name'=>'shorten', 'class'=>'button_green'));
		echo $form->end();

?>
</fieldset>
