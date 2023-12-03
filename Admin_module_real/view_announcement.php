
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $id = $_GET['id'];
  $sql = "SELECT * FROM announcements where announcement_id =?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {

    } else {
      $_SESSION['error'] = "It looks like this announcement is already been deleted!";
        header("location: index.php?view=failed");
        exit();
    }
?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">ANNOUNCEMENT</h2>
  <hr size="4" width="100%" color="grey">

                                <?php
                                while ($ann = mysqli_fetch_assoc($result)) {
                                  $timestamp2 = strtotime($ann['upload']); $day = date("j", $timestamp2);
                                  $timestamp3 = strtotime($ann['upload']); $month = date("M", $timestamp3);
                                  if ($ann['deadline'] >= $date) {
                                    $admin_id = $ann['admin_id'];
                                    $checkClasses11 = "SELECT l_name, f_name FROM admin WHERE admin_id = $admin_id;";
                                    $admin_result = $conn->query($checkClasses11);
                                    $admin_result05 = mysqli_fetch_assoc($admin_result);
                                    $admin_name = $admin_result05['f_name']." ".$admin_result05['l_name'];
                                   ?>
                                  <div class="col-md-12 mb-3">
                                  <div class="card shadow bg-white rounded">
                                    <div class="card-horizontal" style="display: flex; flex: 1 1 auto;">
                                      <div class="card-body">
                                        <small class="text-muted" style="float:right; padding-top:3px;"><?php echo strtoupper($month)." ".$day; ?></small>
                                        <h4 class="card-title display-8 font-weight-bold text-black"><?php echo $ann['title']; ?></h4>
                                        <p class="card-text" style="color:black;font-weight:normal"><?php echo $ann['texts']; ?></p>
                                        </div>
                                      </div>

                                      <div class="card-footer">
                                        <small class="text-muted" style="font-weight:normal">Admin: <?php echo $admin_name; ?></small>
                                          <a style="float:right;" href="index.php"class="btn btn-primary" >BACK</a>
                                      </div>
                                  </div>
                                </div>
                                <?php
                                    }
                                  } ?>
</div>

<?php
  require_once 'includes_footer.php';
