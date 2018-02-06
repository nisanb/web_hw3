<?php

$title = "Add Files to Project - ".@$_POST['title'];
$display = "";

if($_POST['do_submit'])
{
   $projectID = ISDB::addProject($_POST['title'], $_POST['desc'], $_POST['date_start'], $_POST['date_end']);
   $projectID = $projectID[0]["id"];
}

$content = "";

$include_header = '   
        <link href="./include/css/dropzone.css" rel="stylesheet">

';
$include_footer = '
 <script src="./include/js/dropzone.js"></script>


';






$content .= '<form action="upload.php" class="dropzone">
<input type="hidden" name="projectID" value="'.$projectID.'" /></form>

<br /><br />
<div class="row">
<form action="./" method="POST">
    <input type="hidden" name="projectTitle" value="'.$_POST['title'].'" />
    <input type="submit" class="col-md-12 btn btn-info" value="Finish Project Settings" />

</form>
</div>

';



?>