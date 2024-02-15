<!doctype html>
<html lang="en">

<head>
    <title>KPRI. CANDA BHIRAWA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" href="<?php echo base_url() . 'assets_login/' ?>images/logo-cb.png" />

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo base_url() . 'assets_login_admin/' ?>css/style.css">

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Login KPRI. CANDA BHIRAWA</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">

                        <img class="img" src="<?php echo base_url() . 'assets_login_admin/' ?>images/bg-2.jpg" alt="">

                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Sign In</h3>
                                </div>
                                <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                                        <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-youtube"></span></a>
                                    </p>
                                </div>
                            </div>
                            <?php if ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-warning">
                                    <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                                </div>
                            <?php else : ?>
                                <!-- <div class="alert alert-success">
                                Masukkan Username dan Password.s
                                </div> -->
                            <?php endif; ?>
                            <form action="<?= base_url() ?>Loginadmin/prosesLogin" class="signin-form" method="post">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Username</label>
                                    <input type="text" class="form-control" placeholder="Username" name="username" id="username" value="<?= $username ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign
                                        In</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <!-- <div class="w-50 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                            <input type="checkbox" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div> -->
                                    <!-- <div class="w-50 text-md-right">
                                        <a href="#">Forgot Password</a>
                                    </div> -->
                                </div>
                            </form>
                            <!-- <p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?php echo base_url() . 'assets_login_admin/' ?>js/jquery.min.js"></script>
    <script src="<?php echo base_url() . 'assets_login_admin/' ?>js/popper.js"></script>
    <script src="<?php echo base_url() . 'assets_login_admin/' ?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() . 'assets_login_admin/' ?>js/main.js"></script>

</body>

</html>