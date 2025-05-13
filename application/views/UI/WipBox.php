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
                    <h1 class="m-0">Wip Box</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Menu</a></li>
                        <li class="breadcrumb-item active">Wip Box</li>
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
                            <button type="button" id="btnTambah" style="margin-top: 10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal">Packing</button>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" data-order='[[12, "desc"]]' class="display nowrap table-striped table" style="width:100%" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kode Box</th>
                                        <th>Nomor Proses</th>
                                        <th>Tanggal Produksi</th>
                                        <th>Item</th>
                                        <th>Cavity</th>
                                        <th>Jumlah</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        <th hidden="true">Location Id</th>
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
                                        <td><?php echo $data->processNumber?></td>
                                        <td><?php echo date('d/m/Y', strtotime($data->productionDate)); ?></td>
                                        <td>
                                            <?php foreach ($item as $row) {
                                                if ($data->itemCode == $row->itemCode) {
                                                    echo $row->itemName;
                                                }
                                            } ?>
                                        </td>
                                        <td><?php echo $data->cavity?></td>
                                        <td><?php echo $data->quantity?></td>
                                        <td>
                                            <?php 
                                                foreach ($location as $row) {
                                                    if ($data->locationId == $row->locationId) {
                                                        echo $row->area . ' ' . $row->line;
                                                        if ($row->number != 0) {
                                                            echo ' No.' . $row->number;
                                                        }
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($data->status == 1) { ?>
                                                <span class='badge badge-success'>Siap Produksi</span>
                                            <?php } else if ($data->status == 2) { ?>
                                                <span class='badge badge-warning'>Dalam Produksi</span>
                                            <?php } else if ($data->status == 3) { ?>
                                                <span class='badge badge-primary'>Selesai Produksi</span>
                                            <?php } else if ($data->status == 4) { ?>
                                                <span class='badge badge-danger'>Pending</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="fa fa-tasks color-muted detailbtn" title="Detail Data" style="margin-left: 15px;"></a>
                                        </td>
                                        <td hidden="true"><?php echo $data->locationId?></td>
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
                                <h5 class="modal-title">Packing</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="addForm" role="form" action="<?php echo site_url('WipBox/saveWipBoxCon')?>" method="post" autocomplete="off">
                                <div class="modal-body" style="width:700px">
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
                                        <label class="col-sm-5 col-form-label text-label">Nomor Proses<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="number" class="form-control" id="processNumber" name="processNumber" required>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Tanggal Produksi<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" id="productionDate" name="productionDate" required>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">
                                            Item<span style="color: red">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                            <select class="form-control select2" id="itemCode" name="itemCode" required>
                                                <?php foreach ($item as $row) : ?>
                                                    <option value="<?= $row->itemCode ?>" data-capacityinbox="<?= $row->capacityInBox ?>" <?= ($row->itemCode == set_value('itemCode') ? 'selected' : '') ?>>
                                                        <?= $row->itemName ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Cavity<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="number" class="form-control" id="cavity" name="cavity" required>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Quantity<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Isi box terakhir</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="text" id="latestItem" name="latestItem" class="form-control form-control-user" placeholder="Item terakhir dalam box" disabled></input>
                                                    </div> 
                                                </div>
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
                                <h5 class="modal-title">Detail Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="width: 700px;">
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
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-5 col-form-label text-label">Nomor Proses</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" id="processNumberD" name="processNumberD" disabled>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-5 col-form-label text-label">Tanggal Produksi</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="productionDateD" name="productionDateD" disabled></input>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-5 col-form-label text-label">Item</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="itemCodeD" name="itemCodeD" disabled></input>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-5 col-form-label text-label">Cavity</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="cavityD" name="cavityD" disabled></input>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-5 col-form-label text-label">Jumlah</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="quantityD" name="quantityD" disabled></input>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-5 col-form-label text-label">Lokasi</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="locationD" name="locationD" disabled></input>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-5 col-form-label text-label">Status</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="statusD" name="statusD" disabled></input>
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
        function getLatestItemInBox(boxCode) {
            $.ajax({
                url: "<?= base_url('WipBox/getLatestItemInBoxCon') ?>",
                type: "GET",
                data: {
                    boxCode: boxCode
                },
                dataType: "json",
                success: function (data) {
                    if (data && data.itemName) {
                        $('#latestItem').val(data.itemName);
                    } else {
                        $('#latestItem').val("Box belum pernah diisi");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        $(document).ready(function(){
            // Inisialisasi Select2 pada dropdown yang sudah ada di halaman
            $(".select2").select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Data",
                allowClear: true,
                dropdownParent: $("#addModal")
            });

            $('#addModal').on('show.bs.modal', function () {
                var today = new Date();
                var day = String(today.getDate()).padStart(2, '0');
                var month = String(today.getMonth() + 1).padStart(2, '0'); // Januari adalah bulan ke-0
                var year = today.getFullYear();
                var currentDate = year + '-' + month + '-' + day;
                
                // Set nilai input productionDate
                document.getElementById('productionDate').value = currentDate;

                const boxCode = $('#boxCode').val();
                getLatestItemInBox(boxCode);

                const capacityInBox = $('#itemCode').find(':selected').data('capacityinbox');

                if (capacityInBox) {
                    quantityInput.val(capacityInBox);
                    quantityInput.attr('max', capacityInBox);
                } else {
                    quantityInput.val('');
                    quantityInput.removeAttr('max');
                }
            });

            // Simpan data box, item dan lokasi
            var boxOptions = `<?php foreach ($box as $row) : ?>
                <option value="<?= $row->boxCode ?>"><?= $row->boxCode ?></option>
            <?php endforeach; ?>`;

            var itemOptions = `<?php foreach ($item as $row) : ?>
                <option value="<?= $row->itemCode ?>"><?= $row->itemName ?></option>
            <?php endforeach; ?>`;

            //reset modal when closed
            $('#addModal').on('hidden.bs.modal', function () {
                //reset input
                $(this).find('#processNumber').val(null);
                $(this).find('#productionDate').val(null);
                $(this).find('#cavity').val(null);
                $(this).find('#quantity').val(null);

                // Reinitialize Select2 after reset
                $(".select2").select2({
                    theme: 'bootstrap4',
                    placeholder: "Pilih Data",
                    allowClear: true,
                    dropdownParent: $("#addModal")
                });
            });

            //set quantitywith capacity
            const quantityInput = $('#quantity');

            $('#itemCode').on('change', function () {
                const capacityInBox = $(this).find(':selected').data('capacityinbox');

                if (capacityInBox) {
                    quantityInput.val(capacityInBox);
                    quantityInput.attr('max', capacityInBox);
                } else {
                    quantityInput.val('');
                    quantityInput.removeAttr('max');
                }
            });

            // Trigger sekali saat halaman dimuat
            $('#itemCode').trigger('change');

            $('#boxCode').on('change', function () {
                const boxCode = $(this).val();
                getLatestItemInBox(boxCode);
            });

            //detail button script
            const locations = <?php echo json_encode($location); ?>;

            $('.detailbtn').on('click', function () {
                $('#detailModal').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function(){
                    return $(this).text().trim();
                }).get();

                $('#wipBoxIdD').val(data[0]);
                $('#boxCodeD').val(data[1]);
                $('#processNumberD').val(data[2]);
                $('#productionDateD').val(data[3]);
                $('#itemCodeD').val(data[4]);
                $('#cavityD').val(data[5]);
                $('#quantityD').val(data[6]);

                const locationId = data[10];
                const locationObj = locations.find(loc => loc.locationId == locationId);
                const locationText = locationObj ? `${locationObj.area} ${locationObj.line}${locationObj.number != 0 ? ' No.' + locationObj.number : ''}` : '';
                $('#locationD').val(locationText);

                const statusInt = data[11];
                const statusMap = {
                    1: "Siap Produksi",
                    2: "Dalam Produksi",
                    3: "Selesai"
                };
                const status = statusMap[statusInt] || "Pending";
                $('#statusD').val(status);

            });
        });

        document.getElementById('addForm').addEventListener('submit', function(event) {
            event.preventDefault();
        
            let boxCode = document.getElementById("boxCode").value;
            let processNumber = document.getElementById("processNumber").value;
            let productionDate = parseInt(document.getElementById("productionDate").value);
            let itemCode = document.getElementById("itemCode").value;
            let cavity = document.getElementById("cavity").value;
            let quantity = parseInt(document.getElementById("quantity").value);

            if (!boxCode || !processNumber || !productionDate || !itemCode || !cavity || !quantity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Harap isi semua data dengan benar.',
                });
                return;
            }

            HTMLFormElement.prototype.submit.call(this);
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