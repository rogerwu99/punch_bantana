<? if (!$redeem): ?>
<div class="clear"></div>

 <div id="leftcolumn_user" style="margin-left:30px;">
 <input type="hidden" id="simplegeolat" value="<? echo $simplegeo_lat; ?>" />
	 <input type="hidden" id="simplegeolong" value="<? echo $simplegeo_long; ?>" />
	   <?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
     	echo $javascript->link('http://code.google.com/apis/gears/gears_init.js');
		echo $javascript->link('geo.js');
		echo $javascript->link('map.js');
		?>
	    
         <div class="mobile_message">
	<article>
       <span id="status"><? echo $simplegeo_address; ?>
	</span>
   
   </article>
	<? echo $html->link('Continue to My Rewards',array('controller'=>'users','action'=>'view_my_profile')); ?>
   <br /><br /> 
    
	</div></div>

<? else: ?>
	<div class="clear"></div>
 <div id="leftcolumn_user" style="margin-left:30px;">
 <input type="hidden" id="simplegeolat" value="<? echo $simplegeo_lat; ?>" />
	 <input type="hidden" id="simplegeolong" value="<? echo $simplegeo_long; ?>" />
	   <?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
     	echo $javascript->link('http://code.google.com/apis/gears/gears_init.js');
		echo $javascript->link('geo.js');
		echo $javascript->link('map_redeem.js');
		echo $javascript->link('clock.js');
		?>
        <div class="mobile_message">
	<article>
   <span id="status_1"><? echo $simplegeo_address; ?>
	</span>

   </article>
	
	<? echo $html->link('Continue to My Rewards',array('controller'=>'users','action'=>'view_my_profile')); ?>
    <br /><br />
   
		</div>
	</div>



<? endif; ?>