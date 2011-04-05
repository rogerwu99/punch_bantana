<div id="leftcolumn" class="bodycopy">
<?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
		echo $javascript->link('new_location.js');
     ?>
     				<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hi <? echo $_Auth['User']['name']; ?>!</h1>
	                <div class="base-layer">
                 	<h4 class="table-caption">&nbsp;&nbsp;&nbsp;REWARDS <? echo $ajax->link('(Add)', array('controller'=>'merchants','action'=>'rewards'), array('update'=>'new_reward')); ?></h4>
                    <div class="table-row-head">&nbsp;
        				<div class="left-layer24">Reward</div>
				        <div class="left-layer22">Pts</div>
 				        <div class="left-layer22">Start</div>
        				<div class="left-layer22">End</div>
 				        <div class="left-edit-layer22">&nbsp;</div>
 				        <div class="right-layer11">&nbsp;</div>
 			        </div>
        			<div class="table-top">
        				<div id="new_reward">
                        <? if (empty($reward_list)): ?>
                        	<span>You have not entered any rewards yet.</span>
						<? endif; ?>
                		</div>
            	 		<? $odd = true; ?>
				        <?php foreach ($reward_list as $key=>$value){
							if ($reward_list[$key]['deleted']==0):
							$div_name = 'rewdiv_'.$reward_list[$key]['id'];
						?>
        				<div id="<? echo $div_name; ?>">
        				<? $class_name = ($odd) ? 'table-row-even' : 'table-row-odd'; ?>
            			<div class="<? echo $class_name; ?>">&nbsp;
			            	<div class="left-layer24"><? echo $reward_list[$key]['description']; ?></div>
							<div class="left-layer22"><? echo $reward_list[$key]['threshold']; ?></div>
							<div class="left-layer22"><? echo date('m/d/y',strtotime($reward_list[$key]['start_date'])); ?></div>
                			<? $end_date = (is_null($reward_list[$key]['end_date'])) ? 'none' : date('m/d/y',strtotime($reward_list[$key]['end_date'])); ?>
							<div class="left-layer22"><? echo $end_date; ?></div>	
   							<div class="left-edit-layer22"> <? echo $ajax->link('Edit',array('controller'=>'merchants','action'=>'edit_reward',$reward_list[$key]['id']), array('update'=>$div_name));?></div>
   							<div class="right-layer11">    <? echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_reward',$reward_list[$key]['id']),array(),'Are you sure you want to delete this reward?', false); ?></div>
						</div>
       					</div>
       					<div class="space-line"></div>
						<?	$odd = !$odd;
							endif;
						}?>
    				</div>
 				    <br />
    				<h4 class="table-caption">&nbsp;&nbsp;&nbsp;LOCATIONS <? echo $ajax->link('(Add)', array('controller'=>'merchants','action'=>'locations'),array('update'=>'new_location')); ?></h4>
        			<div class="table-row-head">&nbsp;
        				<div class="left-layer15">Name</div>
 				        <div class="left-layer14">Address</div>
				        <div class="left-layer12">Zip</div>
				        <div class="left-edit-layer22">&nbsp;</div>
        				<div class="right-layer11">&nbsp;</div>
        			</div>
        			<div class="table-top">
           				<div id="new_location">
                        <? if (empty($location_list)): ?>
            	            <span>You have not entered any locations yet.</span>
						<? endif; ?>
               			</div>
 			       	<? $location_list_copy = $location_list; ?>
        			<? $even = true; ?>
                   
					<?php foreach ($location_list as $key=>$value){
			   			if ($location_list[$key]['Location']['deleted']==0):
						$div_name = 'locdiv_'.$location_list[$key]['Location']['id']; ?>
 					<div id="<? echo $div_name; ?>">
        			<? $class_name = ($even) ? 'table-row-even' : 'table-row-odd'; ?>
            		<div class="<? echo $class_name; ?>">&nbsp;
			  			<div class="left-layer15"><? echo $location_list[$key]['Location']['description']; ?></div>
			  			<div class="left-layer14"><? echo $location_list[$key]['Location']['address']; ?></div>
			  			<div class="left-layer12"><? echo $location_list[$key]['Location']['zip']; ?></div>
	    				<div class="left-edit-layer22"><? echo $ajax->link('Edit',array('controller'=>'merchants','action'=>'edit_location',$location_list[$key]['Location']['id']), array('update'=>$div_name));?></div>
    					<div class="right-layer11"><?php echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_location',$location_list[$key]['Location']['id']),array(),'Are you sure you want to delete this location?', false); ?></div>
     				</div>
    				</div>
	 				<div class="space-line"></div>
					<? 	$even=!$even; 	
						endif;
					}?> 
                   	</div> 
					<br />
        			<h4 class="table-caption">&nbsp;&nbsp;&nbsp;MY QR CODES </h4>  
                	<div class="table-top">
                   		<div class="table-row">
                        <? if (empty($location_list_copy)): ?>
                        	<span>You have not entered any locations yet.</span>
						<? endif; ?>
	
						<?php foreach ($location_list_copy as $key=>$value){
				   			if ($location_list_copy[$key]['Location']['deleted']==0):
					 		$div_name = 'qrdiv_'.$location_list_copy[$key]['Location']['id']; ?>
             				<div class="left-layer13">
							<?	echo $location_list_copy[$key]['Location']['description']; ?>
							<div id="<? echo $div_name; ?>"><? echo $html->image('qrcodes/'.$location_list_copy[$key]['Location']['qr_path'], array('alt'=>'QR_Code', 'width'=>'87', 'height'=>'87'));?></div>
    						<? echo $ajax->link('Refresh',array('controller'=>'merchants','action'=>'qr_refresh',$location_list_copy[$key]['Location']['id']), array('update'=>$div_name));?>
 	                       </div>
    					<?	endif;
						}?>
    					</div>
        			</div>         
        			</div>
        <div style="float:right;">
	        <div id="fade" class="black_overlay"></div>
            <? echo $this->element('feedback',array("user_type" => "Merchant")); ?>     
		</div>    
        </div>