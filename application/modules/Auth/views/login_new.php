<!DOCTYPE html>
<html lang="en">

<head>
    <title>Koperasi CB</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="<?php echo base_url() . 'assets_login/' ?>images/logo-cb.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>css/util.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets_login/' ?>css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('<?php echo base_url() ?>assets_login/images/bg.jpg');">
            <div class="wrap-login100 p-t-30 p-b-50">
                <span class="login100-form-title p-b-41">
                    Account Login<br>Koperasi Chanda Bhirawa
                </span>
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-warning">
                        <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                    </div>
                <?php else : ?>
                    <!-- <div class="alert alert-success">
                      Masukkan Username dan Password.
                  </div> -->
                <?php endif; ?>
                <form class="login100-form validate-form p-b-33 p-t-5" action="<?= base_url() ?>Auth/prosesLogin" method="post">

                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="text" name="username" id="username" value="<?= $username ?>" placeholder="Username" autocomplete="off">
                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>

                </form>
                <p align="center" class="col-md-12" style="color: white"> Koperasi CB &copy;2024</p>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>
    <!--===============================================================================================-->
    <script src="<?php echo base_url() . 'assets_login/' ?>vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url() . 'assets_login/' ?>vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url() . 'assets_login/' ?>vendor/bootstrap/js/popper.js"></script>
    <script src="<?php echo base_url() . 'assets_login/' ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url() . 'assets_login/' ?>vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url() . 'assets_login/' ?>vendor/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url() . 'assets_login/' ?>vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url() . 'assets_login/' ?>vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url() . 'assets_login/' ?>js/main.js"></script>

</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        // $("#username").focus();
    });
</script>