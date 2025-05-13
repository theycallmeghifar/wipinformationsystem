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
                    <h1 class="m-0">Lokasi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Menu</a></li>
                        <li class="breadcrumb-item active">Master Data</a></li>
                        <li class="breadcrumb-item active">Lokasi</a></li>
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
                            <button type="button" id="btnTambah" style="margin-top: 10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal">Tambah Data</button>
                            <div class="d-flex align-items-center pull-right">
                                <select name="areaFilter" id="areaFilter" class="form-control form-control-user" style="width: 180px;margin-top: 10px;margin-right: 5px">
                                    <option value='Finishing'>Area: Finishing</option>
                                    <option value='WIP'>Area: WIP</option>
                                    <option value='Machining'>Area: Machining</option>
                                </select>
                            </div>
                            <form id="formPrint" target="_blank" method="post" role="form" action="<?php echo site_url('QrCodeCon/qrCodeLocationCon') ?>">
                                <input hidden="true" id="txtPrint" name="listPrint" />
                                <button class="btn btn-success pull-left" style="margin-top: 10px; margin-right: 5px;" id="btnPrint" type="button" class="btn btn-info">
                                    Print QR Lokasi
                                </button>
                            </form>
                            <button id="btnCheck" type="button" onclick="check();" style="margin-top: 10px; margin-right: 5px;" class="btn btn-secondary pull-left">
                                <i style="margin-right: 8px;" class="fas fa-minus-square"></i>Pilih Semua QR Code
                            </button>
                            <button id="btnUncheck" type="button" onclick="uncheck();" style="margin-top: 10px; margin-right: 5px;" class="btn btn-secondary pull-left">
                                <i style="margin-right: 8px;" class="fas fa-times"></i>Batal Pilih Semua
                            </button>
                            <button id="show_all_records" type="button" style="margin-top: 10px; margin-right: 5px;" class="btn btn-info pull-left">
                                <i style="margin-right: 8px;" class="fas fa-tasks"></i>Lihat Semua Data
                            </button>
                            <button id="restore_records" type="button" style="margin-top: 10px; margin-right: 5px;" class="btn btn-info pull-left">
                                <i style="margin-right: 8px;" class="fas fa-times"></i>Reset Tabel
                            </button>
                            <form id="formExportExcel" target="_blank" method="post" role="form" action="<?php echo site_url('Location/ExportExcelLocationCon') ?>">
                                <button class="btn btn-success pull-left" style="margin-top: 10px; margin-right: 5px;" id="btnExportExcel" type="submit">
                                    <i style="margin-right: 8px;" class="fas fa-arrow-up"></i>Export Excel
                                </button>
                            </form>
                            <button id="btnImport" type="button" style="margin-top: 10px; margin-right: 5px;" class="btn btn-success pull-left" data-toggle="modal" data-target="#importData">
                                <i style="margin-right: 8px;" class="fas fa-arrow-down"></i>Import Excel
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="display nowrap table-striped table" style="width:100%" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Area</th>
                                        <th>Line/Jalur/Lokasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        <th hidden="true">Area</th>
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
                                        <td><?php echo $data->locationId?></td>
                                        <td><?php echo $data->area?></td>
                                        <td><?php echo $data->line?></td>
                                        <td>
                                            <?php if ($data->status == 0) { ?>
                                                <span class='badge badge-danger'>Tidak Aktif</span>
                                            <?php } else { ?>
                                                <span class='badge badge-success'>Aktif</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <input class='form-check-input' type='checkbox' id='checkPrint' value='<?php echo $data->locationId?>'/>
                                            <a href="javascript:void(0);" onclick="editButton(<?php echo $data->locationId ?>)" class="fa fa-pencil-square-o color-muted editbtn" title="Ubah Data" style="margin-left: 15px;"></a>
                                            <a href="javascript:void(0);" onclick="detailButton(<?php echo $data->locationId ?>)" class="fa fa-tasks color-muted detailbtn" title="Detail Data" style="margin-left: 15px;"></a>
                                        </td>
                                        <td hidden="true"><?php echo $data->area?></td>
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
                                <h5 class="modal-title">Tambah Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form role="form" action="<?php echo site_url('Location/saveLocationCon')?>" method="post" autocomplete="off">
                                <div class="modal-body" style="width: 700px;">
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Area<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                            <select name="area" id="area" class="form-control form-control-user" style="width: 180px;">
                                                <option value='Finishing'>Finishing</option>
                                                <option value='WIP'>WIP</option>
                                                <option value='Machining'>Machining</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Line/Jalur/Lokasi<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="text" id="line" name="line" class="form-control form-control-user" value="Line " required></input>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Nomor</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="number" id="number" name="number" class="form-control form-control-user" min="0" disabled></input>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button ID="submit" name="submit" class="btn btn-primary shadow-sm" Text="Create">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- end TAMBAH DATA-->
<!-- UBAH DATA -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form role="form" action="<?php echo site_url('Location/updateLocationCon')?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                <div class="modal-body" style="width: 700px;">
                                    <div class="row match-height">
                                        <div class="col-12">
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">ID</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="text" id="locationIdU" name="locationIdU" class="form-control form-control-user" readonly required></input>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Area<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <select name="areaU" id="areaU" class="form-control form-control-user" style="width: 180px;">
                                                        <option value='Finishing'>Finishing</option>
                                                        <option value='WIP'>WIP</option>
                                                        <option value='Machining'>Machining</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Line/Jalur/Lokasi<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="text" id="lineU" name="lineU" class="form-control form-control-user" required></input>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Nomor<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="number" id="numberU" name="numberU" class="form-control form-control-user" required min="0"></input>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Status<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <select name="statusU" id="statusU" class="form-control form-control-user" style="width: 180px;">
                                                        <option value='1'>Aktif</option>
                                                        <option value='0'>Tidak Aktif</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button ID="submit" name="updateData" class="btn btn-primary shadow-sm">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- end UBAH DATA-->
<!-- DETAIL-->
                <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="width: 700px;">
                                <div class="row match-height">
                                    <div class="col-12">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-5 col-form-label text-label">ID</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" id="locationIdD" name="locationIdD" class="form-control form-control-user" disabled required></input>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-5 col-form-label text-label">Area</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                <input type="text" id="areaD" name="areaD" class="form-control form-control-user" disabled></input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-5 col-form-label text-label">Line/Jalur/Lokasi</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                <input type="text" id="lineD" name="lineD" class="form-control form-control-user" disabled></input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Nomor</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="number" id="numberD" name="numberD" class="form-control form-control-user" disabled></input>
                                                    </div> 
                                                </div>
                                            </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-5 col-form-label text-label">Status</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <select name="statusD" id="statusD" class="form-control form-control-user" style="width: 180px;" disabled>
                                                        <option value='1'>Aktif</option>
                                                        <option value='0'>Tidak Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-5 col-form-label text-label">Tanggal Dibuat</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                <input type="text" id="createdDateD" name="createdDateD" class="form-control form-control-user" disabled></input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-5 col-form-label text-label">Tanggal Diedit</label>
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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
<!-- end DETAIL DATA-->
<!-- IMPORT DATA -->
                <div class="modal fade" id="importData" tabindex="-1" role="dialog" aria-labelledby="importData" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <form action="<?php echo base_url('Location/importExcelLocationCon') ?>" method="POST" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Import Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="width:700px;">
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
                                    <button type="submit" id="submit" name="submit" value="edit" class="btn btn-primary shadow-sm">Edit Data</button>
                                    <button type="submit" id="submit" name="submit" value="add" class="btn btn-primary shadow-sm">Tambah Data</button>
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
        $(document).ready(function(){
            //update table
            //event listener dropdown area
            $('#areaFilter').on('change', function () {
                updateTable();
            });

            updateTable();

            function updateTable() {
                let area = $('#areaFilter').val();
                let showNomor = (area === 'WIP');

                $.ajax({
                    url: '<?= base_url("Location/getLocationByAreaCon") ?>',
                    type: 'GET',
                    data: { area: area },
                    dataType: 'json',
                    success: function (response) {
                        let rows = '';

                        let thead = `
                            <tr>
                                <th>ID</th>
                                <th>Area</th>
                                <th>Line/Jalur/Lokasi</th>
                                <th>Nomor</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                <th hidden="true">Area</th>
                                <th hidden="true">Int Status</th>
                                <th hidden="true">Created Date</th>
                                <th hidden="true">Modified Date</th>
                            </tr>
                        `;
                        $('#dataTable thead').html(thead);

                        response.forEach(function (data) {
                            let status = (data.status == 0)
                                ? "<span class='badge badge-danger'>Tidak Aktif</span>"
                                : "<span class='badge badge-success'>Aktif</span>";

                            rows += `
                                <tr>
                                    <td>${data.locationId}</td>
                                    <td>${data.area}</td>
                                    <td>${data.line}</td>
                                    <td>${data.number == 0 ? '-' : data.number}</td> <!-- kolom nomor tetap ada -->
                                    <td>${status}</td>
                                    <td>
                                        <input class='form-check-input' type='checkbox' value='${data.locationId}'/>
                                        <a href="javascript:void(0);" onclick="editButton(${data.locationId})" class="fa fa-pencil-square-o color-muted editbtn" title="Ubah Data" style="margin-left: 15px;"></a>
                                        <a href="javascript:void(0);" onclick="detailButton(${data.locationId})" class="fa fa-tasks color-muted detailbtn" title="Detail Data" style="margin-left: 15px;"></a>
                                    </td>
                                    <td hidden="true">${data.area}</td>
                                    <td hidden="true">${data.status}</td>
                                    <td hidden="true">${data.createdDate}</td>
                                    <td hidden="true">${data.modifiedDate}</td>
                                </tr>
                            `;
                        });

                        let table = $('#dataTable').DataTable();
                        table.destroy();
                        $('#dataTable tbody').html(rows);

                        table = $('#dataTable').DataTable({
                            order: [[0, 'asc']],
                            columnDefs: [
                                {
                                    targets: 3,
                                    visible: showNomor
                                }
                            ]
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            }

            // Jalankan saat modal dibuka
            $('#addModal').on('shown.bs.modal', function () {
                handleAddModalAreaChange(); // Set default saat modal muncul
            });

            // Saat area berubah
            $('#area').on('change', function () {
                handleAddModalAreaChange();
            });

            function handleAddModalAreaChange() {
                const area = $('#area').val();

                // Atur nilai input line berdasarkan area
                if (area === 'Finishing') {
                    $('#line').val('');
                } else if (area === 'WIP') {
                    $('#line').val('Jalur');
                } else if (area === 'Machining') {
                    $('#line').val('Line');
                }

                // Tampilkan/sembunyikan input number hanya jika area == WIP
                if (area === 'WIP') {
                    $('#number').closest('.form-group').show();
                    $('#number').val(1);
                    $('#number').prop('disabled', false);
                } else {
                    $('#number').closest('.form-group').hide();
                    $('#number').val(0);
                }
            }

            // Jalankan saat modal dibuka
            $('#editModal').on('shown.bs.modal', function () {
                handleEditModalAreaChange(); // Set default saat modal muncul
            });

            // Saat area berubah
            $('#areaU').on('change', function () {
                handleEditModalAreaChange();
            });

            function handleEditModalAreaChange() {
                const area = $('#areaU').val();
                // Tampilkan/sembunyikan input number hanya jika area == WIP
                if (area === 'WIP') {
                    $('#numberU').closest('.form-group').show();
                    $('#numberU').prop('required', true);
                } else {
                    $('#numberU').closest('.form-group').hide();
                    $('#numberU').prop('required', false);
                }
            }

            // Jalankan saat modal dibuka
            $('#detailModal').on('shown.bs.modal', function () {
                handleDetailModalAreaChange(); // Set default saat modal muncul
            });

            // Saat area berubah
            $('#areaD').on('change', function () {
                handleDetailModalAreaChange();
            });

            function handleDetailModalAreaChange() {
                const area = $('#areaD').val();
                // Tampilkan/sembunyikan input number hanya jika area == WIP
                if (area === 'WIP') {
                    $('#numberD').closest('.form-group').show();
                    $('#numberD').prop('required', true);
                } else {
                    $('#numberD').closest('.form-group').hide();
                    $('#numberD').prop('required', false);
                }
            }

            //update button script
            window.editButton = function(locationId) {
                $.ajax({
                    url: '<?= base_url("Location/getLocationByIdCon") ?>',
                    type: 'GET',
                    data: { locationId: locationId },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        // Isi modal dengan data dari server
                        $('#locationIdU').val(response.locationId);
                        $('#areaU').val(response.area);
                        $('#lineU').val(response.line);
                        $('#numberU').val(response.number);
                        $('#statusU').val(response.status);
                        
                        // Pastikan ID modal sesuai dengan yang ada di HTML
                        $('#editModal').modal('show'); 
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            }
            
            //detail button script
            window.detailButton = function(locationId) {
                $.ajax({
                    url: '<?= base_url("Location/getLocationByIdCon") ?>',
                    type: 'GET',
                    data: { locationId: locationId },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        // Isi modal dengan data dari server
                        $('#locationIdD').val(response.locationId);
                        $('#areaD').val(response.area);
                        $('#lineD').val(response.line);
                        $('#numberD').val(response.number);
                        $('#statusD').val(response.status);
                        $('#createdDateD').val(response.createdDate); 
                        $('#modifiedDateD').val(response.modifiedDate);
                        
                        // Pastikan ID modal sesuai dengan yang ada di HTML
                        $('#detailModal').modal('show'); 
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            }
        });

        $(document).ready(function () {
            $('#addModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            $('#editModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            $('#detailModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            $('#importData').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
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

        //alert close button
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