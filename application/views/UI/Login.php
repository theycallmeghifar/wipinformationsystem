<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WIP Information System FIM</title>

        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/login/font-awesome.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/login/googleapis.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/login/style.css') ?>">

        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/adminlte3.2/dist/img/FIM_Logo_Circle.png">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/dist/js/jquery-ui.css">
    </head>
    <!-- //////////////////////////////////////// -->
    <body style="background-color:#383c44;">
        <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("flash") ?>"></div>
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="wrap d-md-flex">
                            <div class="img" style="background-image: url(assets/adminlte3.2/dist/img/FIM_Logo_Custom.png);height:260px;margin-top:90px; margin-left: 20px;">
                            </div>
                            <div class="login-wrap p-1 p-md-5">
                                <div class="d-flex">
                                    <div class="w-100">
                                        <h3 class="mb-3">Log In</h3>
                                    </div>
                                </div>                        
                                <div class="form-group mb-2">
                                    <label class="label" for="name">Username</label>
                                    <input id="username" type="text" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="label" for="password">Password</label>
                                    <input id="password" type="password" class="form-control" placeholder="Password" required>
                                </div>
                                <p id="msg" style="font-weight:bold;text-align:center" class="login-box-msg">Login terlebih dahulu</p>
                                <div class="form-group">
                                    <button type="submit" id="login" class="form-control btn btn-primary rounded submit px-3">Log In</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- //////////////////////////////////////// -->
        <!-- jQuery -->
        <script src="<?php echo base_url('assets/plugins/login/jquery.min.js')?>"></script>
        <script src="<?php echo base_url('assets/plugins/login/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('assets/plugins/login/main.js')?>"></script>
        <script src="<?php echo base_url('assets/plugins/login/popper.js')?>"></script>
        <script>
            $(document).ready(function() {

                var mod = document.getElementById("modal-menu");
                var txtMsg = document.getElementById("msg");

                $('#username').keyup(function(e) {
                    if (e.keyCode == '13') //Keycode for "Return"
                        $('#login').click();
                })

                $('#password').keyup(function(e) {
                    if (e.keyCode == '13') //Keycode for "Return"
                        $('#login').click();
                })

                $("#login").on("click", function(e) {
                    var username = document.getElementById("username").value;
                    var password = document.getElementById("password").value;

                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Login/getLogin') ?>",
                        data: {
                            username: username,
                            password: password
                        },
                        success: (function(data) {
                            var obj = jQuery.parseJSON(data);
                            if (obj.cek > 0) {
                                txtMsg.style.color = "green";
                                txtMsg.innerHTML = obj.msg;
                                if (obj.role == 1 || obj.role == 2) {
								    window.location.replace("<?php echo site_url('Order') ?>");
                                } else if (obj.role == 3) {
								    window.location.replace("<?php echo site_url('WipBox') ?>");
                                } 
                            } else {
                                txtMsg.style.color = "red";
                                txtMsg.innerHTML = obj.msg;
                            }
                        }),
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                const flashdata = $('.flash-data').data('flashdata');
                if (flashdata) {
                    Swal.fire({
                        title: 'Berhasil ' + flashdata,
                        text: '',
                        icon: 'success'
                    });
                }
            });
        </script>
    </body>
</html>