<?php 
if(!empty($_Auth['User']['id']))
{ 
    header('location:'.Router::url('/',true).'users');
    exit;
}

?>
<?php echo $this->element('howitworks'); ?>
<?php $javascript->link('AC_RunActiveContent.js', false); ?>
<?php $javascript->link('prototype');?>
<?php $javascript->link('scriptaculous');?>

