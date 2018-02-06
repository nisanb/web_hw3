<?php
$page = $_SERVER['PHP_SELF'];
$sec = "5";
header("Refresh: $sec; url=$page");


$title = "Homepage";


/**
 * Like a project by logged user
 */
if(@isset($_GET['act']) && $_GET['act'] == "like" && @isset($_GET['pid']))
{
    ISDB::likeProject($_SESSION['UserID'], $_GET['pid']);
}


$projectsFeed = ISDB::getProjectFeed($_SESSION['UserID']);
$projectData = "";
foreach($projectsFeed as $project)
{
    $count_likes = ISDB::getProjectsLikesCount($project["id"]);
    $like = ISDB::isProjectLikedByUser($project["id"], $_SESSION['UserID']);
    $img = $like==true ? "_not" : "";
    $projectData .="<tr>
<td>
<a href='./?act=project&pid=".$project["id"]."'>".$project["Title"]."</a></td>
<td>
<a href='./?act=profile&user=".$project["UserID"]."'>".$project["UserID"]."</td>
<td>
".date("d/m/Y",strtotime($project["Date"]))."
</td>
<td>".date("d/m/Y",strtotime($project["ResearchStartDate"]))." to ".date("d/m/Y",strtotime($project["ResearchEndDate"]))."</td>
<td>".$project["Views"]." / ".$count_likes."</td>

<td><a href=\"./?act=like&pid=".$project["id"]."\">
<img src='./include/img/like_icon".$img.".png' style='width: 20px; height: 20px;' /></a>
</td></tr>";
}


$include_header = '<link href="./include/css/plugins/footable/footable.core.css" rel="stylesheet">';
$include_footer = '  <!-- FooTable -->
    <script src="./include/js/plugins/footable/footable.all.min.js"></script>
    <script>




        $(document).ready(function() {
$("footable").footable();
   setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-bottom-right",
                    showMethod: "slideDown",
                    timeOut: 1500
                };
                toastr.success("Refreshing NewsFeed", "iScience+ Notification");

            }, 3500);

});
	


       </script>';


$addArticle = '
<form method="POST" action="./?act=addproject">
<div class="input-group">

    <input name="title" type="text" placeholder="Add a new project - Project Title" class="input input-sm form-control" REQUIRED>
    <span class="input-group-btn">
            <button type="submit" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Post Project</button>
    </span>
</form>
</div>
';

if(@$_POST['projectTitle'])
{
    ISDB::addNotification($_SESSION['UserID'], 0, "Project <u>".$_POST['projectTitle']."</u> has been created successfully!");
}



$content = '<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>iScience News Feed</h5>

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
                        '.$addArticle.'
                        <div class="ibox-content">

                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="20">
                                <thead>
                                <tr>

                                    <th data-toggle="true">Project</th>
                                    <th>Name</th>
                                    <th>Date Published</th>
                                    <th data-hide="all">Project Dates</th>
                                    <th data-hide="all">Views / Likes</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id ="newsfeed">
                                        '.$projectData.'
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>iScience Job Hunt Area</h5>

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
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="4">
                                <thead>
                                <tr>
                                    <th data-toggle="true">Job Role</th>
                                    <th>Company Hiring</th>
                                    <th>Date Published</th>
                                    <th data-hide="all">Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id ="jobhunt">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>


';
?>
