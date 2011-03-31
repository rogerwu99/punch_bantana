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
 		<legend><?php echo $html->link('My Rewards', array('controller'=>'users', 'action'=>'my_rewards')); ?></legend>
        	<? foreach ($mer_array as $key=>$value){
				echo $mer_array[$key]['Merchant']['name'];
				foreach ($mer_array[$key]['Reward'] as $key1=>$value1){
			?> &nbsp;&nbsp;&nbsp;<?		echo $mer_array[$key]['Reward'][$key1]['threshold'];?> <br />
                
	           &nbsp;&nbsp;&nbsp;    <? echo $mer_array[$key]['Reward'][$key1]['description'];
				}
			
			} ?>
	<br>
	</fieldset>
	<fieldset>
 		<legend>    	<?php echo $html->link('My Spots', array('controller'=>'users', 'action'=>'my_spots')); ?></legend>
    
    	<? foreach ($loc_array as $key=>$value){
				echo $loc_array[$key]['Location']['description'];
				echo $mer_array[$key]['Merchant']['name'];
				}
				?>
    
    
    
    <br>
	</fieldset>

</div>

</div>
	<div class="clear"></div>
	