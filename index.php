<?php

include('functions.php');

include('Update.php');



$updater = new Update();


?>

<style>
  .row { display:block; padding:10px; margin:0px; position:relative; background:rgba(0,0,0,.1); width:auto; font-size:0px; }
  .row div { float:left; width:48%; margin:0px; padding:10px; border:1px solid #555; display:block; min-height:300px; font-size:initial; }
  .row div:nth-of-type(1){ float:left; border:2px dotted maroon; background:maroon; color:white; }
  .row div:nth-of-type(2){ float:right; border:2px dotted palegreen; background:palegreen; color:seagreen; }
  .row:after { content:''; display:block; clear:both; }
</style>

<div class='row'>
<div><h2>Current Files</h2><?php debug($updater->check_updates('update')); ?></div>
<div><h2>New Files</h2><?php debug($updater->check_updates('core')); ?></div>
</div>

<div class='diff'>
<div><h2>Difference Files</h2><?php debug($update->diff()); ?></div>
</div>
