<? if (!$redeem): ?>
<div id="beta" class="section-1">
<div class="clear"></div>

 <div id="contents" style="margin-left:30px;">
 <input type="hidden" id="simplegeolat" value="<? echo $simplegeo_lat; ?>" />
	 <input type="hidden" id="simplegeolong" value="<? echo $simplegeo_long; ?>" />
	   <?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
     	echo $javascript->link('http://code.google.com/apis/gears/gears_init.js');
		echo $javascript->link('geo.js');
		echo $javascript->link('map.js');
		?>
	    </div>
		
		<article>
      <p>Your location: <span id="status"><? echo $simplegeo_address; ?>
	</span></p>
   	<div id="right_col" style="float:right;width:200px;height:400px;"></div>
	
   </article>
	
	<? echo $html->link('Continue to My Rewards',array('controller'=>'users','action'=>'view_my_profile')); ?>
    
    
	</div>
	</div>
<div class="clear"></div>
<? else: ?>
	<div class="clear"></div>
<? //var_dump($results); ?>
	<? //echo 'Redeem'; ?> 
    <? //echo $redeem_id; ?>
 <div id="contents" style="margin-left:30px;">
 <input type="hidden" id="simplegeolat" value="<? echo $simplegeo_lat; ?>" />
	 <input type="hidden" id="simplegeolong" value="<? echo $simplegeo_long; ?>" />
	   <?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
     	echo $javascript->link('http://code.google.com/apis/gears/gears_init.js');
		echo $javascript->link('geo.js');
		echo $javascript->link('map_redeem.js');
		echo $javascript->link('clock.js');
		?>
		</div>
		
		<article>
      <span id="status_1"><? echo $simplegeo_address; ?>
	</span>

   </article>
	
	<? echo $html->link('Continue to My Rewards',array('controller'=>'users','action'=>'view_my_profile')); ?>
    
   




<? endif; ?>