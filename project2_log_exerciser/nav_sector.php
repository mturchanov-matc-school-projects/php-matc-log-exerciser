<header>
    <div id="headerHeader">
        <h1>Exercises Logger&reg;</h1>
        <p id="fancyFont">Record and become healthier</p>
</div>
<div id="navStuff">
    <nav>
        
        &bull;&nbsp;<a href="index.php"><span class="active">Home</span></a>&nbsp;
            <?php if (isset($_SESSION['username'])) {?>
            
             &bull;&nbsp;<a href="log_exercise.php">Log Exercise</a>&nbsp;
             &bull;&nbsp;<a href="viewprofile.php">View Profile</a>&nbsp;
             &bull;&nbsp;<a href="editprofile.php">Edit Profile</a>&nbsp;
             &bull;&nbsp;<a href="logout.php">Log Out</a></li>
            <?php } else { ?>
             &bull;&nbsp;<a href="signup.php">Sign up</a>&nbsp;
             &bull;&nbsp;<a href="login.php">Log In</a>&nbsp;
            <?php } ?>
        
    </nav>
</div>
</header>
<main>
