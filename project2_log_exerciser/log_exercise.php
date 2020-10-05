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

        if (isset($_POST['submit'])) 
        {
            // Prepare user's data and process them
            $user_id = $_SESSION['user_id'];
            $type = mysqli_real_escape_string($dbc, trim($_POST['type']));
            $date = mysqli_real_escape_string($dbc, trim($_POST['date']));
            $time_in_minutes = (int)mysqli_real_escape_string($dbc, trim($_POST['time_in_minutes']));
            $heartrate = (int)mysqli_real_escape_string($dbc, trim($_POST['heartrate']));
            $calories = 0;
            $data =  mysqli_query($dbc,"SELECT gender, birthdate,"
                    . "weight FROM exercise_user WHERE user_id = '$user_id'")
                    or die("Query Error");

            $row = mysqli_fetch_array($data);          
            $gender = $row['gender'];
            $age = $row['birthdate'];
            $age = (int)(preg_replace('/.+\//',"",$age));
            $age = date('Y') - $age;
            //echo $age;
            $weight = (int)$row['weight'];
            

            // Calculate the calories 
            if ($gender == NULL || $age == NULL ||$weight == NULL)
            {
                echo "<span class='warn'>To calculate your calories you must specify:"
                        ."\n your gender AND you birhdate. Please "
                        . "<a href='editprofile.php'>edit</a> your profile and try again!</span>\n";
            }
            else 
            {           
                if (!empty($type && !empty($date) && !empty($time_in_minutes) && !empty($heartrate))) 
                {
                    //store record in DB
                    if(is_numeric($time_in_minutes) && is_numeric($heartrate))
                    {
                        if ($gender == 'M')
                        {
                            $calories = ((-55.0969 + (0.6309 * $heartrate) + (0.090174 * $weight) 
                                    + (0.2017 * $age)) / 4.184) * $time_in_minutes;
                        } 
                        else if ($gender == 'F')
                        {
                            $calories = ((-20.4022 + (0.4472 * $heartrate) - (0.057288 * $weight)
                                    + (0.074 * $age)) / 4.184) * $time_in_minutes;
                        }

                        $query = "INSERT INTO exercise_log(user_id,date,type,time_in_minutes,heartrate,"
                                . "calories) VALUES('$user_id', '$date', '$type', '$time_in_minutes', '$heartrate', $calories);";

                        mysqli_query($dbc, $query) or die("err qur");
                        
                        // Confirm success with the user
                        echo '<p>Your profile has been successfully updated. Would you like to '
                                . '"<a href="viewprofile.php">view your profile</a>?</p>';
                        
                        mysqli_close($dbc);
                        exit();
                        
                    } 
                    else
                    {
                        echo "You must enter numbers in Heartrate/Time in Minutes and enter a date in such manner yyyy-mm-dd";
                    }
                }
                else 
                {
                    echo '<p >You must enter all fields.</p>';
                }
            }
            
        } 
        
?>

  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
    <fieldset>
      <legend>Personal Information</legend>
      <label for="type">type:</label>
      <select id="type" name="type">
        <option value="running" >Running</option>
        <option value="walking" >Walking</option>
        <option value="swimming" >Swimming</option>
        <option value="weightlifting" >Weightlifting</option>
        <option value="yoga" >Yoga</option>
        <option value="other" >Other</option>

    </select><br />

      <label for="date">Date: </label>
      <input type="date" id="date" name="date" value="<?php if (!empty($date)) echo $date; else echo 'YYYY-MM-DD'; ?>" /><br />
      
      <label for="time_in_minutes">Time (in minutes):</label>
      <input type="text" id="time_in_minutes" name="time_in_minutes" value="<?php if (!empty($time_in_minutes)) echo $time_in_minutes; ?>" /><br />

      <label for="heartrate">heartrate:</label>
      <input type="text" id="heartrate" name="heartrate" value="<?php if (!empty($heartrate)) echo $heartrate; ?>" /><br />
      <input type="submit" value="Submit" name="submit" />

    </fieldset>
  </form>
  <?php 
     require_once('footer.php');  
  ?>
</body> 
</html>
