<?php

if(!@isset($_GET['pid']))
{
    throw new Exception ("Project ID not found!");
}

ISDB::addView($_GET['pid']);

if(@isset($_GET['like']))
{
    ISDB::likeProject($_SESSION['UserID'], $_GET['pid']);
}
$project = ISDB::getProjectDetails($_GET['pid'])[0];

//This is the page title
$subtitle = "Project";
$title = $project["Title"];

$not = ISDB::isProjectLikedByUser($_GET['pid'], $_SESSION['UserID']) == false ? "" : "_not";
if(!@empty($not))
    $nota = "Un";
//Include CSS to Header
$include_header = '

    ';

//Include JS to Footer
$include_footer = "
   <script>
        $(document).ready(function(){

            $('#loading-example-btn').click(function () {
                btn = $(this);
                simpleLoad(btn, true)

                // Ajax example
//                $.ajax().always(function () {
//                    simpleLoad($(this), false)
//                });

                simpleLoad(btn, false)
            });
        });

        function simpleLoad(btn, state) {
            if (state) {
                btn.children().addClass('fa-spin');
                btn.contents().last().replaceWith(\" Loading\");
            } else {
                setTimeout(function () {
                    btn.children().removeClass('fa-spin');
                    btn.contents().last().replaceWith(\" Refresh\");
                }, 2000);
            }
        }
    </script>

";

//This is the page content
$content = '
<div class="row">
            <div class="col-lg-9">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <a href="./?act=project&pid='.$_GET['pid'].'&like" class="btn btn-white btn-xs pull-right"><img src="./include/img/like_icon'.@$not.'.png" style="width: 24px; height: 24px;" /> '.@$nota.'Like project</a>
                                        <h2><b>Title:</b> '.$project["Title"].'</h2>
                                    </div>
                                    <dl class="dl-horizontal">
                                        <dt>Status:</dt> <dd><span class="label label-primary">Active</span></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5">
                                    <dl class="dl-horizontal">

                                        <dt>Created by:</dt> <dd><a href="./?act=profile&user='.$project["UserID"].'">'.$project["UserID"].'</a></dd>
                                        <dt>Likes:</dt> <dd>  '.ISDB::getProjectsLikesCount($project["id"]).'</dd>
<dt>Views:</dt> <dd>  '.$project["Views"].'</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-7" id="cluster_info">
                                    <dl class="dl-horizontal">

                                        <dt>Created:</dt> <dd> 	'.date("d/m/Y",strtotime($project["Date"])).' </dd>
                                        <dt>Start Date:</dt> <dd> 	'.date("d/m/Y",strtotime($project["ResearchStartDate"])).' </dd>
                                        <dt>End Date:</dt> <dd> 	'.date("d/m/Y",strtotime($project["ResearchEndDate"])).' </dd>
                                        <dt>Liked By:</dt>
                                       <dd class="project-people">
';
    foreach(ISDB::getProjectLikes($_GET['pid']) as $liker)
    {
        $content .= "<a href='./?act=profile&user=".$liker[0]."'>
<img alt='image' title='".$liker["name"]."' class='img-circle' src='./include/img/avatar/".$liker["profilepic"]."' />
</a>";
                        
    }



        $content .= '
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Completed:</dt>
                                        <dd>
                                            <div class="progress progress-striped active m-b-sm">
                                                <div style="width: 60%;" class="progress-bar"></div>
                                            </div>
                                            <small>Project completed in <strong>60%</strong>. Remaining close the project, sign a contract and invoice.</small>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row m-t-sm">
                                <div class="col-lg-12">
                                <div class="panel blank-panel">
                                

                                <div class="panel-body">

                                <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                              
                                </div>
                                <div class="tab-pane" id="tab-2">

                                  

                                </div>
                                </div>

                                </div>

                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="wrapper wrapper-content project-manager">
                    <h4>Project description</h4>
                    <p class="small">
                       '.nl2br($project["Description"]).'
                    </p>
                    <p class="small font-bold">
                        <span><i class="fa fa-circle text-warning"></i> High priority</span>
                    </p>
                    <h5>Project tag</h5>
                    <ul class="tag-list" style="padding: 0">
                        <li><a href=""><i class="fa fa-tag"></i> '.$project["UserID"].'</a></li>
                        <li><a href=""><i class="fa fa-tag"></i> iScience+ Project</a></li>
                    </ul><br /><br />
                    <h5>Project files</h5>

                    <ul class="list-unstyled project-files">
';
            foreach(ISDB::getProjectFiles($_GET['pid']) as $file)
            {
                $content .= '<li><a target="self" href="./uploads/'.$file["fileName"].'" download><i class="fa fa-file"></i> '.$file["fileName"].'</a></li>';
            }

        
        $content .= '
                    </ul>
                    <div class="text-center m-t-md">
                        <a href="#" class="btn btn-xs btn-primary">Add files</a>
                        <a href="#" class="btn btn-xs btn-primary">Report contact</a>

                    </div>
                </div>
            </div>
        </div>
';
?>
