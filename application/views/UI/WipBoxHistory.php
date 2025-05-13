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
                    <h1 class="m-0">Wip Box History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Menu</a></li>
                        <li class="breadcrumb-item active">Wip Box History</li>
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
                            <form id="exportForm" target="_blank" method="post" role="form" action="<?php echo site_url('WIpBoxHistory/ExportExcelHistoryCon') ?>">
                                <button type="submit" id="btnExport" style="margin-top: 10px;" class="btn btn-success pull-right">
                                    <i style="margin-right: 8px;" class="fas fa-arrow-up"></i> Export Excel
                                </button>
                                <div class="form-row" style="margin-right: 50%;">
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label for="startDate">Tanggal Awal</label>
                                            <input type="date" name="startDate" class="form-control" id="startDate" />
                                        </div>
                                        <div class="form-group col-md-5" style="margin-left: 20px;">
                                            <label for="endDate">Tanggal Akhir</label>
                                            <input type="date" name="endDate" class="form-control" id="endDate" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" data-order='[[13, "desc"]]' class="display nowrap table-striped table" style="width:100%" >
                                <thead>
                                    <tr>
                                        <th hidden="true">History Id</th>
                                        <th hidden="true">Nomor Proses</th>
                                        <th hidden="true">Tanggal Produksi</th>
                                        <th>Kode Box</th>
                                        <th>Item</th>
                                        <th>Cavity</th>
                                        <th>Jumlah</th>
                                        <th>Lokasi Awal</th>
                                        <th>Lokasi Akhir</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                        <th hidden="true">Int Status</th>
                                        <th hidden="true">Location Id</th>
                                        <th hidden="true">Created Date</th>
                                        <th hidden="true">Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($getData as $data){ ?>
                                        <tr>
                                            <td hidden="true"><?php echo $data->historyId?></td>
                                            <td hidden="true"><?php echo $data->processNumber?></td>
                                            <td hidden="true"><?php echo date('d/m/Y', strtotime($data->productionDate)); ?></td>
                                            <td><?php echo $data->boxCode?></td>
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
                                                        if ($data->initialLocationId == $row->locationId) {
                                                            echo $row->area . ' ' . $row->line;
                                                            if ($row->number != 0) {
                                                                echo ' No.' . $row->number;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    foreach ($location as $row) {
                                                        if ($data->finalLocationId == $row->locationId) {
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
                                                <td><?php echo date('d/m/Y', strtotime($data->createdDate)); ?></td>
                                            <td>
                                                <a href="javascript:void(0);" class="fa fa-tasks color-muted detailbtn" title="Detail Data" style="margin-left: 15px;"></a>
                                            </td>
                                            <td hidden="true"><?php echo $data->locationId?></td>
                                            <td hidden="true"><?php echo $data->status?></td>
                                            <td hidden="true"><?php echo $data->createdDate?></td>
                                            <td hidden="true"><?php echo $data->createdBy?></td>
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
                                        <input type="text" class="form-control" id="historyIdD" name="historyIdD" disabled></input>
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
                                        <input type="text" class="form-control" id="itemD" name="itemD" disabled></input>
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
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-5 col-form-label text-label">Tanggal</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="dateD" name="dateD" disabled></input>
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
    </section>
</div>
<?php
$data = ob_get_clean();
?>
<?php ob_start();?>
<!-- SCRIPT -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<script>
    const locations = <?php echo json_encode($location); ?>;
    const items = <?php echo json_encode($item); ?>;

    $(document).ready(function(){
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // Januari adalah bulan ke-0
        var year = today.getFullYear();
        var currentDate = year + '-' + month + '-' + day;
        document.getElementById('startDate').value = currentDate;
        document.getElementById('endDate').value = currentDate;

        function getWipBoxHistoryByDate(startDate, endDate) {
            $.ajax({
                url: "<?= base_url('wipBoxHistory/getWipBoxHistoryByDateCon') ?>",
                type: "GET",
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                dataType: "json",
                success: function (data) {
                    let tableRows = "";

                    data.forEach(function(item) {
                        const itemName = getItemName(item.itemCode);
                        const initialLocation = getLocationName(item.initialLocationId);
                        const finalLocation = getLocationName(item.finalLocationId);
                        const statusBadge = getStatusBadge(item.status);
                        const createdDateFormatted = formatDate(item.createdDate);
                        const productionDateFormatted = formatDate(item.productionDate);

                        tableRows += `
                            <tr>
                                <td hidden="true">${item.historyId}</td>
                                <td hidden="true">${item.processNumber}</td>
                                <td hidden="true">${productionDateFormatted}</td>
                                <td>${item.boxCode}</td>
                                <td>${itemName}</td>
                                <td>${item.cavity}</td>
                                <td>${item.quantity}</td>
                                <td>${initialLocation}</td>
                                <td>${finalLocation}</td>
                                <td>${statusBadge}</td>
                                <td>${createdDateFormatted}</td>
                                <td>
                                    <a href="javascript:void(0);" class="fa fa-tasks color-muted detailbtn" title="Detail Data" style="margin-left: 15px;"></a>
                                </td>
                                <td hidden="true">${item.initialLocationId}</td>
                                <td hidden="true">${item.status}</td>
                                <td hidden="true">${item.createdDate}</td>
                                <td hidden="true">${item.createdBy}</td>
                            </tr>
                        `;
                    });

                    $('#dataTable').DataTable().destroy();

                    $('#dataTable tbody').html(tableRows);

                    $('#dataTable').DataTable({
                        "order": [[13, "desc"]]
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error: ", error);
                }
            });
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function getItemName(itemCode) {
            const found = items.find(i => i.itemCode === itemCode);
            return found ? found.itemName : '';
        }

        function getLocationName(locationId) {
            const found = locations.find(l => l.locationId === locationId);
            if (!found) return '';
            let name = `${found.area} ${found.line}`;
            if (found.number != 0) {
                name += ` No.${found.number}`;
            }
            return name;
        }

        function getStatusBadge(status) {
            const statusInt = parseInt(status); // konversi ke integer
            switch (statusInt) {
                case 1: return "<span class='badge badge-success'>Siap Produksi</span>";
                case 2: return "<span class='badge badge-warning'>Dalam Produksi</span>";
                case 3: return "<span class='badge badge-primary'>Selesai Produksi</span>";
                case 4: return "<span class='badge badge-danger'>Pending</span>";
                default: return "";
            }
        }

        $('#startDate, #endDate').on('change', function () {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            getWipBoxHistoryByDate(startDate, endDate);
        });

        $('.detailbtn').on('click', function () {
            $('#detailModal').modal('show');

            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function(){
                return $(this).text().trim();
            }).get();

            $('#historyIdD').val(data[0]);
            $('#boxCodeD').val(data[1]);
            $('#processNumberD').val(data[2]);
            $('#productionDateD').val(data[3]);
            $('#itemD').val(data[4]);
            $('#cavityD').val(data[5]);
            $('#quantityD').val(data[6]);
            $('#dateD').val(data[9]);
            
            const locationId = data[11];
            const locationObj = locations.find(loc => loc.locationId == locationId);
            const locationText = locationObj ? `${locationObj.area} ${locationObj.line}${locationObj.number != 0 ? ' No.' + locationObj.number : ''}` : '';
            $('#locationD').val(locationText);

            const statusInt = parseInt(data[12]);
            const statusMap = {
                1: "Siap Produksi",
                2: "Dalam Produksi",
                3: "Selesai"
            };
            const status = statusMap[statusInt] || "Pending";
            $('#statusD').val(status);
        });
    });
</script>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END SCRIPT -->
<?php
$script = ob_get_clean();
include('master_page.php');
ob_flush();
?>