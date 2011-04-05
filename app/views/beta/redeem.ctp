<div class="clear"></div>
<div id="leftcolumn" class="bodycopy">
	You are about to redeem: <? echo $results['Reward']['description']; ?>
    <br />
    for: <? echo $results['Reward']['threshold']; ?> points
    <br />
	from: <? echo $html->image('/img/uploads/'.$results['Merchant'][0]['path'],array('alt'=>'Logo','width'=>75,'height'=>75)); ?>
	<? echo $results['Merchant'][0]['name']; ?>
    <br />
    Scan the QR code at the location in which you want to redeem!
	
</div>
        
        