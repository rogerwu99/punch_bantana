<?php if(!empty($_Auth['User'])): ?>
	<div class="sidebar5" id="logged_in">
	<div style="float:right;padding-top:2px;"class="smallercopywhite">
		<span style="margin-top:-25px;margin-left:-50px;"><?php 
			if ($_Auth['User']['fb_pic_url']==''):  
				echo $html->image('/img/uploads/'.$_Auth['User']['path'], array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top', 'align'=>'left'));
			else: 
				echo $html->image($_Auth['User']['fb_pic_url'], array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top', 'align'=>'left'));
			endif; 
		?></span>
		
			
		<?php if (!$_Auth['User']['start_date']): ?>
        <span class="bodycopy"><strong>
				<?php echo $html->link($_Auth['User']['name'], array('controller'=>'beta','action'=>'view_my_profile')); ?> | 
			</strong></span>	
			<?php echo $html->link('My Spots', array('controller'=>'users','action'=>'my_spots')); ?>  		
			<span class="bodycopy"><strong>|</strong></span>
			<?php echo $html->link('My Rewards', array('controller'=>'users','action'=>'my_rewards')); ?>  		
            <span class="bodycopy"><strong>|</strong></span>
			<?php echo $html->link('Sign Out', array('controller'=>'users', 'action'=>'logout')); ?><br>
		<? else: ?>
        <span class="bodycopy">
		<?php
				if ($this->params['action']=='dashboard'){
					echo 'Home';
				}
				else { 
					echo $html->link('Home', array('controller'=>'merchants','action'=>'dashboard')); 
				}
			?> 
            <span class="bodycopy"><strong>|</strong></span>
            
			<?php 
				if ($this->params['action']=='analytics'){
					echo 'Data';
				}
				else {
					echo $html->link('Data', array('controller'=>'merchants','action'=>'rewards'));  		
            	}
            ?>
            <span class="bodycopy"><strong>|</strong></span>
            <?php 
				if ($this->params['action']=='edit'){
					echo 'Settings';
				}
				else {
		            echo $html->link('Settings', array('controller'=>'merchants','action'=>'edit')); 		
            	}
            ?>
            <span class="bodycopy"><strong>|</strong></span>
            
        	<?php echo $html->link('Logout', array('controller'=>'merchants', 'action'=>'logout')); ?><br>
		</span>
		<? endif; ?>		
	</div>
	
	<div class="smallercopy" style="margin-left:100px;float:right;"> 
		<?php if (!$_Auth['User']['start_date']): ?>	
		<?php if(empty($_Auth['User']['fb_uid'])):
			echo $html->link($html->image("signin_facebook.gif", array('alt'=>'Login With FB', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'facebookLogin'), array('escape'=>false));?>	<!--	<br><br>  -->
			<?php elseif(empty($_Auth['User']['tw_uid'])): 
			echo $html->link($html->image("signin_twitter.gif", array('alt'=>'Login With Twitter', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'getRequestURL'),array('escape'=>false));?>	<!--	<br><br>   -->
		<?php endif;?>
		<?php endif;?>
	</div>
    
    
	</div>
<?php endif; ?>	
<div id="clear"></div>
	

