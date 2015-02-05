<!DOCTYPE html>
<html dir="ltr" lang="en-US"><head>
    <meta charset="utf-8">
    <title>Retrieve User</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="style.responsive.css" media="all">


    <script src="jquery.js"></script>
    <script src="script.js"></script>
    <script src="script.responsive.js"></script>
    <script lang="javascript" type="text/javascript">
        function ShowHide(divId){
            if(document.getElementById(divId).style.display === 'none')
            {
                document.getElementById(divId).style.display = 'block';
            }
            else{
                document.getElementById(divId).style.display = 'none';
            }
        }
    </script>


<style>.art-content .art-postcontent-0 .layout-item-old-0 { padding-right: 10px;padding-left: 10px;  }
.art-content .art-postcontent-0 .layout-item-old-1 { background: #FFFFFF; padding-right: 10px;padding-left: 10px;  }
.ie7 .post .layout-cell {border:none !important; padding:0 !important; }
.ie6 .post .layout-cell {border:none !important; padding:0 !important; }

</style></head>
    <body>
<div id="art-main">
    <div class="art-sheet clearfix">
<nav class="art-nav clearfix">
    <ul class="art-hmenu"><li><a href="index.html" >Home</a></li><li><a href="register.html" >Register</a></li>
        <li><a href="retrieve.php" class="active">Retrieve User</a></li></ul> 
    </nav>
<header class="art-header clearfix">


    <div class="art-shapes">
<h1 class="art-headline" data-left="17.97%">
    <a href="index.html">SOCIAL NETWORK</a>
</h1>
<h2 class="art-slogan" data-left="17.97%">Connect with friends and family</h2>


            </div>

                
                    
</header>
<div class="art-layout-wrapper clearfix">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content clearfix"><article class="art-post art-article">
       
               <form id="getform" name="getform" action="retrieve.php" method="post">
                <hr width =400px align="left" ><h1>Retrieve User</h1><hr width =400px align="left" >
                <table class="table">
                         <tbody>
                            <tr>
                            <td>User ID:</td>
                            <td><input type="text" id="userid" name="userid"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;"><input type="submit" id="get" name="get" value="Retrieve" onclick="showform()"></td>
                            </tr>
                        </tbody>
                 </table>
    </form>
                                
<!-- START OF PHP CODE -->
                                
       <?php 
            if(isset($_POST['get'])){  
                
                $userid = $_POST['userid'];
                // Connect to our DB with mysql_connect(<server>, <username>, <password>)
                    $sql_connection = mysql_connect("localhost", "root", "");

                    //if no connection then display this error message
                    if (!$sql_connection){
                        die("Cannot connect to database. Try again later.");
                    }
                    
                    mysql_select_db("simplesocialnetwork", $sql_connection);
                    
                    
                $sql = "SELECT user.id, user.name, user.sex, user.city, user.country, user.dateOfBirth, relationship_status.name as relationship_status, user.like_count
                        FROM user 
                        INNER JOIN relationship_status 
                        ON user.relationship_status = relationship_status.id
                        where user.id = '$userid'";
                
                #call stored procedure to calculate user activity
                $sql1 = "call Question1('$userid')";
                
                #Execute query to the mysql_query function
                $myData = mysql_query($sql, $sql_connection);
                $myData1 = mysql_query($sql1, $sql_connection);
                
                    #fetch array into $result
                    while ($result = mysql_fetch_array($myData))
                        {
                            $id = htmlspecialchars($result['id']);
                            $name = htmlspecialchars($result['name']);
                            $sex = htmlspecialchars($result['sex']);
                            $city = htmlspecialchars($result['city']);
                            $country = htmlspecialchars($result['country']);
                            $date = htmlspecialchars($result['dateOfBirth']);
                            $status = htmlspecialchars($result['relationship_status']);
                            $activity = htmlspecialchars($result['like_count']);
                            
                            #fetch result from stored procedure
                            while($result1 = mysql_fetch_array($myData1)){
                                    #if like_count from user table is null, show 0 instead of null
                                    if ($activity == NULL){
                                        $userAct = 0;
                                    } 
                                        else{
                                            #show result from stored procedure from row 5 which holds the like count value
                                            $userAct = ($result1[5]);
                                }
                                
                            }
                            echo ' <form id="form" name="form" action="user-activity.php" method="post" style="Display: block">'; 
                        }
                         
                         
                           
                         //show output on form.
                        //echo ' <form id="form" name="form" action="user-activity.php" method="post" style="Display: hide">'; 
               }
       ?>             

<!-- START OF PHP CODE -->
                <div class="art-postcontent art-postcontent-0 clearfix">
                    
<form id="form" name="form" style="Display: none">
    <hr width =400px align="left" ><h1>Retrieved User</h1><hr width =400px align="left" >
<p>** All fields required **</p>
                <table class="table">
                         <tbody>
                         <input type=hidden id="userid" name="userid" value="<?php echo $id;?>">
                            <tr>
                            <td>Name:</td>
                            <td><input type="text" id="firstname" name="name" value="<?php echo $name;?>"></td>
                            </tr>
                            <tr>
                            <td>Gender:</td>
                            <td><input type="text" id="sex" name="sex" value="<?php echo $sex;?>"></td>
                            </tr>
                            <tr>
                            <td>Date:</td>
                            <td><input type="text" id="date" name="date" value="<?php echo $date;?>"></td>
                            </tr>
                            <tr>
                            <td>Relationship Status:</td>
                            <td><input type="text" id="status" name="status" value="<?php echo $status;?>"></td>
                            </tr>
                            <tr>
                            <td>City:</td>
                            <td><input type="text" id="town" name="city" value="<?php echo $city;?>"></td>
                            </tr>
                            <tr>
                            <td>Country:</td>
                            <td><input type="text" id="country" name="country" value="<?php echo $country;?>"></td>
                            </tr>
                            <td>User Activity:</td>
                            <td><input type="text" id="country" name="activity" value="<?php echo $userAct;?>"></td>
                            </tbody>
                            </table>
    </form>
                </div>
</article></div>
                    </div>
                </div>
            </div><footer class="art-footer clearfix">
<p>Copyright © 2013, &nbsp;All Rights Reserved.</p>
</footer>

    </div>
   
</div>


</body></html>