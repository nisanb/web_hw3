<?php
class ISDB{

    /*
    * Local
    *
    */
    private static $server      =   "localhost";
    private static $user        =   "root";
    private static $pass        =   "";
    private static $db          =   "ISNetworkDB";
    private static $avatarDir   =   "./include/img/avatar/";
  
    /*
    * Remote
    *
    private static $server      =   "localhost";
    private static $user        =   "id3907836_nisanuniv";
    private static $pass        =   "eog32g344";
    private static $db          =   "id3907836_isnetworkdb";
    private static $avatarDir   =   "./include/img/avatar/";
    */
    
    
    /**
     * This function will add a new wallet to the database
     * @param unknown $email
     * @param unknown $walletID
     */
    public static function addAccount($userID, $password, $name, $role, $role_desc, $avatar=null)
    {
        $conn = ISDB::getConn();

        $ext = @end((@explode(".", $_FILES['avatar']['name'])));
        $newFileName = $userID.".".$ext;

        if(!@isset($avatar))
            $avatar = "Default.png";

        $sql = "SELECT * FROM Users WHERE id in (\"$userID\")";
        if (!$result = $conn->query($sql)) {
            // Oh no! The query failed.
            throw new Exception("Failed to execute query:<br />".$sql);
        }

        if ($result->num_rows > 0) {
           throw new Exception("User ID already exists in the system.");
        }
        
        
        $sql = "INSERT INTO Users VALUES (\"$userID\",\"$role\",\"$role_desc\",\"$name\", \"$newFileName\", \"$password\")";

        if (!$result = $conn->query($sql)) {
            // Oh no! The query failed.
            throw new Exception("Could not generate a new account");
        }
        move_uploaded_file($_FILES['avatar']['tmp_name'], self::$avatarDir.$newFileName);


        $_SESSION['UserID'] = $userID;
        return true;

    }


    /**
     * Attempt to log in to the system
     * @throws Exception
     * @return
     */
    public static function login($UserID, $password)
    {
        $conn = self::getConn();

        $sql = "SELECT * FROM Users WHERE id in (\"$UserID\") AND password in (\"$password\")";
        if (!$result = $conn->query($sql)) {
            // Oh no! The query failed.
            throw new Exception("Failed to execute query:<br />".$sql);
            exit;
        }

        //Check if email is found in DB
        //If not - create a new wallet
        if ($result->num_rows === 0) {

           throw new Exception("Login details are incorrect.");
        }

        $_SESSION['UserID'] = $UserID;
        $conn->close();


        return true;


    }

    public static function getProjectDetails($pid)
    {
        return self::query("select * from Projects where id = ".$pid);
    }
    
    public static function getProjectLikes($pid)
    {
        return self::query("select * from userLikes inner join Users on Users.id = userLikes.uid where pid=".$pid);
    }
    
    public static function likeProject($user, $pid)
    {
        $owner = self::query("select * from Projects where id = ".$pid)[0]["UserID"];
        
        if(self::isProjectLikedByUser($pid, $user))
        {
            //User already likes the project - remove him
            self::queryUpdate("DELETE FROM userLikes WHERE uid in (\"$user\") AND pid=".$pid."");
            self::addNotification($user, 3, "You have successfully unliked project #".$pid);
            self::addNotification($owner, 3, "Your project was unliked by ".$user);
        }
        else
        {
            //User doesn't like the project - add him
            self::queryUpdate("INSERT INTO userLikes VALUES (\"$user\", \"$pid\")");
            self::addNotification($user, 0, "You have successfully liked project #".$pid);
            self::addNotification($owner, 0, "Your project was liked by ".$user);
        }
    }
    
    public static function getJobs()
    {
        return self::query("select * from JobOffers order by ID Desc");
    }
    
    public static function addView($pid)
    {
        self::queryUpdate("update Projects set Views=Views+1 where id = ".$pid);
    }
    
    public static function getProjectsLikesCount($pid)
    {
        $q = array_filter(self::query("select * from userLikes where pid=".$pid));
        return count($q);
        
    }
    
    public static function exportUsers()
    {
        $usersFile = "./include/json/users_new.json";
        
        $timeout = 15; //15 Seconds
        
        $fileUpdatedTime = (time() - @filemtime($usersFile) ) ."seconds ago";
        
        
        //Timeout has passed -> update file
        if($fileUpdatedTime >= $timeout)
        {
            //Get users
            $users = json_encode(self::getUsers(), JSON_PRETTY_PRINT);
            
            //Create new JSON
            $fp = fopen($usersFile, 'w');
            fwrite($fp, $users);
            fclose($fp);
        }
     
    }
    
    /**
     * Retreive users from the database
     * @throws Exception
     * @return
     */
    public static function getUsers($exclude = "")
    {
        if(!empty($exclude))
        {
            return self::query("select * from Users where id not in (\"$exclude\") order by Name ASC");
        }
        
        return self::query("select * from Users order by Name ASC");
    }

    /**
     * Returns an active MySQLI Connection
     * @return mysqli
     */
    private static function getConn()
    {
        $mysqli = new mysqli(self::$server, self::$user, self::$pass, self::$db);

        //In case SQL Connection did not work
        if ($mysqli->connect_errno) {
            throw new Exception("#00001 - Could not connect to server database");
        }

        return $mysqli;
    }

    /**
     * Returns an array with the users the $UserID is following
     * @param unknown $UserID
     */
    public static function getFollowing($UserID)
    {
        $result = self::query("select * from Followers inner join Users ON Followers.FollowingID=Users.id WHERE FollowerID in (\"$UserID\")");
        return $result;
    }
    
    /**
     * Returns an array with the followers of $UserID
     * @param unknown $UserID
     */
    public static function getFollowersOf($UserID)
    {
        $result = self::query("select * from Followers inner join Users ON Followers.FollowerID=Users.id WHERE FollowingID in (\"$UserID\")");
        return $result;


    }
    
    
    public static function isProjectLikedByUser($pid, $user)
    {
        $r = self::query("SELECT * from userLikes where uid in (\"$user\") and pid=".$pid."");
        return !empty($r);
    }
    
    private static function queryUpdate($sql)
    {
        $conn = self::getConn();

        if (!$result = $conn->query($sql)) {
            // Oh no! The query failed.
            throw new Exception("Could not intiate query ".$sql);
            exit;
        }

        $conn->close();

    }

    private static function query($sql, $display=false)
    {
        $conn = self::getConn();

        if (!$result = $conn->query($sql)) {
            // Oh no! The query failed.
            throw new Exception("Failed to execute query:<br />".$sql);
            exit;
        }
        $rows = array();
        
        if($result->num_rows > 1) {
            
            while($row = $result->fetch_array())
            {
                array_push($rows, $row);
            }
        }
        else if($result->num_rows == 1) {
            array_push($rows, mysqli_fetch_array($result, MYSQLI_BOTH));
        }else{
            if(@$display)
            {
                echo"<pre>";
                echo $result->num_rows." -> ". $sql."<br />";
                print_r($rows);
                echo "</pre>";
            }
            return array();
        }
        
        
        
        if(@$display)
        {
            echo"<pre>";
            echo $result->num_rows." -> ". $sql."<br />";
            print_r($rows);
            echo "</pre>";
            
        }
        
        return $rows;
    }

    public static function isFollowing($user)
    {
        $loggedUser = $_SESSION['UserID'];
        $q = self::query("select * from Followers where FollowerID in (\"$loggedUser\") AND FollowingID in (\"$user\")");
        
        return !empty($q);

    }

    public static function swapFollower($user)
    {
        $current = $_SESSION['UserID'];

        if(self::isFollowing($user))
        {
            self::queryUpdate("delete from Followers where FollowerID in (\"$current\") AND FollowingID in (\"$user\")");
            self::addNotification($_SESSION['UserID'], 1, "You have stopped following ".$user);
            self::addNotification($user, 2, $_SESSION['UserID']." has stopped following you.");
        }
        else
        {
            self::queryUpdate("INSERT INTO Followers VALUES (\"$current\", \"$user\")");
            self::addNotification($_SESSION['UserID'], 1, "You are now following ".$user);
            self::addNotification($user, 1, $_SESSION['UserID']." has started following you!");
        }
    }


    public static function addProject($title, $desc, $start, $end)
    {
        $user = $_SESSION['UserID'];
        self::queryUpdate("insert into Projects (UserID, Title, Description, ResearchStartDate, ResearchEndDate)
                VALUES(\"$user\",\"$title\",\"$desc\",\"$start\",\"$end\")");

        return self::query("select id from Projects where UserID in (\"$user\") ORDER BY id DESC LIMIT 1");
        
    }

    public static function getProjectsByUser($user)
    {
        return self::query("select * from Projects where UserID in (\"$user\")");
    }
    
    public static function getProjectFeed($user)
    {
        $projectArray = array();
        $followersResult = self::getFollowing($user);
        
        foreach($followersResult as $follow)
        {
            $projects = self::getProjectsByUser($follow["FollowingID"]);
            foreach($projects as $project)
            {
                $projectArray[$project[0]] = $project;
            }
        }
        
        $projects = self::getProjectsByUser($_SESSION['UserID']);
        foreach($projects as $project)
        {
            $projectArray[$project[0]] = $project;
        }
        
        
        
        $projectArray = array_filter($projectArray);
        arsort($projectArray);

        
        return $projectArray;
        
        
        
    }
    
    public static function print($obj)
    {
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
    }
    
    public static function getProjectFiles($ProjectID)
    {
        return self::query("select * from projectFiles where ProjectID=".$ProjectID);
    }

    public static function getNotifications($user, $last=5)
    {
        $q = self::query("select * from Notifications where UserID in (\"$user\") order by id desc LIMIT ".$last);
        return $q;
    }

    public static function getDynamicNotifications($user)
    {
        $q = self::query("select * from Notifications where UserID in (\"$user\") AND iStatus=0");

        self::queryUpdate("update Notifications set iStatus=1 where UserID in (\"$user\")");

        return $q;
    }

    public static function addNotification($user, $type, $message)
    {
        $sql = "INSERT INTO Notifications (iType, UserID, Message) VALUES (\"$type\", \"$user\", \"$message\")";
        self::queryUpdate($sql);
    }

    public static function getUserDetails($user)
    {
        $result = self::query("select * from Users where id in (\"$user\")");

        $num_projects   =   self::query("select count(*) as num_projects from Projects where UserID in (\"$user\")");
        $result[0]["num_projects"] = $num_projects[0]["num_projects"];

        $num_followers   =   self::query("select count(*) as num_followers from Followers where FollowingID in (\"$user\")");
        $result[0]["num_followers"] = $num_followers[0]["num_followers"];

        $num_following   =   self::query("select count(*) as num_following from Followers where FollowerID in (\"$user\")");
        $result[0]["num_following"] = $num_following[0]["num_following"];

        $num_skills   =   self::query("select count(*) as num_skills from userSkills where UserID in (\"$user\")");
        $result[0]["num_skills"] = $num_skills[0]["num_skills"];

        $num_research   =   self::query("select count(*) as num_research from userResearches where UserID in (\"$user\")");
        $result[0]["num_research"] = $num_research[0]["num_research"];



        return $result[0];
    }

    public static function getUserSkills($user)
    {
        return self::query("select * from userSkills inner join Skills ON userSkills.SkillID=Skills.id WHERE userSkills.UserID in (\"$user\")");
    }

    public static function getUserResearch($user)
    {
        return self::query("select * from userResearches inner join Research ON userResearches.ResearchID = Research.ResearchID WHERE userResearches.UserID in (\"$user\")");
    }

    public static function getMessages($from, $to="")
    {
        $loggedUser = $_SESSION['UserID'];
        
        if(@empty($to))
            $to = $_SESSION['UserID'];
        
        $q = self::query("select * from Messages WHERE FromID in (\"$from\", \"$to\") AND ToID in (\"$from\", \"$to\") order by ID ASC");
        
            self::queryUpdate("update Messages set readMsg=1 where ToID in (\"$loggedUser\")");
        
        return $q;
        
    }
    
    public static function getMessageAlerts($user)
    {
        return self::query("select * from Messages where ToID in (\"$user\") AND readMsg=0 order by id desc");
    }
    
    public static function addMessage($user, $sendto, $msg)
    {
       self::queryUpdate("INSERT INTO Messages (FromID, ToID, strMessage) VALUES (\"$user\", \"$sendto\", \"$msg\")");
       self::addNotification($user, 0, "Your message has been sent!");
       self::addNotification($sendto, 0, "You have received a message from ".$user);
    }

    
    public static function addFileToProject($projectID, $fileName)
    {
        self::queryUpdate("insert into projectFiles (ProjectID, fileName) VALUES (\"$projectID\", \"$fileName\")");
    }
    
    public static function getRand()
    {
        return rand(25125215, 125751258128512);
    }
    
    public static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
?>