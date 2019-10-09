<!-- < ?php echo "<pre>"; print_r($data); echo "</pre>";echo "<pre>"; print_r($productData); echo "</pre>"; exit(); ?> -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Orders
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Orders</li>
    </ol>
  </section>

   <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

       

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Your Orders</h3>
          </div>
          <div class="box-body">
            <div class="col-md-12 col-xs-12 pull pull-left">
                <div class="table-responsive">
                <table class="table table-bordered" id="product_info_table">
                  <thead>
                    <tr>
                      <th style="width:15%">Product</th>
                      <th style="width:15%">Qty</th>
                      <th style="width:10%">Unit</th>
                      <th style="width:10%">GST(%)</th>
                      <th style="width:20%">HSN</th>
                      <th style="width:15%">Rate</th>
                      <th style="width:15%">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($productData as $rows): ?>
                      <tr>
                        <td><?php echo $rows->name; ?></td>
                        <td><?php echo $rows->qty; ?></td>
                        <td><?php echo $rows->unit; ?></td>
                        <td><?php echo $rows->gst; ?></td>
                        <td><?php echo $rows->hsn; ?></td>
                        <td><?php echo $rows->rate; ?></td>
                        <td><?php echo $rows->amount; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                </div>
                <div class="col-md-6 col-xs-12 pull pull-right">
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" value="<?php echo $data['gross_amount'] ?>" name="gross_amount" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="gst_amount" class="col-sm-5 control-label">Gst Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" value="<?php echo $data['gst'] ?>" name="totalgst" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="discount" class="col-sm-5 control-label">Discount (in %)</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" value="<?php echo $data['discount'] ?>" name="discount" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" value="<?php echo $data['net_amount'] ?>" name="net_amount" readonly>
                    </div>
                  </div>
                </div>
                            
            </div>
          </div>

          <div class="box-footer">

            <a href="<?php echo base_url() ?>orders/updateOrderFromDashboard?id=<?php echo $order_id ?>" class="btn btn-sm btn-success">Edit Invoice</a>

            <?php if($data['paid_status'] == 1){ ?>
              <a href="<?php echo base_url() ?>orders/printDiv/<?php echo $order_id ?>" class="btn btn-sm btn-success" target="__blank">Print Invoice</a>
            <?php } ?>

            <!--< ?php if($data['paid_status'] != 1){ ?>-->
              <a href="<?php echo base_url() ?>orders/printKot/<?php echo $order_id ?>" class="btn btn-sm btn-success" target="__blank">Print KOT</a>
            <!--< ?php } ?>-->

            <a href="<?php echo base_url() ?>dashboard" class="btn btn-sm btn-danger">Back </a>
               
          </div>

          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
