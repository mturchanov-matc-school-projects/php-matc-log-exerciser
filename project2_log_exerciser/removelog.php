<?php
    require_once('start_session.php');
    //for flexible templates
    $page_title = "Remove Log";
    $current_file = basename($_SERVER['PHP_SELF'],'.php');
    require_once('header.php');
    require_once('nav_sector.php');
    require_once('appvars.php');
    require_once('connectvars.php');
    
    if (isset($_GET['id'])) 
    {
        // Grab the user's id from the GET(process input from veiwprofile.php)
        $id = $_GET['id'];   
    }
    else if (isset($_POST['id'])) 
    {
        // Grab the user's id from the POST(this page)
        $id = $_POST['id'];
    }
    else 
    {
        echo '<p class="error">Sorry, no high score was specified for removal.</p>';
    }

    //deleting a log log
    if (isset($_POST['submit'])) 
    {
        if ($_POST['confirm'] == 'Yes') 
        {            
            // Connect to the database
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
            
            // Delete the log from the database
            $query = "DELETE FROM exercise_log WHERE id = $id LIMIT 1";
            mysqli_query($dbc, $query) or die("error query");
            mysqli_close($dbc);
            
            // Confirm success with the user
            echo '<p>The training entry was successfully removed.';
        }
        else 
        {
            echo '<p>The high score was not removed.</p>';
        }
    }
    else if (isset($id)) 
    {
        ?>
        <p>Are you sure you want to delete the following high score?</p>
        <form method="post" action="removelog.php">
        <div id="yes">
        <input type="radio" name="confirm" value="Yes" /> Yes 
    </div>
    <div id="no">
        <input type="radio" name="confirm" value="No" checked="checked" /> No <br />
    </div>
        <input type="submit" value="Submit" name="submit" />
        <input type="hidden" name="id" value="<?php echo $id ?>" />
        </form>
    
    <?php
    }
    echo '<p><a href="viewprofile.php">&lt;&lt; Back to a profile page</a></p>';
    require_once('footer.php');  


?>

</body> 
</html>
