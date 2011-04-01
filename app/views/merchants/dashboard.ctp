      <div id="leftcolumn"><? echo $html->image('/img/uploads/'.$_Auth['User']['path'], array('alt' => 'Pic', 'width' => 75, 'height' => 75, 'class' => 'top', 'align'=>'left'));?>
     <div class="bodycopy">
     Hi <? echo $_Auth['User']['name']; ?>
    <? echo $html->link('Edit Settings', array('controller'=>'merchants','action'=>'edit')); 
 ?>     </div>
			     <br />
                 <div class="base-layer">
                 
                 <h4 class="table-caption">REWARDS <? echo $ajax->link('(Add)', array('controller'=>'merchants','action'=>'rewards'), array('update'=>'new_reward')); ?></h4>
                        <div class="table-row-head">&nbsp;
        <div class="left-layer14">
        Reward
        </div>
        <div class="left-layer22">
        Pts
        </div>
        <div class="left-layer22">
        Start Date
        </div>
        <div class="left-layer22">
        End Date
        </div>
        <div class="left-layer22">
        &nbsp;
        </div>
        <div class="right-layer11">
        &nbsp;
        </div>
        </div>
        <div class="table-top">
        	
            	<div id="new_reward">
                </div>
            
 		<? $odd = true; ?>
		
        <?php foreach ($reward_list as $key=>$value){
				if ($reward_list[$key]['deleted']==0):
				$div_name = 'rewdiv_'.$reward_list[$key]['id'];
		?>
        <div id="<? echo $div_name; ?>">
        	<? $class_name = ($odd) ? 'table-row-even' : 'table-row-odd'; ?>
            <div class="<? echo $class_name; ?>">&nbsp;
		
            	<div class="left-layer14"><? echo $reward_list[$key]['description']; ?></div>
				<div class="left-layer22"><? echo $reward_list[$key]['threshold']; ?></div>
				<div class="left-layer22"><? echo date('m/d/y',strtotime($reward_list[$key]['start_date'])); ?></div>
                <? $end_date = (is_null($reward_list[$key]['end_date'])) ? 'none' : date('Ymd',strtotime($reward_list[$key]['end_date'])); ?>
				<div class="left-layer22"><? echo $end_date; ?></div>	
   				<div class="left-layer22"> <? echo $ajax->link('Edit',array('controller'=>'merchants','action'=>'edit_reward',$reward_list[$key]['id']), array('update'=>$div_name));?>
            	</div>
   				<div class="right-layer11">    <? echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_reward',$reward_list[$key]['id']),array(),'Are you sure you want to delete this reward?', false); ?>
				</div>
			</div>
       </div>
       
       <div class="space-line"></div>
		
	<?	
	endif;
	}?>
    </div>
    <br />
    	<h4 class="table-caption">LOCATIONS <? echo $ajax->link('(Add)', array('controller'=>'merchants','action'=>'locations'),array('update'=>'new_location')); ?></h4>
        <div class="table-row-head">&nbsp;
        <div class="left-layer15">
        Name
        </div>
        <div class="left-layer14">
        Address
        </div>
        <div class="left-layer12">
        Zip
        </div>
        <div class="left-layer12">
        &nbsp;
        </div>
        <div class="right-layer11">
        &nbsp;
        </div>
        </div>
        <div class="table-top">
        <!--<div class="table-row-head">&nbsp;
			--><div class="left-layer11">
            	<div id="new_location">
                </div>
            </div>
 <!--       </div>
     -->   
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
	    			<div class="left-layer12"><? echo $ajax->link('Edit',array('controller'=>'merchants','action'=>'edit_location',$location_list[$key]['Location']['id']), array('update'=>$div_name));?></div>
    			<div class="right-layer11"><?php echo $html->link('Delete', array('controller'=>'merchants', 'action'=>'delete_location',$location_list[$key]['Location']['id']),array(),'Are you sure you want to delete this location?', false); ?></div>
     		</div>
    	</div>
	 	<div class="space-line"></div>
	<? $even=!$even; ?><?	endif;
	}?> </div> 

    <br />
        <h4 class="table-caption">MY QR CODES </h4>  
                <div class="table-top">
                   <div class="table-row">
					<?php foreach ($location_list_copy as $key=>$value){
				   		if ($location_list_copy[$key]['Location']['deleted']==0):
					 	$div_name = 'qrdiv_'.$location_list_copy[$key]['Location']['id']; ?>
             			<div class="left-layer13">
						<?	echo $location_list_copy[$key]['Location']['description']; ?>
						<div id="<? echo $div_name; ?>">
							<? echo $html->image('qrcodes/'.$location_list_copy[$key]['Location']['qr_path'], array('alt'=>'QR_Code', 'width'=>'87', 'height'=>'87'));?>					
                        </div>
    						<? echo $ajax->link('Refresh',array('controller'=>'merchants','action'=>'qr_refresh',$location_list_copy[$key]['Location']['id']), array('update'=>$div_name));?>
                        </div>
                    
	<?	endif;
	}?>
    </div>
             		
        </div>         
        </div>
        <div style="float:right;">
            <? echo $this->element('feedback',array("user_type" => "Merchant")); ?>     
		</div>    
        </div>
        </div>         
		</div>