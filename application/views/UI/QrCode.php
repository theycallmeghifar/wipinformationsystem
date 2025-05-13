<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WIP Information System FIM</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/adminlte3.2/dist/img/FIM_Logo_Circle.png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/other/all.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/other/adminlte.min.css') ?>">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <style>
        @page { size: auto;  margin: 0mm; }
    </style>

    <style>
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <section class="invoice">
            <div class="card-body">
                <div class="row">
                    <?php
                        foreach ($print as $m) {
                            $data = json_decode($m); // Konversi JSON ke objek PHP
                            if (is_array($data) || is_object($data)) {
                                foreach ($data as $d) { ?>
                                    <div class="col-3">
                                    </br>
                                        <img style="margin-bottom: 10px;" height="184" width="184" id="qrcode" 
                                            src="<?php 
                                                echo site_url('QrCodeCon/qrCodeCon/' . 
                                                    ($type == 'item' ? $d->itemCode : 
                                                        ($type == 'location' ? $d->locationId : $d->boxCode))
                                                ); 
                                            ?>" alt="">

                                        <h5 style="font-weight: bold; text-align: center;">
                                            <?php 
                                                if ($type == 'item') {
                                                    echo $d->itemCode;
                                                } elseif ($type == 'location') {
                                                    echo $d->area . ' ' . $d->line . ($d->number != 0 ? ' No.' . $d->number : '');
                                                } else {
                                                    echo $d->boxCode;
                                                }
                                            ?>
                                        </h5>
                                    </div>
                        <?php 
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>