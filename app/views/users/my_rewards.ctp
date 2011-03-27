
<fieldset>
 		<legend>My Rewards</legend>
		<div  style="display:block">
		<span class="bodycopy"><strong>
			<?php echo $html->link('Venue', array('controller'=>'beta','action'=>'view_my_profile')); ?> | 
			</strong></span>
			<?php echo $html->link('Distance', array('controller'=>'beta','action'=>'view_my_location')); ?>  		
			<span class="bodycopy"><strong>|</strong></span>
			<?php echo $html->link('Points for Rewards', array('controller'=>'beta','action'=>'index')); ?>  		
            
	</div>
    
</fieldset>
