<?php if (!$mobile): ?>
<?php if(!empty($_Auth['User'])): ?>
	<div class="sidebar5" id="logged_in">
	<div style="float:right;padding-top:2px;"class="bodycopy">
		<?php 
			if ($_Auth['User']['fb_pic_url']==''):  
				echo $html->image('/img/uploads/'.$_Auth['User']['path'], array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top', 'align'=>'left'));
			else: 
				echo $html->image($_Auth['User']['fb_pic_url'], array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top', 'align'=>'left'));
			endif; 
		?>
		
			
		<?php if (!$_Auth['User']['start_date']): ?>
			<? if ($this->params['action']=='view_my_profile'){
					echo $_Auth['User']['name'];
				}
				else {	
					echo $html->link($_Auth['User']['name'], array('controller'=>'users','action'=>'view_my_profile')); 
				}
				?>
                <strong> | </strong>
                <? if ($this->params['action']=='edit'){
					echo 'Settings';
				}
				else {	
					echo $html->link('Settings', array('controller'=>'users', 'action'=>'edit'));
				}
				?>	
				
				<strong>|</strong>
			<?php //echo $html->link('My Rewards', array('controller'=>'users','action'=>'my_rewards')); ?>  		
            	<!--<strong>|</strong>-->
			<?php echo $html->link('Sign Out', array('controller'=>'users', 'action'=>'logout')); ?>
		<? else: ?>
		<?php
				if ($this->params['action']=='dashboard'){
					echo 'Home';
				}
				else { 
					echo $html->link('Home', array('controller'=>'merchants','action'=>'dashboard')); 
				}
			?> 
            <strong>|</strong>
			<?php 
				if ($this->params['action']=='data'){
					echo 'Data';
				}
				else {
					echo $html->link('Data', array('controller'=>'merchants','action'=>'data'));  		
            	}
            ?>
            <strong>|</strong>
            <?php 
				if ($this->params['action']=='edit'){
					echo 'Settings';
				}
				else {
		            echo $html->link('Settings', array('controller'=>'merchants','action'=>'edit')); 		
            	}
            ?>
            <strong>|</strong>
        	<?php echo $html->link('Logout', array('controller'=>'merchants', 'action'=>'logout')); ?>
		<? endif; ?>		
	</div>
	
	
    
	</div>
<?php endif; ?>	
<div id="clear"></div>
<? else: ?>
this is a mobile site
<? endif; ?>
	


