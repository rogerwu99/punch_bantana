<div id="nww_location"><table border>
<? if (!$confirm): ?>          
  	<tr><td><?php echo $form->create('Merchant');//, //array('url' => array('controller'=>'merchants','action' => 'locations'))); ?>
                   Name / Description (i.e. Chelsea, Manhattan loc)(required)
                  <?php echo $form->input('name', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?><br>
                  
                  Address (required)
                  <?php echo $form->input('Address', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?><br>
                  City(required)<?php echo $form->input('City', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?><br>
        	  State(required)<? echo $form->select('State', $states);?><br>	
<? $max_visits = range(1,10); ?>
        Maximum Visits Per Day(required)
        <?php echo $form->input('max_visits',array('type' =>'select', 'label'=>false, 'options' => $max_visits,'selected' => 0)); ?>
<br /><?php echo $ajax->submit('Add',array('url'=>array('controller'=>'merchants','action'=>'locations'),'update'=>'new_location'));
?>
	<?php echo $form->end(); ?>
    <?php echo $html->link('Cancel',array('controller'=>'merchants','action'=>'dashboard')); ?>
         </td>
</tr>                
<? else: ?>
<tr><td> <?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
     	?>


	<article>
      <p>Your location: <span id="status">
	</span></p>
   	
   </article>
   <? echo $lat; ?>, <? echo $long; ?>
   
   
   <script type="text/javascript">   
     	
	var map;
	window.onload=function() {
		
		 var latLng = new google.maps.LatLng(<? echo $lat; ?>, <? echo $long; ?>);
		 var mapcanvas = document.createElement('div');
  		 mapcanvas.id = 'mapcanvas';
  		 mapcanvas.style.height = '200px';
  		 mapcanvas.style.width = '300px';
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

	</td></tr>
<? endif; ?>              
</table>  
</div>

