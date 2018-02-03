<?php
if(@$_GET['do_files_submit'])
{
    echo "<pre>";
    print_r($_GET);
    print_r($_FILES);
    echo "</pre>";
 //   ISDB::addProject($_POST['title'], $_POST['desc'], $_POST['date_start'], $_POST['date_end']);
   // header("Location: ./");
    
}
$content = "";
$include_header = '   
        <link href="./include/css/dropzone.css" rel="stylesheet">

';
$include_footer = '
 <script src="./include/js/dropzone.js"></script>


';
$title = "Add Files to Project - ".$_POST['title'];
$display = "";






$content .= '<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

<form action="/web_hw3/include/php/parsefiles.php"
      class="dropzone"
      id="my-awesome-dropzone">
                 <input type="hidden" name="title" value="'.$_POST['title'].'" />
<input type="hidden" name="desc" value="'.$_POST['desc'].'" />
<input type="hidden" name="date_start" value="'.$_POST['date_start'].'" />
<input type="hidden" name="date_end" value="'.$_POST['date_end'].'" />
<input type="hidden" name="act" value="addfiles" />
<input type="hidden" name="do_files_submit" value="1" />
<button type="submit" class="btn btn-primary pull-right">Submit this form!</button>
</form>
        </div>
        </div>

';
?>