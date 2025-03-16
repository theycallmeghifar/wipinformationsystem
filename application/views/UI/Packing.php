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
                    <h1 class="m-0">Packing Item</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Menu</a></li>
                        <li class="breadcrumb-item active">Packing Item</li>
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
                                                    echo $row->area;
                                                }
                                            }
                                            if ($data->locationId == "0" ){
                                                echo "-";
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if ($data->status == 0) { ?>
                                                <span class='badge badge-danger'>Pending</span>
                                            <?php } else if ($data->status == 1) { ?>
                                                <span class='badge badge-success'>Siap Produksi</span>
                                            <?php } else if ($data->status == 2) { ?>
                                                <span class='badge badge-warning'>Dalam Produksi</span>
                                            <?php } else if ($data->status == 3) { ?>
                                                <span class='badge badge-primary'>Selesai Produksi</span>
                                            <?php } ?>
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
                            <form role="form" action="<?php echo site_url('Packing/saveWipBoxCon')?>" method="post" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">
                                            Kode Box<span style="color: red">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                            <select class="form-control select2" id="boxCode" name="boxCode" required>
                                                <?php foreach ($box as $row) : ?>
                                                    <option value="<?= $row->boxCode ?>" <?= ($row->boxCode == set_value('boxCode') ? 'selected' : '') ?>>
                                                        <?= $row->boxCode ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Tanggal Produksi<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" id="productionDate" name="productionDate" required></input>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Cavity<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="cavity" name="cavity" required></input>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Kode Item<span style="color: red">*</span></th>
                                                    <th style="width: 100px;">Jumlah<span style="color: red">*</span></th>
                                                    <th>Hapus</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBody">
                                                <tr>
                                                    <td>
                                                        <select class="form-control select2" name="itemCode[]">
                                                            <?php foreach ($item as $row) : ?>
                                                                <option value="<?= $row->itemCode ?>" <?= ($row->itemCode == set_value('itemCode') ? 'selected' : '') ?>>
                                                                    <?= $row->itemName ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                    <td style="width: 100px;"><input type="number" name="quantity[]" class="form-control" required min="1"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fas fa-trash" style="color:white"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary" id="addRow">Tambah Item</button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" id="submit" class="btn btn-primary shadow-sm">Simpan</button>
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
                                            <input type="text" class="form-control" id="boxCodeD" name="boxCodeD" disabled></input>
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
                                                        <select class="form-control" name="itemCodeD[]">
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
                placeholder: "Pilih Data",
                allowClear: true,
                dropdownParent: $("#addModal")
            });

            // Simpan opsi itemCode ke dalam variabel agar dapat digunakan saat menambah baris baru
            var itemOptions = `<?php foreach ($item as $row) : ?>
                <option value="<?= $row->itemCode ?>"><?= $row->itemCode ?></option>
            <?php endforeach; ?>`;

            // Tambah baris baru
            $("#addRow").click(function () {
                var newRow = `<tr>
                    <td>
                        <select class="form-control select2" name="itemCode[]">
                            ${itemOptions}
                        </select>
                    </td>
                    <td><input type="number" name="quantity[]" class="form-control" required min="1"></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fas fa-trash" style="color:white"></i></button></td>
                </tr>`;

                $("#tableBody").append(newRow);
                
                // Inisialisasi Select2 pada elemen baru
                $(".select2").select2({
                    theme: 'bootstrap4',
                    placeholder: "Pilih Data",
                    allowClear: true,
                    dropdownParent: $("#addModal")
                });
            });

            // Hapus baris tertentu
            $("#tableBody").on("click", ".removeRow", function () {
                $(this).closest("tr").remove();
            });

            $("#submit").click(function(event) {
                let isValid = true;
                let boxCode = $("#boxCode").val();
                console.log(boxCode);

                // Cek apakah Kode Box sudah dipilih
                if (!boxCode) {
                    Swal.fire({
                        icon: "warning",
                        title: "Peringatan!",
                        text: "Harap isi semua data terlebih dahulu.",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                    isValid = false;
                }

                // Cek apakah semua Kode Item telah dipilih
                $("select[name='itemCode[]']").each(function() {
                    console.log($(this).val());
                    if ($(this).val() === null) {
                        Swal.fire({
                            icon: "warning",
                            title: "Peringatan!",
                            text: "Harap isi semua data terlebih dahulu.",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "OK"
                        });
                        isValid = false;
                        return false; // Keluar dari loop
                    }
                });

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
                        var itemName = items.find(item => item.itemCode === detail.itemCode)?.itemName || detail.itemCode;
                        var row = `<tr>
                            <td><span>${itemName}</span></td>
                            <td><span>${detail.quantity}</span></td>
                        </tr>`;

                        $('#itemTable tbody').append(row);
                    }
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