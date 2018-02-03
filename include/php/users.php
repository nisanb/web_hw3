<?php
$content = "";
$title = "View Users";
$display = "";


if(@$_GET['actu'] == "swap")
{
    ISDB::swapFollower($_GET['id']);
}

foreach(ISDB::getUsers() as $user)
{
    $userDetails = ISDB::getUserDetails($user['id']);
    
    if($user['id'] != $_SESSION['UserID'])
    {
        if(ISDB::isFollowing($user['id']) == true)
        {
            $like = '<a href="./?act=users&actu=swap&id='.$user['id'].'" class="btn btn-sm btn-info"><i class="fa fa-user-plus"></i> Unfollow '.$user['id'].'</a>';
        }
        else
        {
            
            $like = '<a href="./?act=users&actu=swap&id='.$user['id'].'" class="btn btn-sm btn-danger"><i class="fa fa-user-plus"></i> Follow '.$user['id'].'</a>';
        }
        
    }
    else{
        $like = "<br /><br />";
    }
    
    
    $display .='

<div class="col-lg-4">
                <div class="contact-box">
                    <a href="./?act=profile&user='.$user['id'].'">
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="./include/img/avatar/'.$user['profilepic'].'">
                            <div class="m-t-xs font-bold"><span style="font-size: 14px;">'.$user['role'].'</span></div>
                            <div class="m-t-xs font-bold"><small>'.$user['role_desc'].'</small></div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong>'.$user['name'].'</strong></h3>
                        <address>
                            <strong>Further Details</strong><br>
                            <i class="fa fa-folder-o"> '.$userDetails["num_projects"].' Projects</i>
<br />
<i class="fa fa-users"></i> '.$userDetails["num_following"].' Following
                            <br />
<i class="fa fa-users"></i> '.$userDetails["num_followers"].' Followers</i>
                            <br />
<i class="fa fa-search"></i> '.$userDetails["num_research"].' Researches</i>
                            <br />
<i class="fa fa-soccer-ball-o"></i> '.$userDetails["num_skills"].' Skills</i>
<br /><br />


                        </address>
'.$like.'
                    </div>
                    <div class="clearfix"></div>
                        </a>
                </div>
            </div>





';
    
}



$content .= '<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
         '.$display.'
            
        </div>
        </div>';
?>