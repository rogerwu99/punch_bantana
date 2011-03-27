<div id="leftcolumn">
<? if (!$confirm): ?>          
                    <div class="bodycopy">Add a Location:</div>
                 <? echo '<div class="bodycopy" style="color:red">'.$form->error('User.accept').'</div><br />'; ?>
			<? $session->flash(); ?>
		<?php echo $form->create(null, array('url' => array('controller'=>'merchants','action' => 'locations'))); ?>
                   <div class="bodycopy">Name / Description (i.e. Chelsea, Manhattan loc)(optional)</div>
                  <div class='bodycopy' style='color:red'><?php echo $form->input('name', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?></div>
                  
                  <div class="bodycopy">Address (required)</div>
                  <div class='bodycopy' style='color:red'><?php echo $form->input('Address', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?></div>
                  <div class="bodycopy">City(required)</div>
                  <div class='bodycopy' style='color:red'><?php echo $form->input('City', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?></div>
        	  <div class="bodycopy">State(required)</div>
                  <div class='bodycopy' style='color:red'><? echo $form->select('State', $states);?>
</div>	
        
                 
                      
                      
                    <div class="content1">
                    <div class="content18">
                      <div class="floatleft"><? echo $html->image("create_my_account_button.jpg", array('alt'=>'Add this location', 'width'=>'205', 'height'=>'38')); ?></div><div class="floatleft"><?php echo $form->submit('submit_now_button.jpg');?></div>
                    </div></div>
		<?php echo $form->end(); ?>
                
<? else: ?>
 <?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
     	?>


	<article>
      <p>Your location: <span id="status">
	</span></p>
   	<div id="right_col" style="float:right;width:200px;height:400px;"></div>
	
   </article>
   
   
   
   <script type="text/javascript">   
     	
	var map;
	window.onload=function() {
		
		 var latLng = new google.maps.LatLng(<? echo $lat; ?>, <? echo $long; ?>);
		 var mapcanvas = document.createElement('div');
  		 mapcanvas.id = 'mapcanvas';
  		 mapcanvas.style.height = '400px';
  		 mapcanvas.style.width = '500px';
	 	document.querySelector('article').appendChild(mapcanvas);
		var myOptions = {
     		zoom: 15,
			center:latLng,
    		mapTypeId: google.maps.MapTypeId.ROADMAP
  	 	};
  		map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
  
	 var marker = new google.maps.Marker({
										 position: latLng,
										 map: map,
										 title: 'You are here!'
										 
		
										 });
	}
    </script>

	
<? endif; ?>              
</div>  


