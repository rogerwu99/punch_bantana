<div style="margin-left:60px;">
	<h4>Smart Rewards for the Smart Customer</h4>
	<div class="smallercopy" style="float:right;margin-top:-35px;margin-right:-25px;">
	<? echo $html->link('Merchant Login',array('controller'=>'pages','action'=>'business')); ?>
	</div>
</div>
<div class="lightbox_content_user" id="reg_content">
<? echo $this->requestAction('/users/register',array('return')); ?>
</div>
<div class="consumer-background" id="consumer" style="display:block;">
	<div class="lightbox_content_user_block_1">
		Clutter Free!<br />
		<span class="smallercopy_user_home">All of your reward programs accessible from your smartphone.  No more forgotten punch cards!</span>
	</div>
	<div class="lightbox_content_user_block_2">
 		More Rewards!<br />
		<span class="smallercopy_user_home">Browse rewards and promotions from your favorite venues directly from your smartphone!</span>
	</div> 
	<div class="lightbox_content_user_block_3">
		Share with Friends!<br />
		<span class="smallercopy_user_home">Let your friends know what great rewards you are earnings via Facebook or Twitter!</span>
	</div> 
</div>
