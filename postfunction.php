<?php
    //This class will handle db query
    class dbmanager{
        //This function creates connections and returns the connection
        function dbConnection(){
            $conn = new mysqli("sql203.epizy.com","epiz_23119201","r6strat","epiz_23119201_data");
            if($conn->connect_error){
                die("Connection Error".$conn->connect_error);
            }else{
                return $conn;
            }
        }
//This Function for inserting Post
function insertPost(){
    if(isset($_POST['sub'])){
    global $conn;
    global $user_id;

    $content = htmlentities($_POST['content']);
    $upload_image= $_FILES['upload_image']['name'];
    $image_tmp = $FILES['upload_image']['tmp_name'];
    $random_number = rand(1,100);
    if (strlen($content) > 250 ){
        echo "<script>alert('Please Use 250 or Less than 250 words!')</script>";
        echo "<script>window.open('post.php','_self')</script>";
    }else{
        if(strlen($upload_image) >= 1 && strlen($content) >= 1){
            move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
            $insert = "insert into posts (user_id, post_content,upload_image,post_date) values('$user_id','$content', '$upload_image.$random_number',NOW())";
            $run = mysqli_query($conn , $insert);
                        
    if($run){
        echo "<script>alart('Your Post Updated a moment ago!')<?script>";
        echo "<script>window.open('post.php','_self')<?script>";
        $update = "update users set posts ='yes' where user_id='$user_id'";
        $run_update = mysqli_query($conn , $update);
        }
    exit();
    }else{
        if($upload_image='' && $content== ''){
                
        echo "<script>alart('Error occured while uploading!')<?script>";
        echo "<script>window.open('post.php','_self')<?script>"; 
    }else{
        if($content==''){
        move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
        $insert = "insert into posts (user_id, post_content,upload_image,post_date) values('$user_id','No', '$upload_image.$random_number',NOW())";
        $run = mysqli_query($conn , $insert);
                        
        if($run){
        echo "<script>alart('Your Post Updated a moment ago!')<?script>";
        echo "<script>window.open('post.php','_self')<?script>";
        $update = "update users set posts ='yes' where user_id='$user_id'";
        $run_update = mysqli_query($conn , $update);

        }
        exit();
        } else{

        $insert = "insert into posts (user_id,post_date) values('$user_id','No',NOW())";
        $run = mysqli_query($conn , $insert);
                        
        if($run){
        echo "<script>alart('Your Post Updated a moment ago!')<?script>";
        echo "<script>window.open('post.php','_self')<?script>";
        $update = "update users set posts ='yes' where user_id='$user_id'";
        $run_update = mysqli_query($conn , $update);

        }
                    }
                }
            }
        }
    }
}
?>
