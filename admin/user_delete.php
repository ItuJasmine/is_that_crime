<?php

require_once(get_include_path()."\Projects\aiub project\Controllers\UserController.php");
$usercontrol = new UserController();
if(isset($_GET["user_id"]) /*&& isset($_GET["blog_id"])*/)
{
    $username = $usercontrol->getUsername($_GET["user_id"])["username"];
    chmod("{$_SERVER['DOCUMENT_ROOT']}/Projects/aiub project/uploads/$username" , 0777);
    rmdir_recursive("{$_SERVER['DOCUMENT_ROOT']}/Projects/aiub project/uploads/$username");
    $ok = $usercontrol->deleteUser($_GET['user_id']);
    if($ok)
        echo "ok";
        //header("Location: htt\//Projects/aiub project/action/blog.php/?blog_id={$_GET['blog_id']}");
    else
        echo "Something Went Wrong";
}
function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
        else unlink("$dir/$file");
    }
    rmdir($dir);
}


 ?>
