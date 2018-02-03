<?php
/**
 * ISDB Web 
 * (c) sk8r
 */
require_once './include/php/_jsonrpc2.php';

class ISDB{

    private static $server      =   "localhost";
    private static $user        =   "root";
    private static $pass        =   "";
    private static $db          =   "ISNetworkDB";
    

    /**
     * This function will add a new wallet to the database
     * @param unknown $email
     * @param unknown $walletID
     */
    public static function addAccount($email, $walletID, $walletHash, $label)
    {
        $email = self::trim_insert($email);
        $label = self::trim_insert($label);
        $walletHash = self::trim_insert($walletHash);
        $walletID = self::trim_insert($walletID);
        
        Linda::isValidWalletID($walletID);
        
        $conn = LindaSQL::getConn();
        $sql = "INSERT INTO wallets VALUES (\"$email\",\"$walletHash\",\"$label\",\"$walletID\")";
        if (!$result = $conn->query($sql)) {
            // Oh no! The query failed.
            throw new Exception("Could not generate a new wallet");
        }
        
        return true;
        
    }
 

    /**
     * Occures when a user attempts to log in using his email
     * @param unknown $email
     * @throws Exception
     * @return true if the user was created, false otherwise (already exists)
     */
    public static function login($email)
    {
        $conn = LindaSQL::getConn();
        $email = self::trim_where($email);

        $sql = "SELECT 2fa FROM users WHERE email in (\"$email\")";
        if (!$result = $conn->query($sql)) {
            // Oh no! The query failed.
            throw new Exception("Could not retreive account information.");
            exit;
        }

        $authKey = "";
        
        //Check if email is found in DB
        //If not - create a new wallet
        if ($result->num_rows === 0) {
            
           $authKey = self::init($email);
           Linda::createWallet($email);
           
           return true;
        }

        return false;

        $conn->close();
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



}
