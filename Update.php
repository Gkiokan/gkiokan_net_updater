<?php
/*
    Project: System Updater Class
    Author: Gkiokan Sali
    URI: www.gkiokan.net
    Project_URI: www.gkiokan.net/projects/update_class
    Date: 25.05.2015
    Comments: -//-
*/

class Update {
  public $version = "1.0";
  public $name    = "System Updater Class";
  public $author  = "Gkiokan Sali";
  public $plugin_path = "gkiokan.net/projects/update_class";
  public $core_path = "/core";
  public $class_path = "/class";

  public $setup = array('comments'=>0, 'variables'=>1, 'class'=>1, 'functions'=>0);

  public $new_elements = null;
  public $old_elements = null;

  public function __construct(){
    echo "<pre>";
    echo $this->name ." ". $this->version . " has been started";
    echo "<br>";
    echo "Author: $this->author <br>";
    echo "Plugin Path: $this->plugin_path <br>";
    echo "core Path: $this->core_path <br>";
    echo "class Path: $this->class_path <br>";
    echo "<br>";

    //$this->check_updates();
  }

  public function check_updates($p='core'){
    $dir = $p=='core' ? $this->core_path : $this->class_path;
    $dir = ".".$dir;
    $files = null;
    $new_file = null;

    debug($dir);

    if(is_dir($dir))
    $files = opendir($dir);

    if($files):
    while(($file = readdir())!==false):
      // Breakout basic stuff
      if($file=='.' or $file =='..') continue;

      // Do something with the files
      $classes = array();
      $code = file_get_contents($dir ."/". $file);
      $tokens = token_get_all($code);
      $count = count($tokens);
      /* -- Here you get only the Class Name if needen --
      for ($i = 2; $i < $count; $i++) {
        if (   $tokens[$i - 2][0] == T_CLASS
            && $tokens[$i - 1][0] == T_WHITESPACE
            && $tokens[$i][0] == T_STRING) {

            $class_name = $tokens[$i][1];
            $classes[] = $class_name;
        }
      } --- */

      $new_file[$file] = $this->build_new_token($tokens, $file);

    endwhile;
    endif;

    $p=='core' ? $this->new_elements = $new_file : $this->old_elements = $new_file;
    return $new_file;
  }


  public function build_new_token($tokens=array(), $file=null){
      $i=0;
      $func_break = false;
      $new = array('file'=>$file);
      foreach($tokens as $token){
          $id = (float)$token[0];
          $type   = token_name($id);
          $content = isset($token[1]) ? $token[1] : null;

          // Take a Break while in a function and get out when return appears.
          if($func_break==true && $type!='T_RETURN'):
            $i++;  continue;
          else:
            $func_break = false;
          endif;

          // Catch Comments (each one get a own key)
          if($this->setup['comments']==1)
          if($type=='T_COMMENT')
          $new['comments'][] = $content;

          // Catch >Variables (key belongs to their keys)
          if($this->setup['variables']==1)
          if($type=='T_VARIABLE')
          $new['variables'][$content] = $tokens[$i+4][1];

          // Catch Class, if you need to count more then one, switch $content to empty
          if($this->setup['class']==1)
          if($type=='T_CLASS')
          $new['class'] = $tokens[$i+2][1];

          // Catch all functions
          if($type=='T_FUNCTION'):
            if($this->setup['functions']==1)
            $new['functions'][] = $tokens[$i+2][1];
          $func_break = true;
          endif;

          // some cleanup for the debug
          //if($type!='UNKNOWN' and $type!='T_WHITESPACE')
          //$new['core'][$i] = array($type, $content);

          $i++;
      }



      return $new;
  }



}


 ?>
