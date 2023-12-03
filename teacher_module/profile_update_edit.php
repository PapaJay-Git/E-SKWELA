
<?php
  require_once 'includes_profile_id_check.php';

if(isset($_POST['edit_profile'])) {
    $about = htmlspecialchars($_POST['about']);
    $bday = htmlspecialchars($_POST['bday']);
    $address = htmlspecialchars($_POST['address']);
    $gender = htmlspecialchars($_POST['gender']);
    $id = $row['teacher_id'];
    $add_ass = "UPDATE teachers SET about=?, t_adress=?, birthday=?, gender=? WHERE teacher_id=?";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $add_ass)) {
       $_SESSION['error'] = "SQL error";
       echo "Failed to connect to MySQL: " . $conn -> error;
       header("Location:  profile_edit.php?sql=error");
      exit();
    } else {
      //run sql
          mysqli_stmt_bind_param($stmt, "ssssi", $about, $address, $bday, $gender, $id);
          if(mysqli_stmt_execute($stmt)){
            $resultid = mysqli_stmt_get_result($stmt);
            $conn->close();
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: profile_edit.php?success");
            exit();
          }else{
            $conn->close();
            $_SESSION['error'] = "Profile update failed!";
            header("Location: profile_edit.php?error");
            exit();
          }

      }
  }else{
    $_SESSION['error'] = "Submit button is not settled properly.";
    header("Location: profile_edit.php?NotSubmit");
  }
