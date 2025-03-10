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
                            <table id="dataTable" class="display nowrap table-striped table" style="width:100%" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <?php if ($this->session->userdata('role') == 1) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <th hidden="true">Int Status</th>
                                        <th hidden="true">Created Date</th>
                                        <th hidden="true">Modified Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($getData as $data){
                                    ?>
                                    <tr>                             
                                        <td><?php echo $data->orderItemId?></td>
                                        <td><?php echo $data->itemCode?></td>
                                        <td><?php echo $data->quantity?></td>
                                        <td><?php if($data->status == 0){
                                            echo "Confirmed";
                                        }else{ 
                                            echo "Pending";
                                        }?></td>
                                        <?php if ($this->session->userdata('role') == 1) { ?>
                                            <td>
                                                <a href="javascript:void(0);" class="fa fa-check color-muted editbtn" title="Confirm Order" style="margin-left: 15px;"></a>
                                                <a href="javascript:void(0);" class="fa fa-close color-muted detailbtn" title="Reject Order" style="margin-left: 15px;"></a>
                                            </td>
                                        <?php } ?>
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
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pesan Item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="<?php echo site_url('OrderItem/saveOrderItemCon')?>" method="post" autocomplete="off">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ItemCode</th>
                                                        <th>Item</th>
                                                        <th>Cavity</th>
                                                        <th>Stok</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <div style="max-height: 350px; overflow-y: auto;">
                                                <table id="dataTableBody" class="display nowrap table-striped table" style="width:100%">
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group align-items-center">
                                                <div class="custom-control custom-radio d-block">
                                                    <input class="custom-control-input" type="radio" id="TypeRadio1" name="customRadio" checked>
                                                    <label for="TypeRadio1" class="custom-control-label">Item</label>
                                                </div>
                                                <div class="custom-control custom-radio d-block">
                                                    <input class="custom-control-input" type="radio" id="TypeRadio2" name="customRadio">
                                                    <label for="TypeRadio2" class="custom-control-label">Cavity</label>
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
<!-- UBAH DATA -->
                <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form role="form" action="<?php echo site_url('Box/updateBoxCon')?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                <div class="modal-body" style="width: 410px;">
                                    <div class="row match-height">
                                        <div class="col-12">
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Box Code</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="text" id="boxCodeU" name="boxCodeU" class="form-control form-control-user" readonly required></input>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Box Color<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <select name="boxColorU" id="boxColorU" class="form-control form-control-user" style="width: 180px;">
                                                        <option value='Red'>Red</option>
                                                        <option value='Yellow'>Yellow</option>
                                                        <option value='Green'>Green</option>
                                                        <option value='Blue'>Blue</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Capacity<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <input type="number" id="capacityU" name="capacityU" class="form-control form-control-user" placeholder="Numbers only" required min="1"></input>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Status<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <select name="statusU" id="statusU" class="form-control form-control-user" style="width: 180px;">
                                                        <option value='1'>Active</option>
                                                        <option value='0'>Inactive</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
                                    <button ID="submit" name="updateData" class="btn btn-primary shadow-sm">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- end UBAH DATA-->
<!-- DETAIL-->
                <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailData" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="width: 410px;">
                                    <div class="row match-height">
                                        <div class="col-12">
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Box Code</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="text" id="boxCodeD" name="boxCodeD" class="form-control form-control-user" disabled required></input>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Box Color</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <select name="boxColorD" id="boxColorD" class="form-control form-control-user" style="width: 180px;" disabled>
                                                        <option value='Red'>Red</option>
                                                        <option value='Yellow'>Yellow</option>
                                                        <option value='Green'>Green</option>
                                                        <option value='Blue'>Blue</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Capacity</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <input type="number" id="capacityD" name="capacityD" class="form-control form-control-user" placeholder="Numbers only" required min="1" disabled></input>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Usage Status</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <input type="text" id="usageStatusD" name="usageStatusD" class="form-control form-control-user" disabled></input>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Status</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <select name="statusD" id="statusD" class="form-control form-control-user" style="width: 180px;" disabled>
                                                            <option value='1'>Active</option>
                                                            <option value='0'>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Created Date</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <input type="text" id="createdDateD" name="createdDateD" class="form-control form-control-user" disabled></input>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">modified Date</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <input type="text" id="modifiedDateD" name="modifiedDateD" class="form-control form-control-user" disabled></input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
<!-- end DETAIL DATA-->
<!-- IMPORT DATA -->
<div class="modal fade" id="importData" tabindex="-1" role="dialog" aria-labelledby="importData" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <form action="<?php echo base_url('Box/importExcelBoxCon') ?>" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="width:350px;">
                    <div class="form-group row align-items-center">
                        <label class="col-sm-5 col-form-label text-label">Pilih File<span style="color: red">*</span></label>
                        <div class="col-sm-7">
                            <div class="input-group">
                                <input type="file" id="file" name="file" class="form-control form-control-user" accept=".xlsx, .xls" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary shadow-sm">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
    <!-- end IMPORT DATA-->
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
        $(document).ready(function() {
            // Inisialisasi Select2 pada dropdown yang sudah ada di halaman
            $(".select2").select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Item",
                allowClear: true,
                dropdownParent: $("#addModal")
            });
            
            $('.editbtn').on('click', function() {
                // Menampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Confirm Order?',
                    text: "Are you sure you want to confirm this order?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user memilih "Yes", tampilkan modal
                        $('#editmodal').modal('show');
                        
                        $tr = $(this).closest('tr');
                        var data = $tr.children("td").map(function() {
                            return $(this).text();
                        }).get();
                        console.log(data);

                        // Isi form dengan data yang ada pada baris tabel
                        $('#boxCodeU').val(data[0]);
                        $('#boxColorU').val(data[1]);
                        $('#capacityU').val(data[2]);
                        $('#statusU').val(data[7]);
                    }
                });
            });
        });

        $(document).ready(function(){
            $('.detailbtn').on('click', function(){
                // Menampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Reject Order?',
                    text: "Are you sure you want to reject this order?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user memilih "Yes", tampilkan modal
                        $('#detailModal').modal('show');
                        
                        $tr = $(this).closest('tr');
                        var data = $tr.children("td").map(function() {
                            return $(this).text();
                        }).get();
                        console.log(data);

                        // Isi form dengan data yang ada pada baris tabel
                        $('#boxCodeD').val(data[0]);
                        $('#boxColorD').val(data[1]);
                        $('#capacityD').val(data[2]);
                        $('#locationD').val(data[3]);
                        $('#usageStatusD').val(data[4]);
                        $('#statusD').val(data[7]);
                        $('#createdDateD').val(data[8]);
                        $('#modifiedDateD').val(data[9]);
                    }
                });
            });
        });

        // Saat pertama kali load, tampilkan dropdown Item dan sembunyikan dropdown Cavity
        $('#itemCode').closest('.form-group.row').show();
        $('#cavity').closest('.form-group.row').hide();

        // Event ketika radio button berubah
        $('input[name="customRadio"]').on('change', function(){
            if ($('#TypeRadio1').is(':checked')) { // Jika "Item" dipilih
                $('#itemCode').closest('.form-group.row').show();
                $('#cavity').closest('.form-group.row').hide();
            } else if ($('#TypeRadio2').is(':checked')) { // Jika "Cavity" dipilih
                $('#itemCode').closest('.form-group.row').hide();
                $('#cavity').closest('.form-group.row').show();
            }
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