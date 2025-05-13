<?php ob_start();?>
<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Dashboard</h1>
				</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item active">Menu</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END HEADER -->
<section class="content">
    <div class="container-fluid">	
    	<div class="col-lg-18">
			<div class="card bg-gradient">
				<div class="card-header border-0">
					<h3 class="card-title">
						<i class="nav-icon fas fa-archive"></i>
						Active Boxes
					</h3>
					<button type="button" id="finishing" name="area" value="finishing" style="margin-top: 10px;margin-left: 5px" class="btn btn-info pull-right" data-toggle="modal" data-target="#tambahData">Finishing</button>
					<button type="button" id="machining" name="area" value="finishing" style="margin-top: 10px;margin-left: 5px" class="btn btn-warning pull-right" data-toggle="modal" data-target="#tambahData">Machining</button>
					<button type="button" id="wip" name="area" value="finishing" style="margin-top: 10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#tambahData">WIP</button>
					</br>
					<p>Area: WIP</p>
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
                                        <td><?php echo $data->orderId?></td>
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
      	   	</div>
      	</div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

<?php
	$data = ob_get_clean();
	$script = ob_get_clean();
	include('master_page.php');
	ob_flush();
?>