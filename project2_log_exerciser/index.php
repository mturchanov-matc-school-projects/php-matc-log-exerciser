<?php
    require_once('start_session.php');
    //for flexible templates
    $page_title = "Home";
    $current_file = basename($_SERVER['PHP_SELF'],'.php');
    require_once('header.php');
    require_once('nav_sector.php');
    require_once('appvars.php');
    require_once('connectvars.php');

    // Connect to the database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
    // Retrieve the user data from MySQL
    $query = "SELECT user_id, first_name, picture FROM exercise_user WHERE first_name IS NOT NULL ORDER BY user_id DESC LIMIT 5";

    $data = mysqli_query($dbc, $query);

    // Loop through the array of user data, and provide the fresh members
    echo '<h2>Latest members:</h2><div id="profiles">';
    echo '<table>';
    while ($row = mysqli_fetch_array($data)) 
    {
        if (is_file(MM_UPLOADPATH . $row['picture']) 
            && filesize(MM_UPLOADPATH . $row['picture']) > 0)
        {
            echo '<tr><td><img src="' . MM_UPLOADPATH . $row['picture'] 
                . '" alt="' . $row['first_name'] . '" /></td>';
        }
        else 
        {
            echo '<tr><td><img src="' . MM_UPLOADPATH . 'nopic.jpg' . '" alt="' 
                . $row['first_name'] . '" /></td>';
        }

        if (isset($_SESSION['user_id'])) 
        {
            echo '<td><a href="viewprofile.php?user_id=' . $row['user_id'] 
                . '">' . $row['first_name'] . '</a></td></tr>';
        }
        else 
        {
            echo '<td>' . $row['first_name'] . '</td></tr>';
        }
    }
    echo '</table></div>';

    mysqli_close($dbc);
    require_once('footer.php');
?>

</body> 
</html>
