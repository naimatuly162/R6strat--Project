<?php
    //This class will handle db query
    class dbmanager{
        //Creates connections 
        function dbConnection(){
            $conn = new mysqli("sql203.epizy.com","epiz_23119201","r6strat","epiz_23119201_data");
        //Checks connections
            if($conn->connect_error){
                die("Connection Failed".$conn->connect_error);
            }else{
                return $conn;
            }
        }
    //Searches friends of users friends table
    function searchAllFriends($conn,$username){
        $sql = "SELECT CASE WHEN (firstuser='naimatuly162' AND degree=1) THEN seconduser WHEN(seconduser='deadhead1316' AND degree=1) THEN firstuser END FROM epiz_23119201_data.friends";
        $result = $conn->query($sql);
        $row = $result->fetch_all();
        return $row;
    }
    //Sent friend request
    function sendFriendRequest($conn,$sender,$receiver){
        $sql = "INSERT INTO epiz_23119201_data.friends(firstuser, seconduser, degree) VALUES ('$sender','$receiver',0)";
        $conn->query($sql);
    }
    //accept friend request
    function acceptFriendRequest($conn,$sender,$receiver){
        $sql = "UPDATE epiz_23119201_data.friends SET degree = 1 WHERE firstuser='$sender' AND seconduser = '$receiver'";
        $conn->query($sql);
    }
    //cancel friend request
    function cancelFriendRequest($conn,$sender,$receiver){
        $sql = "DELETE FROM epiz_23119201_data.friends(firstuser ,seconduser , degree) VALUES ('$sender','$receiver',1)";
        $conn->query($sql);
    }

    //checks the users are already friends
    function  checksFriendRequestStatus($conn,$user,$otheruser){
        $sql = "SELECT degree FROM epiz_23119201_data.friends WHERE (firstuser='$user' AND seconduser = '$otheruser') OR (firstuser = '$otheruser' AND seconduser = '$user')";
        $result = $conn->query($sql);
        $row=$result->fetch_all();
        if(count($row)==0){
            return -1;
        }elseif ($row[0][0]==0){
            return 0;
        }else{
            return 1;
        }
     }
 }
 ?>

