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
	<div id="logging_in" style="display:block">
	<span class="bodycopy">
			<? echo $form->create('User',array('controller'=>'users','action'=>'login')); ?>
			Email:
			<? echo $form->input('Auth.username', array('div'=>false,'label'=>false, 'style'=>'width:100px')); ?>
			Password:
			<? 	echo $form->input('Auth.password', array('div'=>false,'type' => 'password', 'label'=>false, 'style'=>'width:100px'));
				echo $form->submit('Sign In!', array('name'=>'submit', 'div'=>false));
				echo $form->end();
			?>
    </span>
	<span style="float:right;margin-top:10px;"><?		echo $html->link($html->image("signin_facebook.gif", array('alt'=>'Login With FB', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'facebookLogin'), array('escape'=>false));	
	?>
	<?	//echo $html->link('Sign up','/users/register'); ?>
	</span>
    
	
    </div>

    
	</div>
 <?  elseif ($page == 'business'): ?>   
    
   <div style="float:right;">
	<?	//echo $html->link('Sign up','/merchants/register'); ?>
	<!-- | -->
	<?	//echo $html->link('Log In','#',array('onClick'=>'Effect.SlideDown(\'logging_in\'); return false;', 'class'=>'bodyblue')); ?>
    
    
    <div id="logging_in" style="display:block">
	<span class="bodycopy">
		<?php 
			//echo $form->create('Auth',array('url'=>substr($this->here,strlen($this->base)))); 
			echo $form->create('Merchant',array('controller'=>'merchants','action'=>'login')); 
    	 	?>
			Email: <? echo $form->input('Auth.username', array('div'=>false, 'error'=>false,'label'=>false, 'style'=>'width:100px')); ?>
			Password:<? echo $form->input('Auth.password', array('div'=>false,'error'=>false,'type' => 'password', 'label'=>false, 'style'=>'width:100px'));?>
			<? 
			echo $form->submit('Sign In!', array('div'=>false,'name'=>'submit'));
			echo $form->end();
		?>
	</span>
		
    </div>

    
	</div>
    
    
    <? endif; ?>
    
    
</div>