<div class="sidebar5" id="consumer" style="display:block;">
<?php 
if ($c == 'Pages'){
	$page = $a['pass'][0]; 
}
else if ($c == 'Merchants'){
$page = 'business';
}

else {
$page = 'home';
}

	?>
<?  if ($page == 'home'): ?>
<div style="float:right;">
	<?		echo $html->link($html->image("signin_facebook.gif", array('alt'=>'Login With FB', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'facebookLogin'), array('escape'=>false));	
	?>
	<br>
	<?	echo $html->link('Sign up','/users/register'); ?>
	|
	<?	echo $html->link('Log In','#',array('onClick'=>'Effect.SlideDown(\'logging_in\'); return false;', 'class'=>'bodyblue')); ?>
    
    <div id="logging_in" style="display:none">
	<span class="bodycopy">
		<?php 
			//echo $form->create('Auth',array('url'=>substr($this->here,strlen($this->base)))); 
			echo $form->create('User',array('controller'=>'users','action'=>'login')); 
    	 	?>
	</span>
			Email:<br>
			<?
			echo $form->input('Auth.username', array('label'=>false, 'style'=>'width:217px')); 
		 	?>
			Password:
			<?
			echo $form->input('Auth.password', array('type' => 'password', 'label'=>false, 'style'=>'width:217px'));
			?>
			<? 
			echo $form->submit('Login!', array('name'=>'submit', 'div'=>'rightbutton'));
			echo $form->end();
		?>
	</div>

    
	</div>
 <?  elseif ($page == 'business'): ?>   
    
   <div style="float:right;">
	<?	echo $html->link('Sign up','/merchants/register'); ?>
	|
	<?	echo $html->link('Log In','#',array('onClick'=>'Effect.SlideDown(\'logging_in\'); return false;', 'class'=>'bodyblue')); ?>
    
    
    <div id="logging_in" style="display:none">
	<span class="bodycopy">
		<?php 
			//echo $form->create('Auth',array('url'=>substr($this->here,strlen($this->base)))); 
			echo $form->create('Merchant',array('controller'=>'merchants','action'=>'login')); 
    	 	?>
	</span>
			Email:<br>
			<?
			echo $form->input('Auth.username', array('label'=>false, 'style'=>'width:217px')); 
		 	?>
			Password:
			<?
			echo $form->input('Auth.password', array('type' => 'password', 'label'=>false, 'style'=>'width:217px'));
			?>
			<? 
			echo $form->submit('Login!', array('name'=>'submit', 'div'=>'rightbutton'));
			echo $form->end();
		?>
	</div>

    
	</div>
    
    
    <? endif; ?>
    
    
</div>