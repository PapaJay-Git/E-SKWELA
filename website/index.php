<?php
require_once "../assets/db.php";
$checkClasses11 = "SELECT * FROM announcements ORDER BY announcement_id DESC";
$result = $conn->query($checkClasses11);
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
 ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="images/logo1.png">

    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Smooth Scroll -->
    <script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="https://kit.fontawesome.com/59e6c1e97d.js" crossorigin="anonymous"></script>

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css2/style.css">
    <style type="text/css">
      @media (max-width: 505px) {
                  .logo{
                    width: 250px;
                    height: 80px;
                  }}
      @media (max-height: 505px) {
                  .logo{
                    width: 250px;
                    height: 80px;
                  }}

    </style>

    <title>Sto. Cristo Integrated School</title>
  </head>
  <body>

    <header role="banner">
        <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
          <div class="container">
            <a class="navbar-brand" href="index"><img class ="logo" src="images/Nav-logo.png" width="400px" height="120px"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample05">
              <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
                <li class="nav-item">
                  <a class="nav-link navs active" href="index">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link navs" href="facilities">Facilities</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link navs" href="about">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link navs" href="contact">Contact Us</a>
                </li>
              </ul>

              <ul class="navbar-nav ml-auto">
                <li class="nav-item cta-btn">
                  <a class="nav-link" href="../login/index.php">E-Skwela</a>
                </li>
              </ul>

            </div>
          </div>
        </nav>

    </header>
    <!-- END header -->

    <!-- Background image -->
      <div class="hero pt-4 text-center bg-image"style="background: url(images/banner.jpeg),linear-gradient(rgba(0,0,0,0.8),rgba(0,0,0,0.8));">
        <div class="d-flex justify-content-center align-items-center h-100 pt-5">
          <div class="container">
            <div class="text-center text-white py-5">
              <h1 class="display-5 font-weight-bold ">STO. CRISTO INTEGRATED SCHOOL</h1>
              <h2 class="font-weight-bold ">Junior High Department</h2>
              <p class="lead mb-0">Intelligence plus character that is the goal of true education.</p>
              <div class="btn-group mt-5" role="group" aria-label="Basic example">
                <a type="button" class="btn btn-outline-light btn-lg" title="Pandemic Setup" data-scroll href="#pandemic"><i class="fas fa-shield-virus fa-lg
               "></i></a>
                <a type="button" class="btn btn-outline-light btn-lg" title="Anouncement"data-scroll href="#announcements"><i class="fas fa-bullhorn fa-lg"></i></a>
                <a type="button" class="btn btn-outline-light btn-lg" title="What We Offer"data-scroll href="#offer"><i class="fab fa-buffer fa-lg"></i></a>
                <a type="button" class="btn btn-outline-light btn-lg" title="Teacher"data-scroll href="#teacher"><i class="fas fa-chalkboard-teacher fa-lg"></i></a>
              </div>
            </div>
          </div>
        </div>
    </div>
   <!-- Background image-->

    <div id="pandemic" class="pandemic_setup pb-5" style=" background-color: #F4F6F6; border-bottom: 1px solid #D8D8D8;">
        <div class="container">
          <div class="text-black py-5">
            <h1 class="display-5 font-weight-bold mb-5 text-center" style="line-height: 30px;
  margin: 40px auto 25px;padding-bottom: 50px;"><span style="border-bottom: 5px solid #007bff;
  padding-bottom: 10px;">Pandemic Setup</span></h1>

            <div class="row">

              <div class="col-md-4 mb-3">
                <div class="card shadow bg-white rounded">
                  <center><a href="images/setup6.jpeg" data-toggle="modal" data-target=".setup6"><img class="img-fluid al" src="images/setup6.jpeg" width="100%" height="100%"></a></center>

                  <div class="card-body">
                    <p class="card-text text-center" style="color: black;">Releasing of modules</p>
                  </div>
                </div>
              </div>

              <div class="modal fade setup6" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md py-5">
                  <div class="modal-content">
                    <img class="rounded" src="images/setup6.jpeg" width="100%" height="100%">
                  </div>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <div class="card shadow bg-white rounded">
                  <center><a href="images/setup5.jpeg" data-toggle="modal" data-target=".setup5"><img class="img-fluid al" src="images/setup5.jpeg" width="100%" height="100%"></a></center>

                  <div class="card-body">
                    <p class="card-text text-center" style="color: black;">Collecting of modules</p>
                  </div>
                </div>
              </div>

              <div class="modal fade setup5" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md py-5">
                  <div class="modal-content">
                    <img class="rounded" src="images/setup5.jpeg" width="100%" height="100%">
                  </div>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <div class="card shadow bg-white rounded">
                  <center><a href="images/setup4.jpeg" data-toggle="modal" data-target=".setup4"><img class="img-fluid al" src="images/setup4.jpeg" width="100%" height="100%"></a></center>

                  <div class="card-body">
                    <p class="card-text text-center" style="color: black;">Issuance of Cards</p>
                  </div>
                </div>
              </div>

              <div class="modal fade setup4" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md py-5">
                  <div class="modal-content">
                    <img class="rounded" src="images/setup4.jpeg" width="100%" height="100%">
                  </div>
                </div>
              </div>

            </div>

        </div>
      </div>
    </div>

    <div id="announcements" class="announcements pb-5" style="border-bottom: 1px solid #D8D8D8;">
      <div class="container">
        <div class="text-black py-5">
          <h1 class="display-5 font-weight-bold mb-5 text-center" style="line-height: 30px;
  margin: 40px auto 25px;padding-bottom: 50px;"><span style="border-bottom: 5px solid #007bff;
  padding-bottom: 10px;">Announcement</span></h1>

          <div class="row">
            <?php
            $counter = 0;
            while ($count = mysqli_fetch_assoc($result)) {
              if ($count['deadline'] >= $date) {
                $counter += 1;
              }
            }
            if ($counter < 1) {
              ?>
             <div class="col-md-12 mb-3">
               <div class="card shadow bg-white rounded">
                 <center><h1 class="display-5 font-weight-bold text-center text-black p-5">No Announcement for today</h1></center>
               </div>
             </div>
              <?php
            }
            $result->data_seek(0);
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
                    <h5 class="card-title display-5 font-weight-bold text-black"><?php echo $ann['title']; ?></h5>
                    <p class="card-text" style="color:black;"><?php echo $ann['texts']; ?></p>
                    </div>
                  </div>



                  <div class="card-footer">
                    <small class="text-muted">Admin: <?php echo $admin_name; ?></small>
                    <small class="text-muted" style="float:right; padding-top:3px;"><?php echo strtoupper($month)." ".$day; ?></small>
                  </div>
              </div>
            </div>
            <?php
                }
              } ?>
          </div>
        </div>
      </div>
    </div>


    <div id="offer" class="offer pb-5" style="background-color: #1C1C1C; border-bottom: 1px solid #D8D8D8;">
        <div class="container">
          <div class="text-center text-black py-5">
            <h1 class="display-5 font-weight-bold mb-5 text-center text-white" style="line-height: 30px;
  margin: 40px auto 25px;padding-bottom: 50px;"><span style="border-bottom: 5px solid #007bff;
  padding-bottom: 10px;">What We Offer</span></h1>

          <div class="row">

            <div class="col-md-4 mb-3">
              <div class="card shadow bg-white rounded">
                <center><img class="img-fluid al" src="images/good_values.png" width="60px" height="60px" style="margin-top:20px;"></center>

                <div class="card-body">
                  <h4 class="card-title display-5 font-weight-bold text-black">Good Values</h4>
                  <p class="card-text text-center" style="color: black;">SCIS forms its students with good moral values.</p>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="card shadow bg-white rounded">
                <center><img class="img-fluid" src="images/quality_education.png" width="60px" height="60px" style="margin-top:20px;"></center>

                <div class="card-body">
                  <h4 class="card-title display-5 font-weight-bold text-black">Quality Education</h4>
                  <p class="card-text text-center" style="color: black;">SCIS delivers quality education with its students.</p>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="card shadow bg-white rounded">
                <center><img class="img-fluid" src="images/faculty.png" width="60px" height="60px" style="margin-top:20px;"></center>

                <div class="card-body">
                  <h4 class="card-title display-5 font-weight-bold text-black">Competent Faculty</h4>
                  <p class="card-text text-center" style="color: black;">SCIS DCT provides qualified and competent faculty.</p>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="card shadow bg-white rounded">
                <center><img class="img-fluid" src="images/facilities.png" width="60px" height="60px" style="margin-top:20px;"></center>

                <div class="card-body">
                  <h4 class="card-title display-5 font-weight-bold text-black">Competitive Facilities</h4>
                  <p class="card-text text-center" style="color: black;">SCIS offers competitive facilities in the region.</p>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="card shadow bg-white rounded">
                <center><img class="img-fluid" src="images/schedule.png" width="60px" height="60px" style="margin-top:20px;"></center>

                <div class="card-body">
                  <h4 class="card-title display-5 font-weight-bold text-black">Convenient Schedule</h4>
                  <p class="card-text text-center" style="color: black;">Class schedule in SCIS is <br> convenient.</p>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="card shadow bg-white rounded">
                <center><img class="img-fluid" src="images/location.png" width="60px" height="60px" style="margin-top:20px;"></center>

                <div class="card-body">
                  <h4 class="card-title display-5 font-weight-bold text-black">Accessible Location</h4>
                  <p class="card-text text-center " style="color: black;">The location of SCIS is more <br> braccessible.</p>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>

    <div id="teacher" class="teacher pb-5" style="border-bottom: 1px solid #D8D8D8;">
      <div class="container">
        <div class="text-black py-5">
          <h1 class="display-5 font-weight-bold mb-5 text-center" style="line-height: 30px;
  margin: 40px auto 25px;padding-bottom: 50px;"><span style="border-bottom: 5px solid #007bff;
  padding-bottom: 10px;">Teachers</span></h1>

          <div class="list shadow bg-white rounded">
            <div class="container p-5">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active display-5 font-weight-bold" href="#grade7" role="tab" data-toggle="tab">Grade 7</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link display-5 font-weight-bold" href="#grade8" role="tab" data-toggle="tab">Grade 8</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link display-5 font-weight-bold" href="#grade9" role="tab" data-toggle="tab">Grade 9</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link display-5 font-weight-bold" href="#grade10" role="tab" data-toggle="tab">Grade 10</a>
                </li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="grade7">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Position</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>BELINDA L. MANGLICMOT</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>CARLOS JAVIER</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>CYNDY B. TEJERO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>DONNA A. CASTAÑEDA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>EDWARD C. MENESES</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>GLENDA I. QUELO</td>
                        <td>Teacher II</td>
                      </tr>
                      <tr>
                        <td>JEYSEPMAR M. CASTRO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JOANNA MARIE M. DELA CRUZ</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JONALYN F. EVORA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JOYCE ANN E. CURA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>KATRINA G.  GARCIA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>LOWELLA M. PARAISO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>LUDY D. GUEVARRA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>MARIA RUSSEL A. DAMASCO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>MARIA TERESA E. YUGA</td>
                        <td>Teacher II</td>
                      </tr>
                      <tr>
                        <td>MARIA VICTORIA P. TORRES</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>MICHELLE MAHINAY</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>NELISA GRACE B. CAPIAN</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>PAUL MARION R. VALLENTOS</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>RANIA M. ESPINOSA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>ROCHELLE G. PANGAN/ SANSANA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>STRAWBERRY M. SANTIAGO</td>
                        <td>Teacher I</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="grade8">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Position</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>ARDYN PAUL S. GALLEON</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>CAMILLE JOY I. CASTROJERES</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>CELESTE D. MANALO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>CHONA M. REYES</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>ELAINE D. PARAS</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>ESMER C. AROSAL</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>HAZEL B. NUNAG</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JOY AN D. ARAFILES</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>KAREN LOU C. DAVID</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>LESLIE ANN E. EMPERADOR</td>
                        <td>Teacher III</td>
                      </tr>
                      <tr>
                        <td>MARJORIE B. GAMIT</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>MARK M. AQUINO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>MICHAEL B. PABALAN</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>MICHELLE B. TIMBOL</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>REA R. GARCIA</td>
                        <td>Teacher III</td>
                      </tr>
                      <tr>
                        <td>REX F. SALCEDO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>ROSE ANNE B. CACAP</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>ROSE ANNE MARY M. BUGAYONG</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>VILLARICO, JAY MARK V.</td>
                        <td>Teacher I</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="grade9">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Position</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>GRACE M. QUIJANO</td>
                        <td>Teacher III</td>
                      </tr>
                      <tr>
                        <td>JAY JAY P. GALULU</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JOLINA G. TACUTACU</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JONAS G. TOLENTINO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JOVENCIO R. DELA CRUZ JR.</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JUNA MARIA LUZ G. CASTRO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>KRISTINE B. PUNO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>MARGARITA A. SANTOS</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>MARITES S. GAMBOA</td>
                        <td>Teacher III</td>
                      </tr>
                      <tr>
                        <td>MARJORIE D. SAMONTE</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>MYRELLE E. BENDANILLO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>RALPH ANTHONY S. GONZALES</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>RENZIE O. BRUNO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>RHEYMHAR B. PANGILINAN</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>ROCHELL S. PERIA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>THELMA C. TABIOS</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>WARREN JADE M. SANTOS</td>
                        <td>Teacher I</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="grade10">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Position</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>APRIL JOY F. ZARATE</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>CYPRUS CHAD G. LAUS</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>ELSIE C. MIRANDA</td>
                        <td>Teacher III</td>
                      </tr>
                      <tr>
                        <td>HARRY GERARD A. TIMBOL</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JOEANN M. CASTRO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JOMER B. ALMOZARA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JOSEPH SAMSON G. CHUA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>JUNE T. MICLAT</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>KAREN D. ARREZA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>LENYBETH M. MARCELO</td>
                        <td>Teacher III</td>
                      </tr>
                      <tr>
                        <td>LOUWELLA FATIMA N. CORPUZ</td>
                        <td>Teacher III</td>
                      </tr>
                      <tr>
                        <td>MARIVIC N. BALMES</td>
                        <td>Teacher III</td>
                      </tr>
                      <tr>
                        <td>MICHA ROSE D. QUINEZ</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>RAMIL J. MERCULIO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>RUBY MAY R. GUEVARA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>SARAH G. ARCELLANA</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>SHEENA GWENDOLYN D. VALDEZ</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>SHIRLEY I. DOMINGO</td>
                        <td>Teacher III</td>
                      </tr>
                      <tr>
                        <td>SOLIMAR G. ABALORIO</td>
                        <td>Teacher I</td>
                      </tr>
                      <tr>
                        <td>TESALONICA G. DAVID</td>
                        <td>Teacher I</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <footer class="footer-07">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12 text-center">
            <img src="images/logo1.png" width="100px" height="100px">
            <h2 class="footer-heading"><a href="#" class="logo">Sto. Cristo Integrated School</a></h2>
            <p class="menu">
              <a href="index.php">Home</a>
              <a href="facilities.html">Facilities</a>
              <a href="about.html">About</a>
              <a href="contact.html">Contact</a>
            </p>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-md-12 text-center">
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Sto. Crsito Integrated School

          </div>
        </div>
      </div>
    </footer>

    <script type="text/javascript">
      var scroll = new SmoothScroll('a[href*="#"]');
    </script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>

  </body>
</html>
