<?php 

function register_in_vb($username, $password, $email) 
{ 
    define('VB_AREA', 'External'); 
    define('SKIP_SESSIONCREATE', 0); 
    define('SKIP_USERINFO', 1); 
    define('CWD', './../../forum/' ); 
    require_once(CWD . '/includes/init.php'); 
    require_once(CWD . '/includes/functions_misc.php'); 

    $registry = $vbulletin;  
    unset($vbulletin);  
    $vbDb = $registry->db;  
    //declare as global vbulletin's registry and db objects  
    global $vbulletin,$db;  
    $vbulletin = $registry;  
    //backup the original $db object (new!!)  
    $backupdb = $db;  
    $db = $vbDb;  

    $newuser =& datamanager_init('User', $vbulletin, ERRTYPE_ARRAY); 
    $newuser->set('username', $username); 
    $newuser->set('email', $email); 
    $newuser->set('password', $password); 
    $newuser->set('usergroupid', 9); 
     
    $newuser->pre_save(); 
     
    if(empty($newuser->errors)){ 
        $db = $backupdb; 
        echo 1; 
        return $newuser->save(); 
         
    }else{ 
        $db = $backupdb; 
        echo 0; 
        print_r( $newuser->errors); 
    } 
         
} 

$key = $_GET['key']; 
$username = $_GET['username']; 
$password = $_GET['password']; 
$email = $_GET['email']; 

if ($key=='mysecretkey') 
{ 
    // Add the users to vBulletin 
    $newuserid = register_in_vb($username, $password, $email); 
} 

?>