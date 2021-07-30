<?php 

/**

  * File handler open
  * Return Text/html

*/

userspace();

if(isset($_POST['spec_id'])) if(isset($_SESSION[$_POST['spec_id']]))  echo "<nosave/>";

if(isset($_POST['path']) and file_exists(DirSeparator(project_disk()->realpath.$_POST['path'])) == true){

  if((isset($_POST['path'])) and (!empty(@trim($_POST['path'])) and ($_POST['path'] !== "undefined"))) {

    $file_path = DirSeparator(project_disk()->realpath.$_POST['path']);

    $info = file_modulator($file_path);

    $ext = $info->content_type;

    if($ext !== 4){

      $script =  @read_file(DirSeparator(project_disk()->realpath.$_POST['path']));

    }else{
      
      $script = null;
    }


  }else{

    $script = null;

    $ext = "application/x-httpd-php";

  }

}else{

  $script =  null;
  $ext = "application/x-httpd-php";

}

?>

<?php

switch($ext){

  // load image
  case 1:  

  $path = $file_path;
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = implode(null,file($path));
  $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

  ?>

  <div class="img-preview">

    <img style="max-width: 25%;margin-top:10%" src="<?=$base64?>">

    </div>

  <?php 

  break; 

  // load mp3 / mp4
  case 3:

  $path = $file_path;
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = implode(null,file($path));
  $base64 = 'data:audio/' . $type . ';base64,' . base64_encode($data);
  ?>

   <div class="img-preview">
    <audio controls style="margin-top:15%">

      <source style="display:none;" id="source" src="<?=$base64?>" type="audio/mpeg">
        
    </audio>
   </div>

  <?php
  break;

  case 4 :
  ?>

   <div class="img-preview" style="padding-top: 50px;">
    
      <p style="color:#fff">Sorry, File Not Support</p>

   </div>

  <?php
  break;


  // load codemirror text
  default:
    ?>

    <div id="data-type-extention" ext="<?php echo $ext?>" class="texteditor" data="<?=DirSeparator(project_disk()->realpath.$_POST['path'])?>">

      <textarea id="code" name="code" style="display: none;"><?php 

      if(isset($_POST['spec_id']) and isset($_SESSION[$_POST['spec_id']])) {

        echo htmlspecialchars($_SESSION[$_POST['spec_id']]);

      }else{

        echo htmlspecialchars($script);

      }

      ?></textarea>

    </div>

    <?php 

    echo CallInlineJS("assets/js/codemirror-option.js");

    break;

    }

BlockFunction() ?>
