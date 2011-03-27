<div id="beta" class="section-1">
  <div class="clear"></div>
  
  <div id="users_form">
	<fieldset>
 		<legend><?php echo $results['User']['name']; ?></legend>
		<?php echo $html->image($image_link, array('alt'=>'Your Profile','width'=>50,'height'=>50,'class'=>'top'));?>
			<?php echo $html->link('Settings', array('controller'=>'users', 'action'=>'edit')); ?>
	<br>
	   </fieldset>
	<fieldset>
 		<legend>My Rewards</legend>
        	<?php echo $html->link('My Rewards', array('controller'=>'users', 'action'=>'my_rewards')); ?>
	<br>
	</fieldset>
	<fieldset>
 		<legend>My Spots</legend>
        	<?php echo $html->link('My Spots', array('controller'=>'users', 'action'=>'my_spots')); ?>
	<br>
	</fieldset>

</div>

</div>
	<div class="clear"></div>
	