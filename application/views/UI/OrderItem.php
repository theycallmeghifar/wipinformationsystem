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
                    <?php if ($this->session->userdata('role') == 1) { ?>
                        <h1 class="m-0">Pesanan Item</h1>
                    <?php } ?>
                    <?php if ($this->session->userdata('role') == 2) { ?>
                        <h1 class="m-0">Pesan Item</h1>
                    <?php } ?>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Menu</a></li>
                        <?php if ($this->session->userdata('role') == 1) { ?>
                            <li class="breadcrumb-item active">Pesanan Item</li>
                        <?php } ?>
                        <?php if ($this->session->userdata('role') == 2) { ?>
                            <li class="breadcrumb-item active">Pesan Item</li>
                        <?php } ?>
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
                            <?php if ($this->session->userdata('role') == 2) { ?>
                                <button type="button" id="btnTambah" style="margin-top: 10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal">Pesan Item</button>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" data-order='[[7, "desc"]]' class="display nowrap table-striped table" style="width:100%" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Line</th>
                                        <th>Item/Cavity</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <?php if ($this->session->userdata('role') == 1) { ?>
                                            <th>Aksi</th>
                                        <?php } ?>
                                        <th hidden="true">Int Status</th>
                                        <th hidden="true">Created Date</th>
                                        <th hidden="true">Modified Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--diisi oleh ajax-->
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
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pesan Item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="<?php echo site_url('OrderItem/saveOrderItemCon')?>" method="post" autocomplete="off" style="margin: 30px;">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <table id="modalTable" class="display nowrap table-striped table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ItemCode</th>
                                                        <th>Item</th>
                                                        <th>Stok</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group align-items-center">
                                                <div class="custom-control custom-radio d-block">
                                                    <input class="custom-control-input" type="radio" id="TypeRadio1" name="customRadio" value="item" checked>
                                                    <label for="TypeRadio1" class="custom-control-label">Item</label>
                                                </div>
                                                <div class="custom-control custom-radio d-block">
                                                    <input class="custom-control-input" type="radio" id="TypeRadio2" name="customRadio" value="cavity">
                                                    <label for="TypeRadio2" class="custom-control-label">Cavity</label>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Line<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <select name="locationId" id="locationId" class="form-control select2" style="width: 180px;">
                                                            <?php foreach ($location as $row) : ?> 
                                                                <option value="<?= $row->locationId ?>" <?= ($row->locationId == set_value('locationId') ? 'selected' : '') ?> >
                                                                    <?= $row->line ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Item<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <select name="itemCode" id="itemCode" class="form-control select2" style="width: 180px;">
                                                            <?php foreach ($item as $row) : ?> 
                                                                <option value="<?= $row->itemCode ?>" <?= ($row->itemCode == set_value('itemCode') ? 'selected' : '') ?> >
                                                                    <?= $row->itemName ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Cavity<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <select name="cavity" id="cavity" class="form-control select2" style="width: 180px;">
                                                            <?php foreach ($item as $row) : ?> 
                                                                <option value="<?= $row->cavity ?>" <?= ($row->cavity == set_value('cavity') ? 'selected' : '') ?> >
                                                                    <?= $row->cavity ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Jumlah<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="number" id="quantity" name="quantity" class="form-control form-control-user" placeholder="Hanya angka" required min="1"></input>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button ID="submit" name="submit" class="btn btn-primary shadow-sm" Text="Create">Pesan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<!-- end TAMBAH DATA-->
<!-- KONFIRMASI DATA -->
                <div class="modal fade" id="acceptmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi Pesanan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form role="form" action="<?php echo site_url('orderItem/confirmOrderCon')?>" method="post" autocomplete="off" style="margin: 30px;">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-5 col-form-label text-label">Order Id<span style="color: red">*</span></label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" id="orderId" name="orderId" class="form-control form-control-user"></input>
                                                </div> 
                                            </div>
                                        </div>
                                        <table id="confirmationTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th hidden="true">WIPBoxId</th>
                                                    <th>Kode Box</th>
                                                    <th>Kode Item</th>
                                                    <th>Cavity</th>
                                                    <th style="width: 100px;">Jumlah</th>
                                                    <th>Hapus</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBody">
                                                <!-- diisi oleh ajax -->
                                            </tbody>
                                        </table>
                                        <p style="color:red">*Box pada tabel tidak dapat dipesan lagi.</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="action" value="reject" class="btn btn-danger">Tolak</button>
                                    <button type="submit" name="action" value="accept" class="btn btn-primary shadow-sm">Konfirmasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- end KONFIRMASI DATA-->
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
        function fetchOrderItems() {
            var role = <?= json_encode($this->session->userdata('role')) ?>;
            
            $.ajax({
                url: "<?= base_url('orderitem/getAllOrderDataCon') ?>",
                type: "GET",
                dataType: "json", 
                success: function(data) {
                    let tableRows = "";
                    data.forEach(function(item) {
                        let actionButtons = "";

                        if (role == 1 && item.status == 0) {
                            actionButtons = `
                                <td>
                                    <a href="javascript:void(0);" class="fa fa-pencil color-muted confirmbtn" title="Konfirmasi" style="margin-left: 15px;"></a>
                                </td>
                            `;
                        } else if (role == 1 && item.status != 0) {
                            actionButtons = `<td>-</td>`;
                        }

                        let badgeClass = "bg-secondary";
                        if (item.statusText === "Belum Dikonfirmasi") {
                            badgeClass = "bg-warning";
                        } else if (item.statusText === "Dikonfirmasi") {
                            badgeClass = "bg-primary";
                        } else if (item.statusText === "Ditolak") {
                            badgeClass = "bg-danger";
                        }

                        tableRows += `
                            <tr>                             
                                <td>${item.orderId}</td>
                                <td>${item.line}</td>
                                <td>${item.itemCode ? item.itemCode : item.cavity}</td>
                                <td>${item.quantity}</td>
                                <td><span class="badge ${badgeClass}">${item.statusText}</span></td>
                                ${actionButtons}
                                <td hidden="true">${item.status}</td>
                                <td hidden="true">${item.createdDate}</td>
                                <td hidden="true">${item.modifiedDate}</td>
                            </tr>
                        `;
                    });
                    $("#dataTable tbody").html(tableRows);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        setInterval(fetchOrderItems, 1000);

        $(document).ready(function() {
            fetchOrderItems();

            // Inisialisasi Select2 pada dropdown yang sudah ada di halaman
            $(".select2").select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Item",
                allowClear: true,
                dropdownParent: $("#addModal")
            });
            
            $(document).on('click', '.confirmbtn', function() {
                let row = $(this).closest('tr');
                let orderId = row.find('td:eq(0)').text().trim();
                let item = row.find('td:eq(2)').text().trim();
                let quantity = row.find('td:eq(3)').text().trim();

                $('#orderId').val(orderId);

                $.ajax({
                    url: "<?= base_url('orderitem/getMatchingBoxCon') ?>",
                    type: "GET",
                    data: { item: item, quantity: quantity }, 
                    dataType: "json", 
                    success: function(data) {
                        let tableRows = "";
                        data.forEach(function(item, index) {
                            tableRows += `
                                <tr>                             
                                    <td hidden="true">
                                        <input type="hidden" name="wipBoxData[${index}][wipBoxId]" value="${item.wipBoxId}">
                                    </td>
                                    <td>${item.boxCode}</td>
                                    <td>
                                        ${item.itemCode}
                                        <input type="hidden" name="wipBoxData[${index}][itemCode]" value="${item.itemCode}">
                                    </td>
                                    <td>
                                        ${item.cavity}
                                        <input type="hidden" name="wipBoxData[${index}][cavity]" value="${item.cavity}">
                                    </td>
                                    <td>
                                        ${item.quantity}
                                        <input type="hidden" name="wipBoxData[${index}][quantity]" value="${item.quantity}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm removeRow">
                                            <i class="fas fa-trash" style="color:white"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                        $("#confirmationTable tbody").html(tableRows);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                    }
                });

                $('#acceptmodal').modal('show');
            });

            $("#confirmationTable").on("click", ".removeRow", function () {
                let rowCount = $("#confirmationTable tbody tr").length;
                
                if (rowCount === 1) {
                    Swal.fire({
                        title: "Peringatan!",
                        text: "Minimal ada 1 box yang harus di konfirmasi.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                } else {
                    Swal.fire({
                        title: "Konfirmasi Hapus",
                        text: "Apakah Anda yakin ingin menghapus box ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Hapus",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).closest("tr").remove();
                        }
                    });
                }
            });
        });

        // Saat pertama kali load, tampilkan dropdown Item dan sembunyikan dropdown Cavity
        $('#itemCode').closest('.form-group.row').show();
        $('#cavity').closest('.form-group.row').hide();

        // Event ketika radio button berubah
        //ubah tabel
        function updateModalTable() {
            if ($('#TypeRadio1').is(':checked')) {
                $('#modalTable thead').html(`
                    <tr>
                        <th>Kode Item</th>
                        <th>Item</th>
                        <th>Quantity</th>
                    </tr>
                `);

                let itemCode = $('#itemCode').val();
                let cavity = $('#cavity').val();

                $.ajax({
                    url: '<?= base_url("OrderItem/getOrderItemDataCon") ?>',
                    type: 'GET',
                    data: { itemCode: itemCode }, 
                    dataType: 'json',
                    success: function(response) {
                        let rows = '';
                        response.forEach(function(data) {
                            rows += `
                                <tr>                             
                                    <td>${data.itemCode}</td>
                                    <td>${data.itemName}</td>
                                    <td>${data.quantity}</td>
                                </tr>
                            `;
                        });
                        $('#modalTable tbody').html(rows);
                    }
                });

            } else if ($('#TypeRadio2').is(':checked')) {
                $('#modalTable thead').html(`
                    <tr>
                        <th>Cavity</th>
                        <th>Quantity</th>
                    </tr>
                `);

                let itemCode = $('#itemCode').val();
                let cavity = $('#cavity').val();

                $.ajax({
                    url: '<?= base_url("OrderItem/getOrderCavityDataCon") ?>',
                    type: 'GET',
                    data: { cavity: cavity },
                    dataType: 'json',
                    success: function(response) {
                        let rows = '';
                        response.forEach(function(data) {
                            rows += `
                                <tr>                             
                                    <td>${data.cavity}</td>
                                    <td>${data.quantity}</td>
                                </tr>
                            `;
                        });
                        $('#modalTable tbody').html(rows);
                    }
                });
            }
        }

        updateModalTable();

        document.getElementById("submit").addEventListener("click", function (event) {
            let itemCode = document.getElementById("itemCode").value;
            let line = document.getElementById("line").value;
            let cavity = document.getElementById("cavity").value;
            let quantity = document.getElementById("quantity").value;

            if (!itemCode || !line || !cavity) {
                event.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Harap isi semua data terlebih dahulu.',
                });
            }
        });

        // Event listener untuk radio button
        $('input[name="customRadio"]').on('change', function(){
            updateModalTable();
            if ($('#TypeRadio1').is(':checked')) { 
                $('#itemCode').closest('.form-group.row').show();
                $('#cavity').closest('.form-group.row').hide();
            } else if ($('#TypeRadio2').is(':checked')) { 
                $('#itemCode').closest('.form-group.row').hide();
                $('#cavity').closest('.form-group.row').show();
            }
        });

        // Event listener untuk dropdown
        $('#cavity, #itemCode').on('change', function () {
            updateModalTable();
        });

        $('#btnPrint').on("click", function(e) {
            var count = 0;
            var listPrint = [];
            var print = "";
            $('input[type="checkbox"]:checked').each(function() {
                if ($(this).prop('checked', true)) {
                    listPrint.push($(this).val());
                    if ($(this).val() != 0) {
                        count++;
                        print += $(this).val() + "|";
                    }
                }
            });
            if (listPrint.length > 0) {
                if (count > 100) {
                    Swal.fire({
                        title: 'Print QR Code tidak bisa dilakukan',
                        text: 'Maksimal memilih 100 data untuk melakukan print',
                        icon: 'warning'
                    });
                } else {
                txtPrint.value = print;
                $("#formPrint").submit();
                }
            } else {
                Swal.fire({
                    title: 'Pilih data terlebih dahulu',
                    text: '',
                    icon: 'warning'
                });
            }
        });

        var btncheck = document.getElementById('btnCheck');
        var btnuncheck = document.getElementById('btnUncheck');

        window.onload = function () {
            restore_records.style.display = "none";
            btncheck.style.display = "block";
            btnuncheck.style.display = "none";
        }

        function check() {
            $("input:checkbox").prop("checked", true);
            btncheck.style.display = "none";
            btnuncheck.style.display = "block";
        }

        function uncheck() {
            $("input:checkbox").prop("checked", false);
            btncheck.style.display = "block";
            btnuncheck.style.display = "none";
        }

        var oTable; //global variable to hold reference to dataTables
        var oSettings; //global variable to hold reference to dataTables settings

        $(document).ready(function(){
            oTable=$('#dataTable').DataTable( {
                "bSort": true,
                "pagingType": "full_numbers",
            }); //store reference of your table in oTable
            oSettings = oTable.settings(); //store its settings in oSettings
        });

        $("#show_all_records").on('click',function(){
           show_all_records.style.display = "none";
           restore_records.style.display = "block";
           oSettings[0]._iDisplayLength = oSettings[0].fnRecordsTotal();
           //set display length of dataTables settings to the total records available
           oTable.draw();  //draw the table
        });

        $("#restore_records").on('click',function(){
            show_all_records.style.display = "block";
            restore_records.style.display = "none";
            oSettings[0]._iDisplayLength=10;
           //set it back to 10
            oTable.draw();//again draw the table
        });

        document.getElementById('file').addEventListener('change', function(event) {
            const allowedExtensions = ['xlsx', 'xls'];
            const fileInput = event.target;
            const fileName = fileInput.value.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(fileName)) {
                Swal.fire({
                    title: 'File tidak valid',
                    text: 'File yang diunggah harus dalam format .xlsx atau .xls.',
                    icon: 'warning'
                });

                fileInput.value = ''; 
            }
        });

        document.getElementById('importForm').addEventListener('submit', function(event) {
            const fileInput = document.getElementById('file');
            const allowedExtensions = ['xlsx', 'xls'];
            const fileName = fileInput.value.split('.').pop().toLowerCase();

            if (fileInput.value === '' || !allowedExtensions.includes(fileName)) {
                event.preventDefault();
                Swal.fire({
                    title: 'File tidak valid',
                    text: 'Silakan pilih file dengan format .xlsx atau .xls.',
                    icon: 'warning'
                });
            }
        });

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