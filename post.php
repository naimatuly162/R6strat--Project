<!DOCTYPE html>
<?php
session_start();
    include("includes/profileheader.php");
    if(!isset($_SESSION['user_email'])){
header("location: index.php");
}
?>
<html>
<head>
  <?php
    $user = $_SESSION['user_email'];
    $get_user = "select * from users where user_email='$user'";
    $run_server = mysqli_query($conn, $get_user);
    $row = mysqli_fetch_array($run_user);
    $user_name = $row['user_name'];
    ?>
    <title><?php echo "$user_name"; ?></title>

<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- My CSS LINK -->
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <title>NewsFeed!</title>
    <!-- Adding jquery-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <!--My JavaScript-->
    <script type="text/JavaScript" src="js/profile.js"></script>

</head>
    <body>
    <div class="row">
        <div id="insert_post" class="col-sm-12">
            <center>
            <form action="home.php"?id=<?php echo $user_id; ?>" method= "post" id="f" enctype="multipart/form-data">
            <textarea class="form-control" id= "content" rows="4" name="content" placeholder="What's on your mind?"></textarea><br>
            <label class="btn btn-warning" id="upload_image_button" >Select Image
            <input types="file" name="upload_image" sixe="30">
            </label>
            <button id="btn-post" class="btm btn-success" name="sub">Post</button>
            </form>
            <?php insertPost(); ?>
            </center>       
         </div>
    </div>

    </body>
</html>