<div id="tag_line">
	<h4>Smart Rewards for the Smart Customer</h4>
	<div class="smallercopy" id="merchant_login">
	<? echo $html->link('Merchant Login',array('controller'=>'pages','action'=>'business')); ?>
	</div>
</div>
<div class="lightbox_content_user" id="reg_content">
<? echo $this->requestAction('/users/register',array('return')); ?>
</div>

<div class="consumer-background" id="consumer" style="display:block;">
	<div class="lightbox_content_user_block_1">
		Clutter Free!<br />
		<span class="smallercopy_user_home">All of your reward programs accessible from your smartphone.  No more forgotten punch cards!<br />
        <? echo $html->image('android_icon.png',array('alt'=>'Android','width'=>30,'height'=>30)); ?>
        <? echo $html->image('blackberry_icon.png',array('alt'=>'Blackberry','width'=>30,'height'=>30)); ?>
        <? echo $html->image('iPhone_icon.png',array('alt'=>'iPhone','width'=>30,'height'=>30)); ?>
        </span>
	</div>
	<div class="lightbox_content_user_block_2">
 		More Rewards!<br />
		<span class="smallercopy_user_home">Browse rewards and promotions from your favorite venues directly from your smartphone!<br />
            <? echo $html->image('Cup_Coffee.png',array('alt'=>'Coffee','width'=>30,'height'=>30)); ?>
        <? echo $html->image('cupcake.png',array('alt'=>'Cupcake','width'=>30,'height'=>30)); ?>
        <? echo $html->image('slice_pizza.png',array('alt'=>'Pizza','width'=>30,'height'=>30)); ?>
	</span>
	    </div> 
	<div class="lightbox_content_user_block_3">
		Share with Friends!<br />
		<span class="smallercopy_user_home">Let your friends know what great rewards you are earnings via Facebook or Twitter!<br /><br />
             <? echo $html->image('Twitter-icon.png',array('alt'=>'Twitter','width'=>30,'height'=>30)); ?>
        <? echo $html->image('Facebook-icon.png',array('alt'=>'Facebook','width'=>30,'height'=>30)); ?>
        <? echo $html->image('foursquare-icon.png',array('alt'=>'Foursquare','width'=>30,'height'=>30)); ?>
	</span>
	</div> 
</div>
