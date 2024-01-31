<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo base_url() . 'assets_login/' ?>images/logo-cb.png" />
  <title>Koperasi CB</title>

  <!-- Bootstrap -->
  <link href="<?php echo base_url('gentelella/') ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url('gentelella/') ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="<?php echo base_url('gentelella/') ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- bootstrap-progressbar -->
  <link href="<?php echo base_url('gentelella/') ?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- jVectorMap -->
  <link href="<?php echo base_url('gentelella/production/') ?>css/maps/jquery-jvectormap-2.0.3.css" rel="stylesheet" />

  <!-- Custom Theme Style -->
  <link href="<?php echo base_url('gentelella/') ?>build/css/custom.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="<?php echo base_url('gentelella/') ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet"><!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link href="<?php echo base_url() . 'gentelella/' ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

</head>

<!-- jQuery -->
<script src="<?php echo base_url('gentelella/') ?>vendors/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() . 'gentelella/' ?>plugins/moneymask/autoNumeric.js" type="text/javascript"></script>

<script src="<?php echo base_url() . 'gentelella/vendors/datatables.net/js/jquery.dataTables.min.js' ?>"></script>
<script src="<?php echo base_url() . 'gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js' ?>"></script><!-- datepicker -->
<script src="<?php echo base_url() ?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/ckeditor_basic/ckeditor.js"></script> -->
<script src="<?php echo base_url() ?>assets/ckeditor/ckeditor.js"></script>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
  // $(document).ready(function(){


  // });
</script>
<?php $level = $this->session->fk_cb_level_id; ?>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a class="site_title"><i class="fa fa-book"></i> <span>Koperasi</span></a>
          </div>
          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile">
            <div class="profile_pic">
              <img src="<?php echo base_url() . 'assets_login/' ?>images/logo-cb.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Selamat Datang,</span>
              <h2><?php echo $_SESSION['nama_lengkap']; ?> <?= !empty($this->session->nama_cabang) ? '<br>(' . $this->session->nama_cabang . ')' : '' ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>&nbsp;</h3>
              <ul class="nav side-menu">
                <li class="<?php if (isset($beranda)) {
                              echo 'active';
                            } ?>"><a href="<?php echo base_url('Homeadmin') ?>"><i class="fa fa-home"></i> Beranda</a>
                </li>
                <?php if ($level == 1) { ?>
                  <li><a><i class="fa fa-book"></i> Master <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li class="<?php if (isset($MscbAnggota)) {
                                    echo 'active';
                                  } ?>"><a href="<?php echo base_url('MscbAnggota') ?>">Anggota</a></li>
                      <li class="<?php if (isset($MscbSkpd)) {
                                    echo 'active';
                                  } ?>"><a href="<?php echo base_url('MscbSkpd') ?>">SKPD</a></li>
                      <li class="<?php if (isset($MscbUsersistem)) {
                                    echo 'active';
                                  } ?>"><a href="<?php echo base_url('MscbUsersistem') ?>">User</a></li>
                    </ul>
                  </li>
                <?php } else { ?>
                  <li><a><i class="fa fa-book"></i> Master <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li class="<?php if (isset($MsPelanggan)) {
                                    echo 'active';
                                  } ?>"><a href="<?php echo base_url('MsPelanggan') ?>">Pelanggan</a></li>
                      <li class="<?php if (isset($MsTerapis)) {
                                    echo 'active';
                                  } ?>"><a href="<?php echo base_url('MsTerapis') ?>">Terapis</a></li>
                    </ul>
                  </li>
                <?php } ?>
                <!-- <li><a><i class="fa fa-edit"></i> Entri Data <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li class="<?php if (isset($Pos)) {
                                    echo 'active';
                                  } ?>"><a href="<?php echo base_url('Pos') ?>">Point Of Sale</a></li>
                    </ul>
                  </li> -->

                <?php if ($level == 1) { ?>
                  <li><a><i class="fa fa-edit"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li class="<?php if (isset($Tagihan)) {
                                    echo 'active';
                                  } ?>"><a href="<?php echo base_url('Tagihan') ?>">Tagihan</a></li>
                      <li class="<?php if (isset($Pinjaman)) {
                                    echo 'active';
                                  } ?>"><a href="<?php echo base_url('Pinjaman') ?>">Pinjaman</a></li>
                    </ul>
                  </li>
                <?php } ?>

                <?php if ($level == 1) { ?>
                  <li><a><i class="fa fa-bar-chart"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li class="<?php if (isset($lapTransaksi)) {
                                    echo 'active';
                                  } ?>"><a href="<?php echo base_url('Laporan') ?>">Lap Transaksi</a></li>
                    </ul>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <!-- <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div> -->

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <!--  <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div> -->
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="<?php echo base_url('gentelella/') ?>production/images/avatar5.png" alt=""><?php echo $_SESSION['nama_lengkap']; ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="<?php echo base_url('MscbUsersistem/ubahPswd') ?>"> Ubah Password</a></li>
                  <li><a href="<?php echo base_url('Loginadmin/logout') ?>"><i class="fa fa-sign-out pull-right"></i> Keluar</a></li>
                </ul>
              </li>

              <!-- <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url('gentelella/') ?>production/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url('gentelella/') ?>production/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url('gentelella/') ?>production/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li> -->
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <?php echo $contents; ?>
      </div>
      <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="glyphicon glyphicon-chevron-up"></i></button>
      <br>
      <!-- /page content -->

      <!-- footer content -->
      <!-- <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer> -->
      <!-- /footer content -->
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/nprogress/nprogress.js"></script>
  <!-- Chart.js -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/Chart.js/dist/Chart.min.js"></script>
  <!-- jQuery Sparklines -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- morris.js -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/raphael/raphael.min.js"></script>
  <script src="<?php echo base_url('gentelella/') ?>vendors/morris.js/morris.min.js"></script>
  <!-- gauge.js -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/bernii/gauge.js/dist/gauge.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/iCheck/icheck.min.js"></script>
  <!-- Skycons -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/skycons/skycons.js"></script>
  <!-- Flot -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/Flot/jquery.flot.js"></script>
  <script src="<?php echo base_url('gentelella/') ?>vendors/Flot/jquery.flot.pie.js"></script>
  <script src="<?php echo base_url('gentelella/') ?>vendors/Flot/jquery.flot.time.js"></script>
  <script src="<?php echo base_url('gentelella/') ?>vendors/Flot/jquery.flot.stack.js"></script>
  <script src="<?php echo base_url('gentelella/') ?>vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="<?php echo base_url('gentelella/') ?>production/js/flot/jquery.flot.orderBars.js"></script>
  <script src="<?php echo base_url('gentelella/') ?>production/js/flot/date.js"></script>
  <script src="<?php echo base_url('gentelella/') ?>production/js/flot/jquery.flot.spline.js"></script>
  <script src="<?php echo base_url('gentelella/') ?>production/js/flot/curvedLines.js"></script>
  <!-- jVectorMap -->
  <script src="<?php echo base_url('gentelella/') ?>production/js/maps/jquery-jvectormap-2.0.3.min.js"></script>
  <!-- bootstrap-daterangepicker -->
  <!-- <script src="<?php echo base_url('gentelella/') ?>production/js/moment/moment.min.js"></script> -->
  <!-- <script src="<?php echo base_url('gentelella/') ?>production/js/datepicker/daterangepicker.js"></script> -->

  <!-- Select2 -->
  <script src="<?php echo base_url('gentelella/') ?>vendors/select2/dist/js/select2.full.min.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="<?php echo base_url('gentelella/') ?>build/js/custom.min.js"></script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

</body>
<style>
  .nominal {
    text-align: right;
  }

  .judul {
    height: 40px;
    border: 1px solid #CCC;
    width: 100%;
    text-align: center;
    border-radius: 5px;
    font-size: 14pt;
    color: #395fa5;
    background-color: #9bc9f9;
    padding: 6px;
    font-weight: bold;
    font-family: sans-serif;
  }

  .required .control-label:after {
    color: #d00;
    content: "*";
    position: absolute;
    margin-left: 5px;
    /*top:7px;*/
  }

  .dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    margin-left: -50%;
    margin-top: -25px;
    padding-top: 20px;
    text-align: center;
    font-size: 1.2em;
    color: grey;
  }

  #myBtn {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Fixed/sticky position */
    bottom: 20px;
    /* Place the button at the bottom of the page */
    right: 15px;
    /* Place the button 30px from the right */
    z-index: 99;
    /* Make sure it does not overlap */
    border: none;
    /* Remove borders */
    outline: none;
    /* Remove outline */
    background-color: #fecfbb;
    /* Set a background color */
    color: white;
    /* Text color */
    cursor: pointer;
    /* Add a mouse pointer on hover */
    padding: 12px;
    /* Some padding */
    border-radius: 100px;
    /* Rounded corners */
  }

  #myBtn:hover {
    background-color: #555;
    /* Add a dark-grey background on hover */
  }

  html {
    position: relative;
    min-height: 100%;
  }

  body {
    margin: 0 0 100px;
  }

  footer {
    position: absolute;
    left: 0;
    bottom: 0;
    height: 3%;
    width: 100%;
    background-color: #ede5da;
  }

  /*tes dropdown*/
  /* CSS used here will be applied after bootstrap.css */
  .dropdown-submenu {
    position: relative;
  }

  .dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
  }

  .dropdown-submenu:hover>.dropdown-menu {
    display: block;
  }

  .dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
  }

  .dropdown-submenu:hover>a:after {
    border-left-color: #fff;
  }

  .dropdown-submenu.pull-left {
    float: relative;
  }

  .dropdown-submenu.pull-left>.dropdown-menu {
    left: -80%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
  }
</style>

<script type="text/javascript">
  window.onscroll = function() {
    scrollFunction()
  };

  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      document.getElementById("myBtn").style.display = "block";
    } else {
      document.getElementById("myBtn").style.display = "none";
    }
  }
  // When the user clicks on the button, scroll to the top of the document
  function topFunction() {
    document.body.scrollTop = 0; // For Chrome, Safari and Opera
    document.documentElement.scrollTop = 0; // For IE and Firefox
  }

  $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
    return {
      "iStart": oSettings._iDisplayStart,
      "iEnd": oSettings.fnDisplayEnd(),
      "iLength": oSettings._iDisplayLength,
      "iTotal": oSettings.fnRecordsTotal(),
      "iFilteredTotal": oSettings.fnRecordsDisplay(),
      "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
      "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
    };
  };
  //$('.chosen').chosen({ allow_single_deselect: true });
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
      if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
  }

  $("select").select2({
    placeholder: ".:Pilih:.",
    allowClear: true
  });

  $(".tahun").datepicker({
    format: 'yyyy',
    viewMode: "years",
    minViewMode: "years",
    todayHighlight: 'true',
    autoclose: true,
  });
  $('.tanggal').datepicker({
    autoclose: true,
  });

  $(".blnThn").datepicker({
    format: 'mm-yyyy',
    viewMode: "months",
    minViewMode: "months",
    todayHighlight: 'true',
    autoclose: true,
  });

  $(".angka").keypress(function(data) {
    if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
      return false;
    }
  });

  $(".nominal").autoNumeric("init", {
    vMax: 9999999999999,
    vMin: -9999999999999
  });
  $(".dec").autoNumeric("init", {
    vMax: 9999999999999,
    vMin: -9999999999999,
    mDec: 2
  });
  $(".user_input").keyup(function() {
    $(this).val($(this).val().toUpperCase());
  });
  $.currToDouble = function(curr) {
    if (!curr) return 0;
    return Number(curr.replace(/[^0-9\.]+/g, ""));
  }
  $.doubleToCurr = function(input, sign) {
    if (sign == undefined) sign = "bracket";
    var number = input;
    if (input.toString().substring(0, 1) == "-") {
      number = parseFloat(input.toString().substring(1) * 1);
      if (sign == "bracket") {
        return "(" + (number.toFixed(2).replace(/./g, function(c, i, a) {
          return i && c !== "." && !((a.length - i) % 3) ? "," + c : c;
        })) + ")";
      } else if (sign == "minus") {
        return "-" + (number.toFixed(2).replace(/./g, function(c, i, a) {
          return i && c !== "." && !((a.length - i) % 3) ? "," + c : c;
        }));
      }
    }
    return (number.toFixed(2).replace(/./g, function(c, i, a) {
      return i && c !== "." && !((a.length - i) % 3) ? "," + c : c;
    }));
  }

  //entry huruf besar
  $(".upper").keyup(function(e) {
    var isi = $(e.target).val();
    $(e.target).val(isi.toUpperCase());
  });
</script>

</html>