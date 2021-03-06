<html>
<head>
    <title>Is That Crime!</title>
    <link rel="stylesheet" type="text/css" href="css/index_style.css">
    <link rel="stylesheet" type="text/css" href="css/navigation.css">
    <script src = 'js\default_pp_setter.js'></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyCF7ndFJ68221tpvVYDGMA4GAomtfb5MQA"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/blog_filter.js"></script>
    <script src="js/animation.js"></script>
    <script src = 'js/map.js'></script>
    <script src = 'js/tiles_animation.js'></script>
</head>


<body>
    <div>

    <!--============================
            Navigation Bar
        ============================ -->
    <div class="navigation">

            <?php

            require("Controllers/login_controller.php");
            require("Controllers/LocationController.php");
            $location_control = new LocationController();
            $login = new Login();
            if($login->isLogged())
            {
                echo "<img id='pro_pic' src='{$_SESSION['pro_pic']}' onerror='return setDefaultPP(this)'/>";
				echo "<b class = \"navigationb\">Welcome ". $login->getUsername(). "</b>";
                echo "<a class = \"right-li\" href = 'Views/action/logout.php'>Logout</a>";
            }
            else
            {
                echo "<b class = \"navigationb\">Hello World</b>";
                echo "<a class = \"right-li\" href = 'Views/login.php'>Login</a>";
            }
            if($login->isLogged())
                echo "<a class = \"right-li\" href = 'Views/user_info.php'>Profile</a>";
            else
                echo "<a class = \"right-li\" href = 'Views/signup.php'>Signup</a>";
                echo "<a class = \"right-li\" href = 'Views/crime_post.php'>Post Crime</a>";
                echo "<a class = \"right-li\" href = 'http://localhost:".$_SERVER['SERVER_PORT']."/Projects/aiub project/index.php'>Home</a>";
            ?>
    </div>
<!--================================
            BLOGs
====================================-->


<article>
    <nav>
        <a href="#"> <img src="img/gohome.png" width="40px" height="40px"></a>
        <a href="#section-1"> <img src="img/location_pointer.png" width="40px" height="40px"></a>
        <a href="#section-2"> <img src="img/chat.png" width="40px" height="40px"></a>
    </nav>
    <div id="index-content">
        <noscript><h4 style = "color:red; text-align: center;">Enable Javascript in your browser to access all the features of this web page.</h4></noscript>


        <div id="section-1">
            <div class="supporting-div"></div>
            <div id="sub-section-1-1">
                <b class="labels">Crime Map</b>
                <div id="map-canvas"></div>
                <span style="color:red;">Note: The markers in the map only indicates the parent areas and not the exact details.For example,Mohammedpur and
                not the exact area inside Mohammedpur will be marked.Also the position of the marker may not be completely accurate</span>
            </div>
            <div id="sub-section-1-2">
            <table id="crime_zone_table" border="1">
                <tr>
                    <th>Location</th>
                    <th>Number Of Crimes</th>
                </tr>
                <?php

                $loc_arr = json_decode($location_control->getJSONLocations() , true);
                for($i = 0; $i < sizeof($loc_arr);$i++)
                {
                    echo "<tr>
                        <td>{$loc_arr[$i]['loc_name']}</td>
                        <td>{$loc_arr[$i]['crimes']}</td>
                    </tr>";
                }

                 ?>
            </table>
            </div>
        </div>

        <div id = "section-2">
            <div class="supporting-div"></div>
            <div id = "left-content">
                <input type="text" name="serach" id = "searchbox" placeholder="search by">
                <select name="by" id = "searchby">
                        <option value = "location"> Location </option>
                        <option value = "category"> Category </option>
                        <option value = "user"> User </option>
                        <option value = "title"> Title </option>
                </select>
            </div>

            <div id = "all_blogs">

            <?php

                require_once("Controllers/BlogController.php");
                $blog = new BlogController();
                if($result = $blog->getAllBlogs()) //if there are blogs
                {
                    while($row = $result->fetch_assoc())
                    {

                        $blogger = "Anonymous"; //blogger name initially anonymous for protection
                        $body = $row["body"];
                        $title = $row["title"];
                        $blogger_pp = "";
                        if(strlen($body) > 100) //not showing the entire content in the index page
                        {
                            $body = substr($body , 0 , 100);
                            $body = $body."..........";
                        }
                        if(strlen($title) > 30)
                        {
                            $title = substr($title , 0 , 30);
                            $title = $title.".....";
                        }
                        if(!$row["name_hidden"]) //if the user wants to share his/her name
                        {
                            $blogger_id = $row["blogger_id"];
                            $blogger = $blog->bloggerName($blogger_id);
                            $blogger_pp = $blog->getBloggerProfilePicture($blogger_id);
                        }
                        echo "<div class = 'single_blog   blogs' id={$row['blog_id']} onMouseOver='myFunction(this.id)' onmouseout='hoverOutStyle(this.id)'>";

                        echo "<div class = 'single_blog1' id='sb1{$row['blog_id']}'>";
                            echo "<div class='div_blog_title'>"."<a class = 'blog_title' href = 'Views/blog.php/?blog_id=".$row['blog_id']."'><span class='title'>".$title."</span></a></div>";

                            echo "<div class = 'single_blog_content' class='blog'>";
                            echo "<p class= 'bold-blog-content'>Location - <span class='location'>".$row["location"]. "</span></p>";
                            echo "<p class= 'bold-blog-content'>Category -  <span class='category'>".$row["category"]."</span></p>";
                            echo "<p class= 'bold-blog-content'>By - <span class='user'>$blogger</span></p>";
                            echo "<p class= 'bold-blog-content'><img class='circled_pro_pic' src='$blogger_pp' onerror='return setDefaultPP(this)'/></p>";

                            echo "<hr/>";
                        echo "</div>";
                        echo "</div>";

                        echo "<div class = 'single_blog2' id='sb2{$row['blog_id']}'>";
                            echo "<div class='div_blog_title'>"."<a class = 'blog_title' href = 'Views/blog.php/?blog_id=".$row['blog_id']."'><span class='title'>".$title."</span></a></div>";

                            echo "<div class = 'single_blog_content' class='blog'>";
                            echo "<p class = 'datetime'>{$row['datetime']}</p>";
                            echo "<p class = 'body'>$body</p><br>";
                        echo "</div>";
                        echo "</div>";

                        echo "</div>";
                    }
                }
                else
                {
                    echo "<div class = \"single_blog\">";
                    echo "<div class =\"single_blog_content\">";
                        echo "<h1>No Crime Blogs To See</h1>";
                    echo "</div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>


</div>
</article>
</div>
</body>
</html>
