<?php ob_start();?>
<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<div class="content-wrapper">
    <div class="content-header">
        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" aria-label="Close" onclick="closeAlert('alert-success')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-danger">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="close" aria-label="Close" onclick="closeAlert('alert-danger')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transfer Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Menu</a></li>
                        <li class="breadcrumb-item active">Transfer Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END HEADER -->
<!-- TABLE -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                            </div>
                            <button type="button" id="btnTambah" style="margin-top: 10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal">Transfer Barang</button>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" data-order='[[7, "asc"]]' class="display nowrap table-striped table" style="width:100%" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kode Box</th>
                                        <th>Tipe Item</th>
                                        <th>Jumlah</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        <th hidden="true">Int Status</th>
                                        <th hidden="true">Created Date</th>
                                        <th hidden="true">Modified Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($getData as $data){ ?>
                                    <tr>                             
                                        <td><?php echo $data->wipBoxId?></td>
                                        <td><?php echo $data->boxCode?></td>
                                        <td><?php echo $data->itemTypeCount?></td>
                                        <td><?php echo $data->totalQuantity?></td>
                                        <td>
                                            <?php foreach ($location as $row) {
                                                if ($data->locationId == $row->locationId) {
                                                    echo $row->location . " " . $row->line;
                                                }
                                            }
                                            if ($data->locationId == "0" ){
                                                echo "-";
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if ($data->status == 0) {
                                            echo "Pending";
                                            } else if ($data->status == 1) { 
                                                echo "Siap Produksi";
                                            } else if ($data->status == 2) { 
                                                echo "Dalam Produksi";
                                            } else {
                                                echo "Selesai";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="fa fa-tasks color-muted detailbtn" title="Detail Data" style="margin-left: 15px;"></a>
                                        </td>
                                        <td hidden="true"><?php echo $data->status?></td>
                                        <td hidden="true"><?php echo $data->createdDate?></td>
                                        <td hidden="true"><?php echo $data->modifiedDate?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <br/><br/><br/>
                    </div>
                </div>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END TABLE -->
<!-- MODAL -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- TAMBAH DATA -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form role="form" action="<?php echo site_url('Transfer/saveTransferCon')?>" method="post" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">
                                            Kode Box<span style="color: red">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                            <select class="form-control select2" id="wipBoxId" name="wipBoxId" required>
                                                <?php foreach ($readyTransfer as $row) : ?>
                                                    <option value="<?= $row->wipBoxId ?>" <?= ($row->wipBoxId == set_value('wipBoxId') ? 'selected' : '') ?>>
                                                        <?= $row->boxCode ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Kode Item<span style="color: red">*</span></th>
                                                    <th style="width: 100px;">Jumlah<span style="color: red">*</span></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBody">
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="locationForm" class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">
                                            Lokasi<span style="color: red">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                            <select class="form-control" id="location" name="location" required>
                                                <option value="WIP">WIP</option>
                                                <option value="Machining">Machining</option>
                                                <option value="Finishing">Finishing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="locationIdForm" class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">
                                            Line/Jalur<span style="color: red">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                            <select class="form-control select2" id="locationId" name="locationId" required>
                                                <?php foreach ($location as $row) : ?>
                                                    <option value="<?= $row->locationId ?>" <?= ($row->locationId == set_value('locationId') ? 'selected' : '') ?>>
                                                        <?= $row->line ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="lineNumberForm" class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">
                                            Nomor<span style="color: red">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                            <input id="lineNumber" name="lineNumber" type="number" class="form-control" placeholder="hanya angka" min="1" required></input>
                                        </div>
                                    </div>
                                    <div id="stackForm" class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">
                                            Tumpukan<span style="color: red">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                            <input id="stack" name="stack" type="number" class="form-control" placeholder="hanya angka" min="1" max="10" required></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" id="submit" class="btn btn-primary shadow-sm">Transfer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- end TAMBAH DATA-->
<!-- DETAIL-->
                <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form role="form" action="<?php echo site_url('Packing/saveWipBoxCon')?>" method="post" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">ID</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="wipBoxIdD" name="wipBoxIdD" disabled></input>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Kode Box</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" id="boxCodeD" name="boxCodeD" disabled>
                                                <option disabled selected>Pilih Box</option>
                                                <?php foreach ($box as $row) : ?>
                                                    <option value="<?= $row->boxCode ?>" <?= ($row->boxCode == set_value('boxCode') ? 'selected' : '') ?>>
                                                        <?= $row->boxCode ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <table id="itemTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Kode Item</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBody">
                                                <tr>
                                                    <td>
                                                        <select class="form-control" name="itemCode[]">
                                                            <option disabled selected>Pilih Item</option>
                                                            <?php foreach ($item as $row) : ?>
                                                                <option value="<?= $row->itemCode ?>" <?= ($row->itemCode == set_value('itemCode') ? 'selected' : '') ?>>
                                                                    <?= $row->itemCode ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="quantity[]" class="form-control" required min="1"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- end DETAIL DATA-->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END MODAL -->
            </div>
        </div>
    </section>
</div>
<?php
$data = ob_get_clean();
?>
<?php ob_start();?>
<!-- SCRIPT -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <script>
        $(document).ready(function(){
            // Inisialisasi Select2 pada dropdown yang sudah ada di halaman
            $(".select2").select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Item",
                allowClear: true,
                dropdownParent: $("#addModal")
            });

            //script set up form modal on pop up
            $('#addModal').on('shown.bs.modal', function () {
                //set detail item
                var selectedWipBoxId = $(this).find('#wipBoxId').val();
                $("#tableBody").empty();
                var wipBoxDetails = <?php echo json_encode($wipBoxDetailTransfer); ?>;
                var filteredDetails = wipBoxDetails.filter(function(detail) {
                    return detail.wipBoxId === selectedWipBoxId;
                });
                filteredDetails.forEach(function(detail) {
                    var newRow = `<tr>
                                    <td>${detail.itemCode}</td>
                                    <td>${detail.quantity}</td>
                                </tr>`;
                    $("#tableBody").append(newRow);
                });

                //set dropdown location id
                var selectedLocation = $(this).find('#location').val();
                var location = <?php echo json_encode($location); ?>;
                var filteredLocation = location.filter(function (detail) {
                    return detail.location === selectedLocation;
                });
                $("#locationId").empty();
                filteredLocation.forEach(function (detail) {
                    var newOption = `<option value="${detail.locationId}">${detail.line}</option>`;
                    $("#locationId").append(newOption);
                });
                
                //set dropdown location
                var wipBox = <?php echo json_encode($readyTransfer); ?>;
                var filteredWipBox = wipBox.filter(function(detail) {
                    return detail.wipBoxId === selectedWipBoxId;
                });
                $("#location").empty();
                var wipBoxLocation = location.filter(function (detail) {
                    return detail.locationId === filteredWipBox[0].locationId;
                });
                var loc = wipBoxLocation[0].location;
                if (loc == "Finishing") {
                    var newOption = `<option value="WIP">WIP</option>`;
                    $("#location").append(newOption);
                } else if (loc == "WIP") {
                    var newOption = `<option value="Finishing">Finishing</option>
                                        <option value="Machining">Machining</option>`;
                    $("#location").append(newOption);
                } else {
                    var newOption = `<option value="WIP">WIP</option>
                                        <option value="Finishing">Finishing</option>`;
                    $("#location").append(newOption);
                }

                //set dropdown location id
                var selectedLocation = $(this).find('#location').val();
                var filteredLocation = location.filter(function (detail) {
                    return detail.location === selectedLocation;
                });
                $("#locationId").empty();
                filteredLocation.forEach(function (detail) {
                    var newOption = `<option value="${detail.locationId}">${detail.line}</option>`;
                    $("#locationId").append(newOption);
                });

                //set visibility form
                if (selectedLocation === "WIP") {
                    $("#locationIdForm, #lineNumberForm, #stackForm").show();
                } else if (selectedLocation === "Machining") {
                    $("#locationIdForm").show();
                    $("#lineNumberForm, #stackForm").hide();
                } else {
                    $("#locationIdForm, #lineNumberForm, #stackForm").hide();
                }
            });

            //script set detail item dropdown onchange 
            $("#wipBoxId").change(function(){
                var selectedWipBoxId = $(this).val();
                $("#tableBody").empty();
                var wipBoxDetails = <?php echo json_encode($wipBoxDetailTransfer); ?>;
                var filteredDetails = wipBoxDetails.filter(function(detail) {
                    return detail.wipBoxId === selectedWipBoxId;
                });
                filteredDetails.forEach(function(detail) {
                    var newRow = `<tr>
                                    <td>${detail.itemCode}</td>
                                    <td>${detail.quantity}</td>
                                </tr>`;
                    $("#tableBody").append(newRow);
                });

                if (selectedWipBoxId) {
                    $("#locationForm, #locationIdForm, #lineNumberForm, #stackForm").show();
                } else {
                    $("#locationForm, #locationIdForm, #lineNumberForm, #stackForm").hide();
                }
                
                //set dropdown location
                var location = <?php echo json_encode($location); ?>;
                var wipBox = <?php echo json_encode($readyTransfer); ?>;
                var filteredWipBox = wipBox.filter(function(detail) {
                    return detail.wipBoxId === selectedWipBoxId;
                });
                var wipBoxLocation = location.filter(function (detail) {
                    return detail.locationId === filteredWipBox[0].locationId;
                });
                var loc = wipBoxLocation[0].location;
                $("#location").empty();
                if (loc == "Finishing") {
                    var newOption = `<option value="WIP">WIP</option>`;
                    $("#location").append(newOption);
                } else if (loc == "WIP") {
                    var newOption = `<option value="Finishing">Finishing</option>
                                        <option value="Machining">Machining</option>`;
                    $("#location").append(newOption);
                } else {
                    var newOption = `<option value="WIP">WIP</option>
                                        <option value="Finishing">Finishing</option>`;
                    $("#location").append(newOption);
                }

                //set dropdown location id
                var selectedLocation = $("#location").val();
                console.log(selectedLocation);
                var filteredLocation = location.filter(function (detail) {
                    return detail.location === selectedLocation;
                });
                $("#locationId").empty();
                filteredLocation.forEach(function (detail) {
                    var newOption = `<option value="${detail.locationId}">${detail.line}</option>`;
                    $("#locationId").append(newOption);
                });

                //set visibility form
                if (selectedLocation === "WIP") {
                    $("#locationIdForm, #lineNumberForm, #stackForm").show();
                } else if (selectedLocation === "Machining") {
                    $("#locationIdForm").show();
                    $("#lineNumberForm, #stackForm").hide();
                } else {
                    $("#locationIdForm, #lineNumberForm, #stackForm").hide();
                }
            });

            $("#location").change(function () {
                var selectedLocation = $(this).val();
                var location = <?php echo json_encode($location); ?>;

                var filteredLocation = location.filter(function (detail) {
                    return detail.location === selectedLocation;
                });
                $("#locationId").empty();
                filteredLocation.forEach(function (detail) {
                    var newOption = `<option value="${detail.locationId}">${detail.line}</option>`;
                    $("#locationId").append(newOption);
                });

                if (selectedLocation === "WIP") {
                    $("#locationIdForm, #lineNumberForm, #stackForm").show();
                } else if (selectedLocation === "Machining") {
                    $("#locationIdForm").show();
                    $("#lineNumberForm, #stackForm").hide();
                } else {
                    $("#locationIdForm, #lineNumberForm, #stackForm").hide();
                }
            });

            $("#submit").click(function(event){
                let isValid = true;
                let wipBoxId = $("#wipBoxId").val();
                let stackField = $("#stack");
                let lineNumberField = $("#lineNumber");
                let stackForm = $("#stackForm");
                let lineNumberForm = $("#lineNumberForm");

                // Cek apakah Kode Box sudah dipilih
                if (!wipBoxId) {
                    Swal.fire({
                        icon: "warning",
                        title: "Peringatan!",
                        text: "Silakan pilih Kode Box terlebih dahulu.",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                    isValid = false;
                }

                if (stackForm.is(":hidden") && lineNumberForm.is(":hidden")) {
                    stackField.removeAttr("required");
                    lineNumberField.removeAttr("required");
                } else {
                    stackField.attr("required", "required");
                    lineNumberField.attr("required", "required");
                }

                // Jika tidak valid, hentikan pengiriman form
                if (!isValid) {
                    event.preventDefault();
                }
            });

            //detail button script
            $('.detailbtn').on('click', function () {
                $('#detailModal').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function(){
                    return $(this).text();
                }).get();

                $('#wipBoxIdD').val(data[0]);
                $('#boxCodeD').val(data[1]);

                var wipBoxId = data[0];

                $('#itemTable tbody').empty();

                var details = <?php echo json_encode($wipBoxDetail); ?>;
                var items = <?php echo json_encode($item); ?>;

                details.forEach(function(detail) {
                    if (wipBoxId == detail.wipBoxId) {
                        var row = `<tr>
                                    <td>
                                        <select class="form-control" name="itemCodeD[]" required disabled>`;
                        items.forEach(function(item) {
                            var selected = (item.itemCode == detail.itemCode) ? 'selected' : '';
                            row += `<option value="${item.itemCode}" ${selected}>${item.itemName}</option>`;
                        });
                        row += `</select>
                                </td>
                                <td><input type="number" name="quantityD[]" class="form-control" required disabled min="1" value="${detail.quantity}"></td>
                            </tr>`;

                        $('#itemTable tbody').append(row);
                    }
                });

                // Inisialisasi Select2 setelah data ditambahkan di modal detail
                $(".select2").select2({
                    theme: 'bootstrap4',
                    placeholder: "Pilih Item",
                    allowClear: true,
                    dropdownParent: $("#detailModal")
                });
            });
        });

        // Alert close button
        function closeAlert(alertId) {
            const alertElement = document.getElementById(alertId);
            if (alertElement) {
                alertElement.style.display = 'none';
            }
        }
    </script>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END SCRIPT -->

<?php
$script = ob_get_clean();
include('master_page.php');
ob_flush();
?>