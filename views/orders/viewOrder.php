<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

 <!--< ?php echo "<pre>"; print_r(productData); echo "</pre>"; exit(); ?> -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
  <?php
  
  $date=date('m/d/Y',time());
  ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      View
      <small>Orders</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View Orders</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">View Order</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php echo base_url('orders/create') ?>" method="post" class="form-horizontal">
              <div class="box-body">
                
                     <div class="row">
                          <div class="col-md-6 col-xs-12 pull pull-left">
                            <div class="form-group">
                              <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Table</label>
                              <div class="col-sm-7">
                                <input type="text" name="table_name" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-xs-12 pull pull-left">
                            <div class="form-group">
                              <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Waiter Name</label>
                              <div class="col-sm-7">
                                <input type="text" name="showWaiter" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-xs-12 pull pull-left">
                            <div class="form-group">
                              <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Payment-Type</label>
                              <div class="col-sm-7">
                                <input type="text" name="showPaymentor" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-xs-12 pull pull-left">
                            <div class="form-group">
                              <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Sales Type</label>
                              <div class="col-sm-7">
                                <input type="text" name="showSalesType" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-6 col-xs-12 pull pull-left">
                            <div class="form-group">
                              <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Bill Date</label>
                              <div class="col-sm-7">
                                <input type="date" name="billdate" class="form-control" readonly>
                              </div>
                            </div>
                            <br>
                          </div>
        
                          <br /> <br/> <br>
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
        
                           <tbody id="orderData">
                             
                           </tbody>
                        
                        </table>
                        </div>
        
        
                        <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="gross_amount" readonly>
                    </div>
                  </div>
                 <!--  <div class="form-group">
                    <label for="service_charge" class="col-sm-5 control-label">S-Charge</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="service_charge" disabled autocomplete="off">
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label for="gst_amount" class="col-sm-5 control-label">Gst Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="totalgst" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="discount" class="col-sm-5 control-label">Discount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="discount" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="net_amount" readonly>
                    </div>
                  </div>

                </div>
        
                      </div>
               
              </div>
              
               <div class="box-footer">

                
                <a href="#" class="btn btn-sm btn-success">Print Invoice</a>
                <a href="#" class="btn btn-sm btn-success">Print KOT</a>
                <a href="<?php echo base_url() ?>dashboard" class="btn btn-sm btn-success">Back to Dashboard</a>
               
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-5 -->

    </div>
    <!-- /.row -->
  
  </section>
  <!-- /.content -->
</div>
