<?php

//This is the page title

$user = isset($_GET['user']) ? $_GET['user'] : $_SESSION['UserID'];
$title = $user."s' Profile";

$userobj = ISDB::getUserDetails($user);
//Include CSS to Header
$include_header = '

    ';

//Include JS to Footer
$include_footer = '
<script src="./include/js/plugins/sparkline/jquery.sparkline.min.js"></script>

   <script>
       $(document).ready(function() {
         var fullName = "";

           $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 48], {
               type: \'line\',
               width: \'100%\',
               height: \'50\',
               lineColor: \'#1ab394\',
               fillColor: "transparent"
           });

  


       var counter = 0;
       $.getJSON("./include/json/projects.json", function(data){
         for(var i = 0, len = data.length; i<len; i++){

           if(data[i].publisher != "'.$user.'"){
             continue;
           }
           counter++;
           var line = `
           <div class="social-feed-box">

                        <div class="pull-right social-action dropdown">
                            <button data-toggle="dropdown" class="dropdown-toggle btn-white">
                                <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu m-t-xs">
                                <li><a href="#">Remove Article</a></li>
                            </ul>
                        </div>
                        <div class="social-avatar" style="height: 65px;">
                          <strong>`+data[i].title+`</strong>
                            <a href="" class="pull-left">
                                <img style="height: 60px; width: 60px;" alt="image" src="./include/img/avatar/'.@$userobj["profilepic"].'">
                            </a>
                            <div class="media-body">
                                <a href="#">
                                    `;
                                    //Get author full name
                                    line += fullName;
                                line +=`
                                </a>
                                <small class="text-muted">`+data[i].date+`</small>
                            </div>

                        </div>
                        <div class="social-body">

                            <p>
                              `+data[i].desc+`
                            </p>

                            <div class="btn-group">
                                <button class="btn btn-white btn-xs"><i class="fa fa-thumbs-up"></i> Like this!</button>
                                <button class="btn btn-white btn-xs"><i class="fa fa-comments"></i> Comment</button>
                                <button class="btn btn-white btn-xs"><i class="fa fa-share"></i> Share</button>
                            </div>
                        </div>

                        <div class="social-footer">


                        </div>

                    </div>
           `;
           $("#p_projects_feed").append(line);
         }
         $("#p_projects_size").append(counter);

      });


                 //Load data from followers.json to profile page
                 $.getJSON("./include/json/followers.json", function(data){
                   var count_following = 0;
                   var count_followed = 0;

                   for(var i = 0, len = data.length; i<len; i++){
                     if(data[i].follower != "'.$user.'"){
                       count_followed++;
                       continue;
                     }
                     for(var j = 0; j < data[i].following.length; j++){
                       count_following++;
                       $("#p_follow_users_images").append("<a href=\"#\"><img alt=\"image\" class=\"img-circle\" src=\"./include/img/avatar/"+data[i].following[j]+".jpg\"></a>");
                     }
                     $("#p_following_size").append(count_following);
                     $("#p_followers_size").append(count_followed);
                     $("#p_follow_text").append($("#p_name").text()+" is following " + counter + " users.");

                   }
                 });
/*
For following pics
  <a href=""><img alt="image" class="img-circle" src="img/a3.jpg"></a>
*/
   });


   </script>
';

//This is the page content
$content = '

            <div class="row m-b-lg m-t-lg">
                <div class="col-md-6">

                    <div class="profile-image">
                        <img src="./include/img/avatar/'.@$userobj["profilepic"].'" class="img-circle circle-border m-b-md" alt="profile">
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins" id="p_name">

                                </h2>
                                <h4 id="p_role"></h4>
                                <small id="p_role_desc">

                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                            <td colspan=2 align=center>
                                <strong>'.$userobj["num_projects"].'</strong> Projects
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>'.$userobj["num_followers"].'</strong> Followers
                            </td>
                            <td>
                               <strong>'.$userobj["num_following"].'</strong> Following
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>'.$userobj["num_skills"].'</strong> Skills
                            </td>
                            <td>
                                <strong>'.$userobj["num_research"].'</strong> Researches
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>



            </div>
            <div class="row">

                <div class="col-lg-3">

                    <div class="ibox">
                        <div class="ibox-content">
                                <h3>About <span id="p_name_about"></span></h3>

                            <p class="small" id="p_about_text">

Role: '.$userobj["role"].'<br />
Role Description: '.$userobj["role_desc"].'<br /><br />
'.$userobj["name"].' has '.$userobj["num_research"].' researches and has '.$userobj["num_skills"].' skill sets.
                            </p>

                            <p class="small font-bold">
                                <span><i class="fa fa-circle text-navy"></i> Online</span>
                                </p>

                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Users '.$user.' follows</h3>
                            <p class="small" id="p_follow_text">

                            </p>
                            <div class="user-friends" id="p_follow_users_images">
                        ';
foreach(ISDB::getFollowing($user) as $following)
{
    if($following == null)
    {
        $content .= $user." is not following anyone.";
    break;
    }
    $name = $following["id"];
    $avatar = $following["profilepic"];
    $content .= "<a href='./?act=profile&user=".$name."'><img alt=\"image\" title='".$name."' class=\"img-circle\" src=\"./include/img/avatar/".$avatar."\"></a>";
}
                    
                    $content .= '
                            </div>
                        </div>
                    </div>

 <div class="ibox">
                        <div class="ibox-content">
                            <h3>Users following '.$user.'</h3>
                            <p class="small" id="p_follow_text">

                            </p>
                            <div class="user-friends" id="p_follow_users_images">
                        ';
                    
                    
foreach(ISDB::getFollowersOf($user) as $following)
{
    if($following == null)
    {
        $content .= 'No one follows '.$user;
        break;
    }
    $name = $following["id"];
    $avatar = $following["profilepic"];
    $content .= "<a href='./?act=profile&user=".$name."'><img alt=\"image\" title='".$name."' class=\"img-circle\" src=\"./include/img/avatar/".$avatar."\"></a>";
}
                    
                    $content .= '
                            </div>
                        </div>
                    </div>



                </div>

                <div class="col-lg-5">

                    <div class="social-feed-box" id="p_projects_feed">

';
                    
                        //Feed
                    foreach(ISDB::getProjectsByUser($_SESSION['UserID']) as $project)
                    {
                        
                    }
                    
                    
                    $content .= '
                        
                    </div>




                </div>
                <div class="col-lg-4 m-b-lg">
                    <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon navy-bg">
                                <i class="fa fa-angellist"></i>
                            </div>

                            <div class="vertical-timeline-content">
                                <h2>Skills</h2>
                                <p id="p_skills_list">
                                    ';
                    foreach(ISDB::getUserSkills($user) as $skill)
                    {
                        if($skill == null)
                        {
                            $content .= "No skills applied.";
                            break;
                        }
                        $content .= "&bull; ".$skill["skillName"]."<br />";
                    }
                    
                    $content .= '
                                </p>
                                <a href="#" class="btn btn-sm btn-primary"> Edit Skills</a>

                            </div>
                        </div>

                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon blue-bg">
                                <i class="fa fa-file-text"></i>
                            </div>

                            <div class="vertical-timeline-content">
                                <h2>Research Interests</h2>
                                <p id="p_research_list">
     ';
                    foreach(ISDB::getUserResearch($user) as $research)
                    {
                        if($skill == null)
                        {
                            $content .= "No researches applied.";
                            break;
                        }
                        $content .= "&bull; ".$research["ResearchName"]."<br />";
                    }
                    
                    $content .= '
</p>
                                <a href="#" class="btn btn-sm btn-success"> Edit Interests </a>

                            </div>
                        </div>


                    </div>

                </div>

            </div>
';
?>
