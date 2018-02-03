<?php
/**
 * ISDB Web 
 * (c) sk8r
 */

class ISDB{

    private static $server      =   "localhost";
    private static $user        =   "root";
    private static $pass        =   "";
    private static $db          =   "ISNetworkDB";
    private static $avatarDir   =   "./include/img/avatar/";

    /**
     * This function will add a new wallet to the database
     * @param unknown $email
     * @param unknown $walletID
     */
    public static function addAccount($userID, $password, $name, $role, $role_desc, $avatar=null)
    {
        $conn = ISDB::getConn();
        
        $ext = end((explode(".", $_FILES['avatar']['name'])));
        $newFileName = $userID.".".$ext; 

        if(!@isset($avatar))
            $avatar = "Default.png";
        
        $sql = "SELECT * FROM Users WHERE id in (\"$userID\")";
        if (!$result = $conn->query($sql)) {
            // Oh no! The query failed.
            throw new Exception("Could not retreive account information.");
        }
        
        if ($result->num_rows > 0) {
           throw new Exception("User ID already exists in the system.");
        }
        
        
        $sql = "INSERT INTO Users VALUES (\"$userID\",\"$role\",\"$role_desc\",\"$name\", \"$baseFile\", \"$password\")";
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
            throw new Exception("Could not retreive account information.");
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

    
    /**
     * Retreive users from the database
     * @throws Exception
     * @return
     */
    public static function getUsers()
    {
        $conn = self::getConn();
        
        $sql = "SELECT * FROM Users";
        if (!$result = $conn->query($sql)) {
            // Oh no! The query failed.
            throw new Exception("Could not retreive account information.");
            exit;
        }
        
        return $result;
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
            throw new Exception("Could not retreive account information.");
            exit;
        }
        
        $rows = array();
        
        if($result->num_rows > 1) {
            while($row = $result->fetch_array())
            {
                array_push($rows, $row);
            }
        }
        else{
            array_push($rows, mysqli_fetch_array($result, MYSQLI_BOTH));
        }
        if(@$display)
        {
            echo"<pre>";
            echo $sql."<br />";
            print_r($rows);
            echo "</pre>";
            
        }
        
        //$t = mysqli_fetch_array($result, MYSQLI_BOTH);
        if($rows == null)
            return array();
        return $rows;
    }
    
    public static function isFollowing($user)
    {
        $loggedUser = $_SESSION['UserID'];
        $q = self::query("select * from Followers where FollowerID in (\"$loggedUser\") AND FollowingID in (\"$user\")");
        if($q[0] != null){
            return true;
        }
            
        
        return false;
                
    }
    
    public static function swapFollower($user)
    {
        $current = $_SESSION['UserID'];
        
        if(self::isFollowing($user))
        {
            self::queryUpdate("delete from Followers where FollowerID in (\"$current\") AND FollowingID in (\"$user\")");
        }
        else
        {
            self::queryUpdate("INSERT INTO Followers VALUES (\"$current\", \"$user\")");
        }
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
    
}
