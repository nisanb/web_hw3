<?php

$content = "";
$include_header = '   
<link href="./include/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="./include/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

';
$include_footer = '
   <!-- SUMMERNOTE -->
    <script src="./include/js/plugins/summernote/summernote.min.js"></script>

    <script>
        $(document).ready(function(){

            $(\'.summernote\').summernote();

       });
        var edit = function() {
            $(\'.click2edit\').summernote({focus: true});
        };
        var save = function() {
            var aHTML = $(\'.click2edit\').code(); //save HTML If you need(aHTML: array).
            $(\'.click2edit\').destroy();
        };
    </script>

';
$title = "Add Project - ".$_POST['title'];
$display = "";






$content .= '<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
 <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Adding Project - '.$_POST['title'].'</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form id="my_form" method="POST" class="form-horizontal" action="./?act=addfiles">
<div class="form-group"><label class="col-lg-2 control-label">Project Title</label>

                                    <div class="col-lg-10"><input type="text"  readonly="readonly" value="'.$_POST['title'].'" class="form-control"></div>
                                </div>
   <div class="hr-line-dashed"></div>
<div class="form-group"><label class="col-lg-2 control-label">Project Description</label>
<div class="col-lg-10">
<script>
$(document).ready(function(){
   $("#my_form").on("submit", function () {
        var hvalue = $(\'desc\').text();
        $(this).append("<input type=\'hidden\' name=\'myname\' value=\' " + hvalue + " \'/>");
    });
});
</script>
                <div class="ibox float-e-margins">
                    <div class="ibox-content no-padding">

                      <textarea style="height: 100px;" class="col-lg-12" name="desc" REQUIRED></textarea>
</div></div></div>
                          
</div>

 <div class="hr-line-dashed"></div>

                                <div class="form-group"><label class="col-sm-2 control-label">Research Start Date</label>
                                    <div class="col-sm-4"><input name="date_start" type="date" class="form-control" REQUIRED>

                                    </div>
                           
                     
      <label class="col-sm-2 control-label">Research End Date</label>
                                    <div class="col-sm-4"><input name="date_end" type="date" class="form-control" REQUIRED> 

                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                    <input type="hidden" name="title" value="'.$_POST['title'].'" />
                    <input type="hidden" name="do_submit" value="1" />
                    <input type="submit" class="col-lg-12 btn btn-info" value="Next Step" />

</form>
                                </div>
   <div class="hr-line-dashed"></div>
            
        </div>
        </div>';
?>