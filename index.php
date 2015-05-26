<?php

include('functions.php');

include('Update.php');



$updater = new Update();


?>

<style>
  .row div, .diff div { overflow-x:hidden; overflow-y:auto; }

  .row { display:block; padding:10px; margin:0px; position:relative; background:rgba(0,0,0,.1); width:auto; font-size:0px; }
  .row div { float:left; width:48%; margin:0px; padding:10px; xborder:1px solid #555; display:block; height:350px; font-size:initial; }
  .row div:nth-of-type(1){ float:left; xborder:2px dotted maroon; background:maroon; color:white; }
  .row div:nth-of-type(2){ float:right; xborder:2px dotted palegreen; background:palegreen; color:seagreen; }
  .row:after { content:''; display:block; clear:both; }

  .diff { background:lightseagreen; }
  .diff div:nth-of-type(1){ background:darkblue;}
  .diff div:nth-of-type(2){ background:orangered; color:beige; }
</style>

<div class='row'>
<div><h2>Current Files</h2><?php debug($updater->check_updates('update')); ?></div>
<div><h2>New Files</h2><?php debug($updater->check_updates('core')); ?></div>
</div>

<div class='row diff'>
<div><h2>Different Files</h2><?php debug($updater->diff()); ?></div>
<div><h2>Must Upload Files</h2><?php debug($updater->must_upload_elements); ?></div>
</div>
