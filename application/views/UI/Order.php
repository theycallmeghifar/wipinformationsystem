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
                    <h1 class="m-0">Order</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Menu</a></li>
                        <?php if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2) { ?>
                            <li class="breadcrumb-item active">Order</li>
                        <?php } ?>
                        <?php if ($this->session->userdata('role') == 3) { ?>
                            <li class="breadcrumb-item active">Order</li>
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
                            <h5 class="m-0">Order</h5>
                            <?php if ($this->session->userdata('role') == 3) { ?>
                                <button type="button" id="btnTambah1" style="margin-top: 10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal">Order</button>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Line</th>
                                        <th>Item</th>
                                        <th>Cavity</th>
                                        <th>Jumlah</th>
                                        <th style="display: none;">Int Status</th>
                                        <th style="display: none;">Created Date</th>
                                        <th style="display: none;">Modified Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data diisi oleh AJAX -->
                                </tbody>
                            </table>
                        </div>
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
                                <h5 class="modal-title">Order</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="width:700px">
                                <form id="addForm" role="form" action="<?php echo site_url('Order/saveOrderCon')?>" method="post" autocomplete="off">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Line<span style="color: red">*</span></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <select name="locationId" id="locationId" class="form-control select2" style="width: 180px;" required>
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
                                                        <select name="itemCode" id="itemCode" class="form-control select2" style="width: 180px;" required>
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
                                                <label class="col-sm-5 col-form-label text-label">Cavity</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="number" id="cavity" name="cavity" class="form-control form-control-user" placeholder="Cavity"></input>
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
                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-5 col-form-label text-label">Stok WIP</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="number" id="stock" name="stock" class="form-control form-control-user" placeholder="Stok item di area wip" disabled></input>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" id="submit" class="btn btn-primary shadow-sm">Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<!-- end TAMBAH DATA-->
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
        function fetchOrders() {
            var role = <?= json_encode($this->session->userdata('role')) ?>;
            const locations = <?php echo json_encode($location); ?>;
            const items = <?php echo json_encode($item); ?>;
            
            $.ajax({
                url: "<?= base_url('order/getAllOrderDataCon') ?>",
                type: "GET",
                dataType: "json", 
                success: function(data) {
                    let tableRows = "";
                    data.forEach(function(item) {
                        let cavity = item.cavity == 0 ? "all cavity" : item.cavity;

                        let location = locations.find(loc => loc.locationId == item.locationId);
                        let line = location ? location.line : "Unknown";

                        const found = items.find(i => i.itemCode === item.itemCode);
                        const itemName = found ? found.itemName : '';

                        tableRows += `
                            <tr>    
                                <td>${item.orderId}</td>
                                <td>${line}</td>
                                <td>${itemName}</td>
                                <td>${cavity}</td>
                                <td>${item.quantity}</td>
                                <td hidden="true">${item.status}</td>
                                <td hidden="true">${item.createdDate}</td>
                                <td hidden="true">${item.modifiedDate}</td>
                            </tr>
                        `;
                    });
                    $('#dataTable').DataTable().destroy();

                    $('#dataTable tbody').html(tableRows);

                    $('#dataTable').DataTable({
                        "order": [[6, "desc"]]
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        function getItemStockInWip(itemCode, cavity) {
            $.ajax({
                url: "<?= base_url('order/getItemStockInWipCon') ?>",
                type: "GET",
                data: {
                    itemCode: itemCode,
                    cavity: cavity
                },
                dataType: "json",
                success: function (data) {
                    console.log(data.stock);
                    $('#stock').val(data.stock ?? 0);
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        setInterval(fetchOrders, 1000);

        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [[4, "asc"]]
            });
            
            fetchOrders();

            // Inisialisasi Select2 pada dropdown yang sudah ada di halaman
            $(".select2").select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Data",
                allowClear: true,
                dropdownParent: $("#addModal")
            });

            $('#addModal').on('show.bs.modal', function () {
                const itemCode = $('#itemCode').val();
                const cavity = $('#cavity').val();
                getItemStockInWip(itemCode, cavity);
            });

            $('#addModal').on('hidden.bs.modal', function () {
                //reset input
                $(this).find('#cavity').val(null);
                $(this).find('#quantity').val(null);
                $(this).find('#stock').val(null);

                // Reinitialize Select2 after reset
                $(".select2").select2({
                    theme: 'bootstrap4',
                    placeholder: "Pilih Data",
                    allowClear: true,
                    dropdownParent: $("#addModal")
                });
            });

            $('#itemCode').on('change', function () {
                const itemCode = $(this).val();
                const cavity = $('#cavity').val();
                getItemStockInWip(itemCode, cavity);
            });

            $('#cavity').on('change', function () {
                const itemCode = $('#itemCode').val();
                const cavity = $(this).val();
                getItemStockInWip(itemCode, cavity);
            });
        });

        //addForm validation
        document.getElementById('addForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            let locationId = document.getElementById("locationId").value;
            let itemCode = document.getElementById("itemCode").value;
            let quantity = parseInt(document.getElementById("quantity").value);

            if (!locationId || !itemCode || !quantity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Harap isi semua data dengan benar.',
                });
                return;
            }

            HTMLFormElement.prototype.submit.call(this);
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