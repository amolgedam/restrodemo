<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

<!-- < ?php echo "<pre>"; print_r($ordersData); echo "</pre>"; exit(); ?> -->

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
      Manage
      <small>Orders</small>
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

                <?php echo validation_errors(); ?>
          
        <?php endif; ?>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">


        

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Add Order</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php echo base_url('orders/create') ?>" method="post" class="form-horizontal">
              <div class="box-body">


               <!--  <div class="form-group">
                  <label for="gross_amount" class="col-sm-12 control-label">Date: < ?php echo date('Y-m-d') ?></label>
                </div>
                <div class="form-group">
                  <label for="gross_amount" class="col-sm-12 control-label">Date: < ?php echo date('h:i a') ?></label>
                </div> -->

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <div>
                    <label>Table</label>
                    <input type="hidden" name="table_name" id="table_name" value="<?php echo $id; ?>">
                    <input type="hidden" name="tran_name" id="tran_name" value="<?php echo $tran_type; ?>">
                      
                      <input type="text" name="table_name_display"  readonly id="table_name_display" value="<?php echo ucwords($name); ?>" class="form-control">
                  </div>
                </div>

              

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <div >
                    <label>Invoice No.</label>
                    <div class="col-sm-7">
                      <input type="text" name="invoice"  readonly class="form-control">
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-xs-12 pull pull-left">
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Waiter Name</label>
                    <div class="col-sm-7">
                      <select class="form-control" id="showWaiter" name="showWaiter">
                      </select>
                      
                      <!--<select class="form-control select_group" id="showWaiter" name="showWaiter">-->
                      <!--</select>-->
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-xs-12 pull pull-left">
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Payment-Type</label>
                    <div class="col-sm-7">
                      <select class="form-control" id="showPaymentor" name="showPaymentor">
                      </select>
                      
                      <!--<select class="form-control select_group" id="showPaymentor" name="showPaymentor">-->
                      <!--</select>-->
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-xs-12 pull pull-left">
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Sales Type</label>
                    <div class="col-sm-7">
                      <select class="form-control" id="showSalesType" name="showSalesType">
                      </select>
                      
                      <!--<select class="form-control select_group" id="showSalesType" name="showSalesType">-->
                      <!--</select>-->
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-xs-12 pull pull-left">
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Bill Date</label>
                    <div class="col-sm-7">
                      <input type="text" name="date_time" value="<?php  echo $date;?>" id="datepicker" class="form-control">
                    </div>
                  </div>
                </div>
                
                
                <br /> <br/>
                <div class="col-md-12">
                    <div class="table-responsive">
                <table class="table table-bordered" id="product_info_table">
                  <thead>
                    <tr>
                      <th style="min-width:150px;">Product</th>
                      <th style="min-width:80px;">Qty</th>
                      <th style="min-width:100px;">Unit</th>
                      <th style="min-width:80px;">GST(%)</th>
                      <th style="min-width:80px;">HSN</th>
                      <th style="min-width:150px;">Rate</th>
                      <th style="min-width:170px;">Amount</th>
                      <th style="min-width:50px;"><button type="button" id="add_row" class="btn btn-danger"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>

                   <tbody>
                     <tr id="row_1">
                       <td>
                          <input type="hidden" name="product_id[]" id="pid_1" class="form-control" required >
                        <input list="test_1" class="form-control" data-row-id="row_1" id="product_1"  name="product[]" style="width:100%;" onchange="getProductData(1)" autofocus required>
                            <datalist id="test_1" >
                            <option value=""></option>
                            <?php foreach ($products as $k => $v): ?>
                              <option value="<?php echo $v['name'] ?>"><?php echo $v['name'] ?></option>
                            <?php endforeach ?>
                          </datalist>
                      </td>

                      <td><input type="text" name="qty[]" id="qty_1" class="form-control" required onkeyup="getTotal(1)"></td>

                      <td>
                       <input type="text" name="unit[]" id="unit_1" class="form-control" disabled autocomplete="off">
                        <input type="hidden" name="unit_value[]" id="unit_value_1" class="form-control" autocomplete="off">
                      </td>


                      <td>
                          <input type="text" name="gst[]" id="gst_1" class="form-control" disabled autocomplete="off">
                          <input type="hidden" name="gst_value[]" id="gst_value_1" class="form-control" autocomplete="off">

                          <input type="hidden" name="total_gst_rate_value[]" id="total_gst_rate_value_1" class="form-control" autocomplete="off">
                          <!-- set gst rate -->
                          <input type="hidden" name="gstrate_amount[]" id="gstrate_amount_value_1" class="gstrate_amount_value_1 form-control">
                      </td>

                      <td>
                       <input type="text" name="hsn[]" id="hsn_1" class="form-control" disabled autocomplete="off">
                        <input type="hidden" name="hsn_value[]" id="hsn_value_1" class="form-control" autocomplete="off">
                      </td>

                      <td>
                        <input type="text" name="rate[]" id="rate_1" class="form-control" disabled autocomplete="off">
                        <input type="hidden" name="rate_value[]" id="rate_value_1" class="form-control" autocomplete="off">
                      </td>
                      <td>
                        <input type="text" name="amount[]" id="amount_1" class="form-control" disabled autocomplete="off">
                        <input type="hidden" name="amount_value[]" id="amount_value_1" class="form-control" autocomplete="off">
                      </td>
                      <td>
                        <button type="button" class="btn btn-default" onclick="removeRow('1')"><i class="fa fa-close"></i></button>
                      </td>
                    </tr>
                   </tbody>
                
            </table>
          </div>
                </div>
               

                <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                    </div>
                  </div>
                  <?php if($is_service_enabled == true): ?>
                  <div class="form-group">
                    <label for="service_charge" class="col-sm-5 control-label">S-Charge <?php echo $company_data['service_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="service_charge" name="service_charge" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value" autocomplete="off">
                    </div>
                  </div>
                  <?php endif; ?>
                  <?php //if($is_vat_enabled == true): ?>
                  <div class="form-group">
                    <label for="gst_amount" class="col-sm-5 control-label">Gst Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="gst_amount" name="gst_amount" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="gst_amount_value" name="gst_amount_value" autocomplete="off">
                    </div>
                  </div>
                  <?php //endif; ?>
                  <div class="form-group">
                    <label for="discount" class="col-sm-5 control-label">Discount (in %)</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" onkeyup="subAmount()" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="net_amount" name="net_amount" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" autocomplete="off">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="paid_status" class="col-sm-5 control-label">Paid Status</label>
                    <div class="col-sm-7">
                      <select type="text" class="form-control" id="paid_status" name="paid_status">
                        <option value="2">Unpaid</option>
                        <option value="1">Paid</option>
                      </select>
                    </div>
                  </div>

                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <div align="right">
                    <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                    <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
                    <button type="submit" class="btn btn-primary">Create Order</button>
                    <a href="<?php echo base_url('orders/') ?>" class="btn btn-warning">Back</a>
                </div>
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
<!-- /.content-wrapper -->


<?php if(in_array('deleteOrder', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Order</h4>
      </div>

      <form role="form" action="<?php echo base_url('orders/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>



<form>
    <div class="modal fade" id="Modal_viewOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
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

                  <br /> <br/> <br>
                <table class="table table-bordered" id="product_info_table">
                  <thead>
                    <tr>
                      <th style="width:35%">Product</th>
                      <th style="width:15%">Qty</th>
                      <th style="width:15%">CGST(%)</th>
                      <th style="width:15%">SGST(%)</th>
                      <th style="width:20%">Rate</th>
                      <th style="width:20%">Amount</th>
                    </tr>
                  </thead>  

                   <tbody id="orderData">
                     
                   </tbody>
                
                </table>


                <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="gross_amount">
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
                      <input type="text" class="form-control" name="totalgst">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="discount" class="col-sm-5 control-label">Discount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="discount">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="net_amount">
                    </div>
                  </div>

                </div>

              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    </form>

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#OrderMainNav").addClass('active');
    $("#createOrderSubMenu").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
  
    // Add new row in the table 
    $("#add_row").unbind('click').bind('click', function() {
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;

      $.ajax({
          url: base_url + '/orders/getTableProductRow/',
          type: 'post',
          dataType: 'json',
          success:function(response) {

            showSgst();
            showCgst();
            
              // console.log(reponse.x);
               var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+ 
                        '<input type="hidden" name="product_id[]" id="pid_'+row_id+'" class="form-control">'+
                         '<input list="test'+row_id+'" class="form-control" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getProductData('+row_id+')">'+
                        '<datalist id="test'+row_id+'">'
                            '<option value=""></option>';
                            $.each(response, function(index, value) {
                              html += '<option value="'+value.name+'">'+value.name+'</option>';             
                            });
                            
                          html +='</datalist>'+
                    '</td>'+ 

                    '<td><input type="text" name="qty[]" id="qty_'+row_id+'" class="form-control" onkeyup="getTotal('+row_id+')"></td>'+

                    '<td><input type="text" name="unit[]" id="unit_'+row_id+'" class="form-control" disabled><input type="hidden" name="unit_value[]" id="unit_value_'+row_id+'" class="form-control"></td>'+

                    '<td><input type="text" name="gst[]" id="gst_'+row_id+'" class="form-control" disabled><input type="hidden" name="gst_value[]" id="gst_value_'+row_id+'" class="form-control"><input type="hidden" name="total_gst_rate_value[]" id="total_gst_rate_value_'+row_id+'" class="form-control" autocomplete="off">'+
                      '<input type="hidden" name="gstrate_amount[]" id="gstrate_amount_value_'+row_id+'" class="gstrate_amount_value_'+row_id+' form-control">'+
                    '</td>'+

                    '<td><input type="text" name="hsn[]" id="hsn_'+row_id+'" class="form-control" disabled><input type="hidden" name="hsn_value[]" id="hsn_value_'+row_id+'" class="form-control"></td>'+

                    '<td><input type="text" name="rate[]" id="rate_'+row_id+'" class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_'+row_id+'" class="form-control">'+

                    '<td><input type="text" name="amount[]" id="amount_'+row_id+'" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_'+row_id+'" class="form-control"></td>'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';

                if(count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);  
              }
              else {
                $("#product_info_table tbody").html(html);
              }

              $(".product").select2();

          }
        });

      return false;
    });

  }); // /document

  function getTotal(row = null) {
    if(row) {
      var total = Number($("#rate_value_"+row).val()) * Number($("#qty_"+row).val());


	   var gst_value = $('#gst_value_'+row).val();
	  var gsttot=((total * gst_value)/100);
      total = total.toFixed(2);
      $("#amount_"+row).val(total);
      $("#amount_value_"+row).val(total);
      $("#total_gst_rate_value_"+row).val(gsttot);
      $("#gstrate_amount_value_"+row).val(gsttot);
          
      subAmount();

    } else {
      alert('no row !! please refresh the page');
    }
  }

  // get the product information from the server
  function getProductData(row_id)
  {
    var product_name = $("#product_"+row_id).val();    
    if(product_name == "") {

      $("#rate_"+row_id).val("");
      $("#gst_"+row_id).val("");
      $("#hsn_"+row_id).val("");
      $("#unit_"+row_id).val("");
      $("#rate_value_"+row_id).val("");

      $("#qty_"+row_id).val("");           

      $("#amount_"+row_id).val("");
      $("#amount_value_"+row_id).val("");
      $("#total_gst_rate_value_"+row_id).val("");
    } else {
      $.ajax({
        url: base_url + 'orders/getProductValueById',
        type: 'post',
        data: {product_name : product_name},
        dataType:'json',
        success:function(response) {
          // setting the rate value into the rate input field
        //   console.log(response);
            $('#pid_'+row_id).val(response.sr_no);
          $("#unit_"+row_id).val(response.name);
          $("#unit_value_"+row_id).val(response.name);

          $("#gst_"+row_id).val(response.total_gst);
          $("#gst_value_"+row_id).val(response.total_gst);
          
          $("#hsn_"+row_id).val(response.hsn);
          $("#hsn_value_"+row_id).val(response.hsn);

          $("#rate_"+row_id).val(response.price);
          $("#rate_value_"+row_id).val(response.price);
      
          $("#qty_"+row_id).val(1);
          $("#qty_value_"+row_id).val(1);
       
          var total = Number(response.price) * 1;
          total = total.toFixed(2);
      
           var gst_value = $('#gst_value_'+row_id).val();
     
          var gstTotal_value = ((total * gst_value)/100);

          $("#gstrate_amount_value_"+row_id).val(gstTotal_value);

          // console.log(gstTotal_value);
      
     // alert(gstTotal_value);
          // var sgstTotal_value = ((total * cgst_value)/100);
          // var gstTotal_value =cgstTotal_value+sgstTotal_value;
          
          // $("#cgst_rate_value_"+row_id).val(cgstTotal_value);
          // $("#sgst_rate_value_"+row_id).val(sgstTotal_value);
          $("#total_gst_rate_value_"+row_id).val(gstTotal_value);
          
          $("#amount_"+row_id).val(total);
      
          $("#amount_value_"+row_id).val(total);
          
          subAmount();
        } // /success
      }); // /ajax function to fetch the product data 
    }
  }

  // calculate the total amount of the order
  function subAmount() {
    var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value']:0; ?>;
    var vat_charge = <?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value']:0; ?>;

    var tableProductLength = $("#product_info_table tbody tr").length;
    var totalSubAmount = 0;
    var totaltaxAmount=0;

    for(x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);

      totalSubAmount = Number(totalSubAmount) + Number($("#amount_"+count).val());

      // my gst cal
      totaltaxAmount=totaltaxAmount + Number($("#gstrate_amount_value_"+count).val());
    
     // totaltaxAmount=Number(totaltaxAmount) + Number($("#total_gst_rate_value_"+count).val());
    } // /for

//alert(totaltaxAmount);
    totalSubAmount = totalSubAmount.toFixed(2);

    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

  
    totaltaxAmount = totaltaxAmount.toFixed(2);
    $("#gst_amount").val(totaltaxAmount);
    $("#gst_amount_value").val(totaltaxAmount);
    // console.log(totaltaxAmount);

    // my gst code
    // $("#gsttaxamount").val(totaltaxAmount);


    // service
    var service = (Number($("#gross_amount").val())/100) * service_charge;
    service = service.toFixed(2);
    $("#service_charge").val(service);
    $("#service_charge_value").val(service);
    
    // total amount
    var totalAmount = (Number(totalSubAmount) + Number(totaltaxAmount) + Number(service));
    totalAmount = totalAmount.toFixed(2);
    // $("#net_amount").val(totalAmount);
    // $("#totalAmountValue").val(totalAmount);

    var discountPer = $("#discount").val();

    var discount = ((totalAmount * discountPer) / 100);

    console.log(discount);

    if(discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);

      // console.log(grandTotal);

      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);

    } else {
      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);
      
    } // /else discount 

  } // /sub total amount

  function removeRow(tr_id)
  {
    $("#product_info_table tbody tr#row_"+tr_id).remove();
    subAmount();
  }
</script>

<!-- my code -->
<script type="text/javascript">

    function setCgst(row_id)
    {
        var cgst = $("#product_"+cgst_1).val();
        // alert(cgst);
    }
    
    var base_url = "<?php echo base_url(); ?>";
    showWaiter();
    showPaymentor();
    showSalesType();
    showSgst();
    showCgst();

    // showOrders();

    function showWaiter()
    {
        $.ajax({
            type  : 'ajax',
            url   : base_url + '/waiter/fecthActiveWaiterData/',
            async : false,
            dataType : 'json',
            success : function(data){
                
                $.each(data, function(i, data) {
                    $('#showWaiter').append("<option value='" + data.id + "'>" + data.name + "</option>");
                });
            }
        });
    }

    function showPaymentor()
    {
        $.ajax({
            type  : 'ajax',
            url   : base_url + '/paymentor/fecthActivePaymentorData/',
            async : false,
            dataType : 'json',
            success : function(data){
                
              // console.log(data);//alert(data);

                $.each(data, function(i, data) {
                    $('#showPaymentor').append("<option value='" + data.id + "'>" + data.name + "</option>");
                });
            }
        });
    }

    function showSalesType()
    {
        $.ajax({
            type  : 'ajax',
            url   : base_url + '/sales_type/fecthActiveSalesTypeData/',
            async : false,
            dataType : 'json',
            success : function(data){
                
              // console.log(data);//alert(data);

                $.each(data, function(i, data) {
                    $('#showSalesType').append("<option value='" + data.id + "'>" + data.name + "</option>");
                });
            }
        });
    }

    function showSgst()
    {
        $.ajax({
            type  : 'ajax',
            url   : base_url + '/gst/fecthSgstData/',
            async : false,
            dataType : 'json',
            success : function(data){
                
                $.each(data, function(i, data) {
                    $('.showSgst').append("<option value='" + data.sgst + "'>" + data.sgst + "</option>");
                });
            }
        });
    }

    function showCgst()
    {
        $.ajax({
            type  : 'ajax',
            url   : base_url + '/gst/fecthCgstData/',
            async : false,
            dataType : 'json',
            success : function(data){
                
                $.each(data, function(i, data) {
                    $('.showCgst').append("<option value='" + data.cgst + "'>" + data.cgst + "</option>");
                });
            }
        });
    }

    // function showOrders()
    // {
    //     $.ajax({

    //         type  : 'ajax',
    //         url   : base_url + '/orders/getAllOrderData/',
    //         async : false,
    //         dataType : 'json',
    //         success : function(data){
    //           console.log(data);//alert(data);
    //             var html = '';
    //             var i;
    //             for(i=0; i<data.length; i++){

    //                 html += '<tr>'+
    //                           '<td>'+data[i].bill_no+'</td>'+
    //                           '<td>'+data[i].product_name+'</td>'+
    //                           '<td>'+data[i].date_time+'</td>'+
    //                           '<td>'+data[i].gross_amount+'</td>'+
    //                           '<td>'+ (data[i].paid_status == 1) ? + ' Paid '+ : + 'Unpaid' +'</td>'+
    //                           '<td style="text-align:right;">'+
    //                               '<a href="javascript:void(0);" class="btn btn-info btn-sm item_edit" data-product_code="'+data[i].product_code+'" data-product_name="'+data[i].product_name+'" data-price="'+data[i].product_price+'">Edit</a>'+' '+
    //                               '<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-product_code="'+data[i].product_code+'">Delete</a>'+
    //                           '</td>'+
    //                         '</tr>';
    //             }
    //             $('#show_orderData').html(html);
    //         }

    //     });
    // }

</script>

<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

  $("#OrderMainNav").addClass('active');
  $("#manageOrderSubMenu").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'orders/fetchOrdersData',
    'order': []
  });

});

// remove functions 
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { order_id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}


// remove functions 
function viewFunc(id)
{
  if(id) {
    // alert(id);
     // var id = id;
      $.ajax({
        url: base_url + 'orders/displayData' ,
        type: 'POST',
        async : false,
        data: { order_id:id }, 
        dataType: 'json',
        success:function(data) {

          $('[name="table_name"]').val(data[0]['table_name']);
          $('[name="showWaiter"]').val(data[0]['waiter_name']);
          $('[name="showPaymentor"]').val(data[0]['paymentor_name']);
          $('[name="showSalesType"]').val(data[0]['sales_type_name']);


          $('[name="gross_amount"]').val(data[0]['gross_amount']);
          $('[name="net_amount"]').val(data[0]['net_amount']);
          $('[name="totalgst"]').val(data[0]['totalgst']);
          $('[name="discount"]').val(data[0]['discount']);


          var html = '';
          var i;
          for(i = 0; i<data[1].length; i++)
          {
            html += '<tr>'+
                        '<td>'+ 
                            '<input type="text" name="product" class="form-control" value="'+data[1][i]['name']+'" readonly>'+
                        '</td>'+
                        '<td>'+ 
                            '<input type="number" name="qty" class="form-control" value="'+data[1][i]['qty']+'" readonly>'+
                        '</td>'+
                        '<td>'+ 
                            '<input type="text" name="cgst" class="form-control" value="'+data[1][i]['cgst']+'" readonly>'+
                        '</td>'+
                        '<td>'+ 
                            '<input type="text" name="sgst" class="form-control" value="'+data[1][i]['sgst']+'" readonly>'+
                        '</td>'+
                        '<td>'+ 
                            '<input type="text" name="rate" class="form-control" value="'+data[1][i]['rate']+'" readonly>'+
                        '</td>'+
                        '<td>'+ 
                            '<input type="text" name="amount" class="form-control" value="'+data[1][i]['amount']+'" readonly>'+
                        '</td>'+
                    '</tr>';
          }
          $('#orderData').html(html);

          $('#Modal_viewOrder').modal('show');
         // console.log(data);
        }
      }); 

      return false;
  }
}


</script>