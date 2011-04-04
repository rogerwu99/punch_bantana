<div id="leftcolumn" class="bodycopy">
<?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
		echo $javascript->link('new_location.js');
     ?>
     				<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hi <? echo $user['name']; ?>!</h1>
                    <?php echo $html->image($image_link, array('alt'=>'Your Profile','width'=>50,'height'=>50,'class'=>'top'));?>
			<?php echo $html->link('Settings', array('controller'=>'users', 'action'=>'edit')); ?>
	                <div class="base-layer">
                 	<h4 class="table-caption">&nbsp;&nbsp;&nbsp;MY REWARDS <? //echo $ajax->link('(Add)', array('controller'=>'merchants','action'=>'rewards'), array('update'=>'new_reward')); ?></h4>
                    <div class="table-row-head">&nbsp;
        				<div class="left-layer24">Reward</div>
				        <div class="left-layer22">Pts</div>
 				        <div class="left-layer22">Start</div>
        				<div class="left-layer22">End</div>
 				        <div class="left-edit-layer22">&nbsp;</div>
 				        <div class="right-layer11">&nbsp;</div>
 			        </div>
                  <?php //echo $html->link('My Rewards', array('controller'=>'users', 'action'=>'my_rewards')); ?>
                  <? //var_dump($num_points); ?>
	    			<div class="table-top">
        				<? $odd = true; ?>
                        <? if (empty($mer_array_no_dupes)): ?>
                        You have no rewards yet!
                        <? endif; ?>
				        <?php foreach ($mer_array_no_dupes as $key=>$value){
							echo $mer_array_no_dupes[$key]['Merchant']['name'].'   ';
							for ($i=0;$i<sizeof($num_points);$i++){
						//		echo $num_points[$i]->merchant_id.' '.$mer_array_no_dupes[$key]['Merchant']['id'];
								if ($num_points[$i]->merchant_id==$mer_array_no_dupes[$key]['Merchant']['id']){
								//	echo $num_points[$i]->number.' visits';
									for ($j=0;$j<$num_points[$i]->number;$j++){
							//			echo $j;
										echo $html->image('star.png',array('alt'=>'star','width'=>20,'height'=>20,'class'=>'top'));
									}
									break;
								}
							}
							foreach ($mer_array_no_dupes[$key]['Reward'] as $key1=>$value1){
							if ($mer_array_no_dupes[$key]['Reward'][$key1]['deleted']==0):
							$div_name = 'rewdiv_'.$mer_array_no_dupes[$key]['Reward'][$key1]['id'];
						?>
        				<div id="<? echo $div_name; ?>">
        				<? $class_name = ($odd) ? 'table-row-even' : 'table-row-odd'; ?>
            			<div class="<? echo $class_name; ?>">&nbsp;
			            	<div class="left-layer24"><? echo $mer_array_no_dupes[$key]['Reward'][$key1]['description']; ?></div>
							<div class="left-layer22"><? echo $mer_array_no_dupes[$key]['Reward'][$key1]['threshold']; ?></div>
							<div class="left-layer22"><? echo date('m/d/y',strtotime($mer_array_no_dupes[$key]['Reward'][$key1]['start_date'])); ?></div>
                			<? $end_date = (is_null($mer_array_no_dupes[$key]['end_date'])) ? 'none' : date('Ymd',strtotime($mer_array_no_dupes[$key]['Reward'][$key1]['end_date'])); ?>
							<div class="left-layer22"><? echo $end_date; ?></div>	
   							</div>
       					</div>
       					<div class="space-line"></div>
						<?	$odd = !$odd;
							endif;
						}
						}?>
    				</div>
 				    <br />
    				<h4 class="table-caption">&nbsp;&nbsp;&nbsp;MY SPOTS <? //echo $ajax->link('(Add)', array('controller'=>'merchants','action'=>'locations'),array('update'=>'new_location')); ?></h4>
        			<div class="table-row-head">&nbsp;
        				<div class="left-layer71">Name</div>
 				        <div class="left-layer14">Address</div>
				        <div class="left-layer12">Zip</div>
				        <div class="left-edit-layer22">&nbsp;</div>
        				<div class="right-layer11">&nbsp;</div>
        			</div>
				   	<?php //echo $html->link('My Spots', array('controller'=>'users', 'action'=>'my_spots')); ?></legend>
  
        			<div class="table-top">
           				
 			       	<? $even = true; ?>
                    <? if (empty($loc_array)): ?>
                        You have no visits yet!
                    <? endif; ?>
	
					<?php 
						foreach ($loc_array as $key=>$value){
			   			if ($loc_array[$key]['Location']['deleted']==0):
						$div_name = 'locdiv_'.$loc_array[$key]['Location']['id']; ?>
 					<div id="<? echo $div_name; ?>">
        			<? $class_name = ($even) ? 'table-row-even' : 'table-row-odd'; ?>
            		<div class="<? echo $class_name; ?>">&nbsp;
              			<div class="left-layer71"><? echo $mer_array[$key]['Merchant']['name'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $loc_array[$key]['Location']['description']; ?></div>
			  			<div class="left-layer14"><? echo $loc_array[$key]['Location']['address']; ?></div>
			  			<div class="left-layer12"><? echo $loc_array[$key]['Location']['zip']; ?></div>
                        <div class="left-edit-layer22">
                        <? 	for ($j=0;$j<$loc_array[$key]['Location']['visits'];$j++){
								echo $html->image('star.png',array('alt'=>'star','width'=>20,'height'=>20,'class'=>'top'));
							}
						?>
                        </div>
	    				
     				</div>
    				</div>
	 				<div class="space-line"></div>
					<? 	$even=!$even; 	
						endif;
					}?> 
                   	</div> 
					<br />
        			
        			</div>
        <div style="float:right;">
	        <div id="fade" class="black_overlay"></div>
            <? echo $this->element('feedback',array("user_type" => "User")); ?>     
		</div>    
        </div>