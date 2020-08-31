<?php
    function secure_session_start() {
        $name = 'secure_session_id';
        $httponly = true;
        $cookie_params = session_get_cookie_params();
        session_set_cookie_params($cookie_params["lifetime"], $cookie_params["path"], $cookie_params["domain"], $cookie_params["secure"], $httponly);
        session_name($name);
        session_start();
        session_regenerate_id(true);
    }
    
    function is_logged_in() {
        if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['password'])) {
            return true;
        } else {
            return false;
        }
    }
    function username_available($username, $email, $mysql_con) {
        $sql_query = "select * from users where username=? or email=?";
        $stmt = $mysql_con->prepare($sql_query);
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        if($stmt->num_rows == 0) {
            return true;
        } else {
            return false;
        }
    }
    function show_posts($result, $mysql_con) {
        while($r = mysqli_fetch_assoc($result)) {
            $title = $r["title"];
            $content = $r["content"];
            $date = $r["date"];

            $category_id = $r["category_id"];
            $stmt = $mysql_con->prepare("select title from categories where category_id=?");
            $stmt->bind_param('i', $category_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($category);
            $stmt->fetch();

            $user_id = $r["user_id"];
            $stmt = $mysql_con->prepare("select username from users where user_id=?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($username);
            $stmt->fetch();
            ?>
            <div class="forumPosts">
                <h3><?php echo $title; ?></h3>
                <p><b>Creator:</b> <?php echo $username; ?></p>
                <p><b>Time uploaded:</b> <?php echo $date; ?></p>
                <p><b>Category:</b> <?php echo $category; ?></p>
                <div class="forumPosts">
                    <p><?php echo $content; ?></p>
                </div>
            </div>
            <?php
        }
    }
?>