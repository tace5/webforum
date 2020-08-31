<?php
    include("php/functions.php");
    include("php/db-connect.php");
    secure_session_start();

    $result = $mysql_con->query("select title, content, category_id, date, user_id from posts");
?>

<!DOCTYPE html>
<html lang= "sv">
    <head>
        <meta charset= "utf-8"/>
		<meta name= "viewport" content= "width=device-width, initial-scale=1">
	    <link rel= "stylesheet" href= "css/stilmall.css">
		<link rel= "stylesheet" href= "css/imgslider_css.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:700,300' rel='stylesheet' type='text/css'>
		<title>Teknik projekt</title>
    </head>
    <body>
        <div id= "wrapper"> <!-- Innehåll -->
            <header>
				<a href= "index.php">
					<h1>Forum</h1>
				</a>
            </header>
            <nav>
				<ul>
                    <a href="<?php if(is_logged_in()) {echo 'php/logout.php';} else {echo 'php/login.php';} ?>"><?php if(is_logged_in()) {echo 'Logout';} else {echo 'Login';} ?></a>
					<li id= "active">
						<a href= "index.php">Start</a>
					</li>
					<li>
						<a class= "unactive" href= "php/register.php">Register</a>
					</li>
					<li>
						<a class= "unactive" href= "php/mypages.php">Account</a>
					</li>
				</ul>
	        </nav>
			<section>
			    <article id= "index_article">
                    <a href="php/createpost.php"><p id="createpost">Create Post</p></a>              
                    <?php
                        show_posts($result, $mysql_con);
                    ?>                 
			    </article>
			</section>
			<footer>
			    <ul>
					<li>
						<a class= "ikoner" href= "https://twitter.com/rubenhume"><img src= "bilder/twitter.png"></a>
					</li>
					<li>
						<a class= "ikoner" href= "mailto: ruben.hume@live.se"><img src= "bilder/email.png"></a>
					</li>
					<li>
						<a class= "scrollToTop" href= "#"><img src= "bilder/pagetop.png"></a>
					</li>
				</ul>
				<div id= "copyright">
					<p>&copy; 2016 Ruben H. Hume</p>
				</div>
			</footer>
        </div>
		<script type= "text/javascript" src= "javascript/jquery.js"></script>
		<script type= "text/javascript" src= "javascript/jquery.slides.min.js"></script>
		<script type= "text/javascript" src= "javascript/jquery.slides_2.js"></script>
		<script type= "text/javascript" src= "javascript/scrolltotop.js"></script>
    </body>
</html>