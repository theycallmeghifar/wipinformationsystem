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
                    <h1 class="m-0">Production Box</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Menu</a></li>
                        <li class="breadcrumb-item active">Production Box</li>
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
                            <button type="button" id="btnTambah" style="margin-top: 10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addData">Add Data</button>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="display nowrap table-striped table" style="width:100%" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Box Code</th>
                                        <th>Item Type</th>
                                        <th>Quantity</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
                                        <td><?php echo $data->productionBoxId?></td>
                                        <td><?php echo $data->boxCode?></td>
                                        <td><?php echo $data->itemTypeCount?></td>
                                        <td><?php echo $data->totalQuantity?></td>
                                        <td><?php echo $data->location?></td>
                                        <td><?php if ($data->status == 0) {
                                            echo "Finish";
                                            } else if ($data->status == 1) { 
                                                echo "Ready";
                                            } else {
                                                echo "Pending";
                                            }
                                            ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="fa fa-pencil-square-o color-muted editbtn" title="Ubah Data" style="margin-left: 15px;"></a>
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
                <div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="addData" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form role="form" action="<?php echo site_url('ProductionBox/saveProductionBoxCon')?>" method="post" autocomplete="off">
                                <div class="modal-body" style="width: 410px;">
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Box Code<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <select class="form-control" name="boxCode" id="boxCode" required>
                                                    <option disabled selected>Select Box</option>
                                                    <?php
                                                    foreach ($box as $row) : 
                                                    ?>
                                                        <option
                                                        value="<?= $row->boxCode ?>" 
                                                        <?= ($row->boxCode == set_value('boxCode') ? 'selected' : '') ?>
                                                        >
                                                        <?= $row->boxCode ?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <table id="itemTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Item Code<span style="color: red">*</span></th>
                                                    <th>Quantity<span style="color: red">*</span></th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-control" name="itemCode[]" id="itemCode[]">
                                                            <option disabled selected>Select Item</option>
                                                            <?php
                                                            foreach ($item as $row) : 
                                                            ?>
                                                                <option
                                                                value="<?= $row->itemCode ?>" 
                                                                <?= ($row->itemCode == set_value('itemCode') ? 'selected' : '') ?>
                                                                >
                                                                <?= $row->itemCode ?>
                                                                </option>
                                                            <?php
                                                            endforeach;
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="itemQuantity[]" class="form-control" required min="1"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fas fa-trash" style="color:white"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary" id="addRow">Add Item</button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button ID="submit" name="submit" class="btn btn-primary shadow-sm" Text="Create">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- end TAMBAH DATA-->
<!-- UBAH DATA -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form role="form" action="<?php echo site_url('ProductionBox/updateProductionBoxCon')?>" method="post" autocomplete="off">
                                <div class="modal-body" style="width: 410px;">
                                    <input type="text" id="productionBoxIdU" name="productionBoxIdU" class="form-control form-control-user" required hidden="true"></input>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Box Code<span style="color: red">*</span></label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <select class="form-control" name="boxCodeU" id="boxCodeU" required>
                                                    <option disabled selected>Select Box</option>
                                                    <?php foreach ($box as $row) : ?>
                                                        <option value="<?= $row->boxCode ?>"  <?= ($row->boxCode == set_value('boxCode') ? 'selected' : '') ?> >
                                                            <?= $row->boxCode ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <table id="itemTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Item Code<span style="color: red">*</span></th>
                                                    <th>Quantity<span style="color: red">*</span></th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary" id="addRow">Add Item</button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button ID="submit" name="submit" class="btn btn-primary shadow-sm" Text="Create">Edit</button>
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
                            <form role="form" action="<?php echo site_url('ProductionBox/updateProductionBoxCon')?>" method="post" autocomplete="off">
                                <div class="modal-body" style="width: 410px;">
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">ID</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="text" id="productionBoxIdD" name="productionBoxIdD" class="form-control form-control-user" required disabled></input>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-5 col-form-label text-label">Box Code</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <select class="form-control" name="boxCodeD" id="boxCodeD" required  disabled>
                                                    <option disabled selected>Select Box</option>
                                                    <?php foreach ($box as $row) : ?>
                                                        <option value="<?= $row->boxCode ?>"  <?= ($row->boxCode == set_value('boxCode') ? 'selected' : '') ?> >
                                                            <?= $row->boxCode ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <table id="itemTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Item Code</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
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
            //edit button script
            $('.editbtn').on('click', function(){
                $('#editModal').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function(){
                    return $(this).text();
                }).get();

                $('#productionBoxIdU').val(data[0]);
                $('#boxCodeU').val(data[1]);

                var productionBoxId = data[0];

                $('#itemTable tbody').empty();

                var details = <?php echo json_encode($detailProductionBox); ?>;
                var items = <?php echo json_encode($item); ?>;

                details.forEach(function(detail) {
                    if (productionBoxId == detail.productionBoxId) {
                        var row = `<tr>
                                    <td>
                                        <select class="form-control" name="itemCodeU[]" required>`;
                        items.forEach(function(item) {
                            var selected = (item.itemCode == detail.itemCode) ? 'selected' : '';
                            row += `<option value="${item.itemCode}" ${selected}>${item.itemName}</option>`;
                        });
                        row += `</select>
                                </td>
                                <td><input type="number" name="itemQuantityU[]" class="form-control" required min="1" value="${detail.itemQuantity}"></td>
                                <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fas fa-trash" style="color:white"></i></button></td>
                            </tr>`;

                        $('#itemTable tbody').append(row);
                    }
                });

                $('#editModal').modal('show');
            });

            //detail button script
            $('.detailbtn').on('click', function(){
                $('#detailModal').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function(){
                    return $(this).text();
                }).get();

                $('#productionBoxIdD').val(data[0]);
                $('#boxCodeD').val(data[1]);

                var productionBoxId = data[0];

                $('#itemTable tbody').empty();

                var details = <?php echo json_encode($detailProductionBox); ?>;
                var items = <?php echo json_encode($item); ?>;

                details.forEach(function(detail) {
                    if (productionBoxId == detail.productionBoxId) {
                        var row = `<tr>
                                    <td>
                                        <select class="form-control" name="itemCodeD[]" required disabled>`;
                        items.forEach(function(item) {
                            var selected = (item.itemCode == detail.itemCode) ? 'selected' : '';
                            row += `<option value="${item.itemCode}" ${selected}>${item.itemName}</option>`;
                        });
                        row += `</select>
                                </td>
                                <td><input type="number" name="itemQuantityD[]" class="form-control" required disabled min="1" value="${detail.itemQuantity}"></td>
                            </tr>`;

                        $('#itemTable tbody').append(row);
                    }
                });

                $('#detailModal').modal('show');
            });

            // add row form
            $(document).on('click', '#addRow', function () {
                const activeModal = $(this).closest('.modal'); // Cari modal aktif
                const tableBody = activeModal.find('table tbody'); // Cari tbody di dalam modal aktif
                const newRow = `
                    <tr>
                        <td>
                            <select class="form-control" name="itemCode[]" id="itemCode[]">
                                <option disabled selected>Select Item</option>
                                <?php
                                foreach ($item as $row) : 
                                ?>
                                    <option
                                    value="<?= $row->itemCode ?>" 
                                    <?= ($row->itemCode == set_value('itemCode') ? 'selected' : '') ?>
                                    >
                                    <?= $row->itemCode ?>
                                    </option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </td>
                        <td><input type="number" name="itemQuantity[]" class="form-control" required min="1"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fas fa-trash" style="color:white"></i></button></td>
                    </tr>
                `;
                tableBody.append(newRow);
            });

            // delete row form
            $(document).on('click', '.removeRow', function () {
                $(this).closest('tr').remove();
            });

            // Reset modal while closed
            $('.modal').on('hidden.bs.modal', function () {
                const tableBody = $(this).find('table tbody');
                tableBody.html(`
                    <tr>
                        <td>
                            <select class="form-control" name="itemCode[]" id="itemCode[]">
                                <option disabled selected>Select Item</option>
                                <?php
                                foreach ($item as $row) : 
                                ?>
                                    <option
                                    value="<?= $row->itemCode ?>" 
                                    <?= ($row->itemCode == set_value('itemCode') ? 'selected' : '') ?>
                                    >
                                    <?= $row->itemCode ?>
                                    </option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </td>
                        <td><input type="number" name="itemQuantity[]" class="form-control" required min="1"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fas fa-trash" style="color:white"></i></button></td>
                    </tr>
                `);
            });

            //form submit
            $("form").submit(function (e) {
                if ($("#boxCode").val() === null && $("#boxCodeU").val() === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please select the box first!',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        inputField.val('').focus();
                    });
                    e.preventDefault();
                    return false;
                }

                let isValid = true;
                $("select[name='itemCode[]']").each(function () {
                    if ($(this).val() === null) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please select the item first!',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            inputField.val('').focus();
                        });
                        isValid = false;
                        e.preventDefault();
                        return false;
                    }
                });

                $("select[name='itemCodeU[]']").each(function () {
                    if ($(this).val() === null) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please select the item first!',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            inputField.val('').focus();
                        });
                        isValid = false;
                        e.preventDefault();
                        return false;
                    }
                });

                if (!isValid) return false;
            });
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