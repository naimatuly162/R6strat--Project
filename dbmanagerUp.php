<?php

    //This class will handle all the db query
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

        //This function inserts userdata inside user table
        function signupInsertData($conn,$username,$password,$email,$dp){
            $qry = "INSERT INTO epiz_23119201_data.user (username,password,email,dp,uplayname) VALUES ('$username','$password','$email','$dp','NULL')";
            if($conn->query($qry)===TRUE){
                return TRUE;
            }else{
                echo $conn->error;
                return FALSE;
            }
        }

        //This function checks unique Username
        function isUniqueUsername($conn,$username){
            $qry = "SELECT * FROM epiz_23119201_data.user WHERE username = '$username'";
            $row=$conn->query($qry);
            if($row->num_rows>0){
                return FALSE;
            }else{
                return TRUE;
            }
        }

        //This function checks unique Email
        function isUniquePassword($conn,$email){
            $qry = "SELECT * FROM epiz_23119201_data.user WHERE email = '$email'";
            $row=$conn->query($qry);
            if($row->num_rows>0){
                return FALSE;
            }else{
                return TRUE;
            }
        }

        // This function checks username and password for the login
        function isValidLogin($conn,$username,$password){
            $qry = "SELECT password FROM epiz_23119201_data.user WHERE username = '$username'";
            $valid = FALSE;
            $result=$conn->query($qry);
            $row=$result->fetch_assoc();
            if($row['password']==$password){
                $valid = TRUE;
            }
            return $valid;
        }

        //This function returns user information row
        function userInformation($conn,$username){
            $qry = "SELECT * FROM epiz_23119201_data.user WHERE username = '$username'";
            $result=$conn->query($qry);
            $row=$result->fetch_assoc();
            return $row;
        }

        //This function returns user post row
        function readUserPost($conn,$username){
            $qry = "SELECT * FROM epiz_23119201_data.posts WHERE username = '$username'";
            $result=$conn->query($qry);
            $row = $result->fetch_all();
            return $row;
        }

        //This function writes post data in post table
        function writeUserPost($conn,$username,$post){
            $date = date("Y/m/d");
            date_default_timezone_set("Asia/Dhaka");
            $time=date("h:i:sa");
            $likecount = 0;
            $qry = "INSERT INTO epiz_23119201_data.posts (username,post,postdate,posttime,likecount) VALUES ('$username','$post','$date','$time','$likecount')";
            $conn->query($qry);
        }

        //This function writes like data in posts table and likes table
        function writeLikeData($conn,$username,$postid){
            $qry1="UPDATE epiz_23119201_data.posts SET likecount = likecount + 1  WHERE postid = '$postid'";
            $qry2="INSERT INTO epiz_23119201_data.likes (postid,username) VALUES('$postid','$username')";
            $conn->query($qry1);
            $conn->query($qry2);
        }

        //This function deletes like data from posts table and likes table
        function deleteLikeData($conn,$username,$postid){
            $qry1="UPDATE epiz_23119201_data.posts SET likecount = likecount - 1  WHERE postid = '$postid'";
            $qry2="DELETE FROM epiz_23119201_data.likes WHERE postid = '$postid'";
            $con->query($qry1);
            $con->query($qry2);
        }

        //This function checks if user liked the post or not
        function isLiked($conn,$username,$postid){
            $qry = "SELECT * FROM epiz_23119201_data.likes where postid = '$postid' AND username = '$username'";
            $row = $conn->query($qry);
            if($row->num_rows>0){
                return TRUE;
            }else{
                return FALSE;
            }
        }

        //This function searches users form user table
        function searchUsers($conn,$searchUsername){
            $qry = "SELECT * FROM epiz_23119201_data.user WHERE username LIKE '%$searchUsername%'";
            $result = $conn->query($qry);
            $row = $result->fetch_all();
            return $row;
        }

        //This function writes sent friend request to friends table
        function sendFriendRequest($conn,$sender,$receiver){
            $qry = "INSERT INTO epiz_23119201_data.friends(firstuser, seconduser, degree) VALUES ('$sender','$receiver',0)";
            $con->query($qry);
        }

        //This function writes accept friend request to friends table
        function acceptFriendRequest($conn,$sender,$receiver){
            $qry = "UPDATE epiz_23119201_data.friends SET degree = 1 WHERE firstuser='$sender' AND seconduser = '$receiver'";
            $conn->query($qry);
        }

        //This function searches all friends of users from friends table
        function searchAllFriends($conn,$username){
            $qry = "SELECT CASE WHEN (firstuser='$username' AND degree=1) THEN seconduser WHEN(seconduser='$username' AND degree=1) THEN firstuser END FROM epiz_23119201_data.friends";
            $result = $conn->query($qry);
            $row = $result->fetch_all();
            return $row;
        }

        //This function checks if user is friends with other user
        function  searchFriendRequestStatus($conn,$username,$otheruser){
            $qry = "SELECT degree FROM epiz_23119201_data.friends WHERE (firstuser='$username' AND seconduser = '$otheruser') OR (firstuser = '$otheruser' AND seconduser = '$username')";
            $result = $conn->query($qry);
            $row=$result->fetch_all();
            if(count($row)==0){
                return -1;
            }elseif ($row[0][0]==0){
                return 0;
            }else{
                return 1;
            }
        }

        //This function deletes friend request from friends table
        function deleteFriendRequest($conn,$username,$otheruser){
            $qry = "DELETE FROM epiz_23119201_data.friends WHERE (firstuser='$username' AND seconduser = '$otheruser') OR (firstuser = '$otheruser' AND seconduser = '$username')";
            $conn->query($qry);
        }

        //This function checks if user received request or not
        function checkConfirmRequest($conn,$username,$otheruser){
            $qry = "SELECT * FROM epiz_23119201_data.friends WHERE firstuser = '$otheruser' AND seconduser = '$username' AND degree = 0";
            $row = $conn->query($qry);
            if($row->num_rows>0){
                return TRUE;
            }else{
                return FALSE;
            }
        }

        //This function returns the posts of users friends
        function readFriendPost($conn,$username){
            $qry = "SELECT * FROM epiz_23119201_data.posts,(SELECT (CASE WHEN(firstuser = '$username' AND degree = 1) THEN seconduser  WHEN(seconduser = '$username' AND degree = 1) THEN firstuser END)as friendlist FROM epiz_23119201_data.friends) as temp WHERE username = friendlist";
            $result=$conn->query($qry);
            $row = $result->fetch_all();
            return $row;
        }

        //This function returns post data
        function postData($conn,$id){
            $qry = "SELECT * FROM epiz_23119201_data.posts where postid = $id ";
            $result=$conn->query($qry);
            $row=$result->fetch_assoc();
            return $row;
        }
        //This function writes post data in post table
        function writeUserComment($conn,$username,$id,$comment){
            $date = date("Y/m/d");
            date_default_timezone_set("Asia/Dhaka");
            $time=date("h:i:sa");
            $likecount = 0;
            $qry = "INSERT INTO epiz_23119201_data.comments (postid,username,data,type,date,time) VALUES ('$id','$username','$comment','NULL','$date', '$time')";
            $conn->query($qry);
        }
        //This function returns comment data
        function commentData($conn,$id){
            $qry = "SELECT * FROM epiz_23119201_data.comments where postid = $id ";
            $result=$conn->query($qry);
            $row = $result->fetch_all();
            return $row;
        }
    }

?>