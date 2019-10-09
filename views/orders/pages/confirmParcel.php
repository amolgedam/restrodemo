<!-- < ?php echo "<pre>"; print_r($data); //echo "</pre>";echo "<pre>"; print_r($productData); echo "</pre>"; //exit(); ?> -->



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <!-- <section class="content-header">
    <h1>
      Orders
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Orders</li>
    </ol>
  </section> -->

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

            <h3 class="box-title" style="padding-top: 6px;"><span style="padding-left: 0px; font-size: 28px;"><i class="fa fa-check-circle" aria-hidden="true"></i> View Order</h3>
          
            <div class="pull-right" style="background-color: #3C8DBC; color: white;">
              <span style="font-size: 30px; font-weight: bold; padding: 20px;"> Final Amount :- <?php echo $data['fnetamt']; ?></span>
            </div>
          </div>


          <div class="box-body">

            <div class="box-body" style="margin-top: 40px">

                <?php echo validation_errors(); ?>

                <!-- <div class="form-group">
                  <label for="product_image">Image</label>
                  <div class="kv-avatar">
                      <div class="file-loading">
                          <input id="product_image" name="product_image" type="file">
                      </div>
                  </div>
                </div> -->

                  
                  <?php

                      $table = $this->model_parcel->getTableData($data['parcel_id']);
                      $waiter = $this->model_waiter->fecthAllDataById($data['waiter']);

                  ?>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_name">Invoice No.</label>
                    <input type="hidden" class="form-control" value="<?php echo $data['id']; ?>" name="order_id" readonly />
                    <input type="hidden" class="form-control" value="<?php echo $data['ordertype']; ?>" name="tran_type" readonly />
                    <input type="text" class="form-control" value="<?php echo $data['bill_no']; ?>" name="invoice" readonly />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_name">Parcel</label>
                    <input type="hidden" class="form-control" name="table_id" value="<?php echo $table['id'] ?>" readonly=""/>
                    <input type="text" class="form-control" name="table_name" value="<?php echo "Parcel" ?>" readonly=""/>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Date Time</label>
                    <div style="margin-top: 7px">
                        <span style="font-weight: bold;">
                          <?php echo $data['created']; ?>
                      </span><br><br>
                    </div>
                  </div>
                </div>

                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Customer Name</label>
                    <input type="text" name="cname" value="<?php echo $data['customername'] ?>" class="form-control" readonly autofocus placeholder="Customer Name"/>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Mobile</label>
                    <input type="text" value="<?php echo $data['mobile'] ?>" class="form-control" name="mobile" readonly placeholder="Mobile"/>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Waiter</label>
                    <input type="hidden" name="emp" id="empid" value="<?php echo $waiter['id']; ?>" class="form-control" readonly>
                    <input type="text" name="emp" id="empname" value="<?php echo $waiter['name']; ?>" class="form-control" readonly>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Sales Type</label>
                    <select name="salestype" class="form-control" disabled>
                      <option value="0">Select Option</option>
                      <?php
                        foreach ($sales_type as $key => $value) {
                      ?>
                          <option value="<?php echo $value->id; ?>" <?php echo $data['sales_type'] == $value->id ? "selected" : ""; ?>   ><?php echo ucwords($value->name); ?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Payment Type</label>
                    <select name="paymenttype" class="form-control" disabled="">
                      <option value="0">Select Option</option>
                      <?php
                        foreach ($payment_type as $key => $value) {
                      ?>
                          <option value="<?php echo $value->id; ?>" <?php echo $data['payment_term'] == $value->id ? "selected" : ""; ?> ><?php echo ucwords($value->name); ?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Gross Amount</label>
                    <input type="text" class="form-control" id="finalgprice" name="finalgprice" placeholder="Gross Price" value="<?php echo $data['gross_amount']; ?>" autocomplete="off" readonly />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Discount</label>
                    <input type="text" class="form-control" id="finaldiscount" name="finaldiscount" placeholder="Discount"  value="<?php echo $data['discount']; ?>" autocomplete="off" readonly />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">GST</label>
                    <input type="text" class="form-control" id="finalGst" name="finalGst" placeholder="GST" autocomplete="off"  value="<?php echo $data['totalgst']; ?>" readonly="" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Adjustment</label>
                    <input type="text" class="form-control" name="adj" id="adj" placeholder="Adjustment"  value="<?php echo $data['adj']; ?>" readonly/>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Net Amount</label>
                    <input type="hidden" class="form-control" id="finalnetAmt2" name="finalnetAmtAdj" placeholder="Net Amount" autocomplete="off" readonly=""  value="<?php echo $data['net_amount']; ?>" />
                    <input type="text" class="form-control" id="finalnetAmt" name="finalnetAmt" placeholder="Net Amount" autocomplete="off" readonly=""  value="<?php echo $data['fnetamt']; ?>" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Paid Status</label>
                    <select name="billstatus" class="form-control" disabled>
                      <option value="2" <?php echo $data['paid_status'] == "2" ? "selected" : ""; ?>>Unpaid</option>
                      <option value="1" <?php echo $data['paid_status'] == "1" ? "selected" : ""; ?>>Paid</option>
                    </select>
                  </div>
                </div>

              </div>

              <br><br>
            <div class="col-md-12 col-xs-12 pull pull-left">
                <div class="table-responsive">
                <table id="product_info_table" width="100%" border="1">
                  <thead>
                    <tr>
                      <th style="width:15%; text-align: center; ">Product Name</th>
                      <th style="width:10%; text-align: center; ">Unit</th>
                      <th style="width:10%; text-align: center; ">GST</th>
                      <th style="width:7%; text-align: center; ">Quantity</th>
                      <th style="width:10%; text-align: center; ">MRP</th>
                      <th style="width:5%; text-align: center; ">Dis. %</th>
                      <th style="width:10%; text-align: center; ">Dis. Amt</th>
                      <th style="width:10%; text-align: center; ">Gross Price</th>
                      <th style="width:14%; text-align: center; ">GST Amount</th>
                      <th style="width:25%; text-align: center; ">Net Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($productData as $rows): ?>

                      <?php
                        $product = $this->model_products->getProductData($rows->product_id);

                        $unitData = $this->model_unittype->fecthAllDataByID($product['unit_id']);
                        $gstData = $this->model_gst->fecthAllDataByID($product['gst_id']);

                      ?>

                      <tr>
                        <td style="text-align: center;"><?php echo $product['name']; ?></td>
                        <td style="text-align: center;"><?php echo $unitData['name']; ?></td>
                        <td style="text-align: center;"><?php echo $gstData['name']; ?></td>
                        <td style="text-align: center;"><?php echo $rows->qty; ?></td>
                        <td style="text-align: center;"><?php echo $rows->rate; ?></td>
                        <td style="text-align: center;"><?php echo $rows->discount; ?></td>
                        <td style="text-align: center;"><?php echo $rows->discountAmt == 0 ? "0.000" : $rows->discountAmt; ?></td>
                        <td style="text-align: center;"><?php echo $rows->grossprice; ?></td>
                        <td style="text-align: center;"><?php echo $rows->gstAmt == 0 ? "0.000" : $rows->gstAmt; ?></td>
                        <td style="text-align: center;"><?php echo $rows->netAmt; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                </div>
                     
            </div>
          </div>

          <div class="box-footer" style="text-align: right; padding-right: 20px;">

            <a href="<?php echo base_url() ?>dashboard" class="btn btn-sm btn-danger">Back </a>

            <?php if($data['paid_status'] != 1){ ?>

                <a href="<?php echo base_url() ?>order/updateParcel/<?php echo $order_id ?>" class="btn btn-sm btn-success">Edit Invoice</a>
            <?php } ?>
            

            <?php if($data['paid_status'] == 1){ ?>
              <a href="<?php echo base_url() ?>orders/printDiv/<?php echo $order_id ?>" class="btn btn-sm btn-warning" target="__blank">Print Invoice</a>
            <?php } ?>

            <?php if($data['paid_status'] != 1){ ?>
              <a href="<?php echo base_url() ?>order/printKot/<?php echo $order_id ?>" class="btn btn-sm btn-warning" target="__blank">Print KOT</a>
            <?php } ?>

               
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
