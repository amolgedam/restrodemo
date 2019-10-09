<!--< ?php echo "<pre>"; print_r($order_data); echo "</pre>"; exit; ?>-->

<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage orders
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
            <h3 class="box-title">Edit Order</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php echo base_url(); ?>orders/update/<?php echo $id; ?>" method="post" class="form-horizontal">
		  
          <?php //echo form_open('orders/create'); ?>

              <div class="box-body">


                <div class="form-group">
                    <?php 
                            // date_default_timezone_set('Asia/Kolkata');
                            // echo $date = date('d-m-Y', $order_data['order']['created']);
                    ?>
                  <label for="date" class="col-sm-12 control-label">Date: <?php  echo $order_data['order']['created']; ?></label>
                </div>
                <!--<div class="form-group">-->
                <!--  <label for="time" class="col-sm-12 control-label">Date: < ?php echo date('h:i a') ?></label>-->
                <!--</div>-->

                <div class="col-md-6 col-xs-12 pull pull-left">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Tables</label>
                    <div class="col-sm-7">

                      <input type="hidden" name="table_name" id="table_name" value="<?php echo $tableDetails['id']; ?>">
                      <input type="text" readonly name="table_name_display" id="table_name_display" value="<?php echo ucwords($tableDetails['table_name']); ?>" class="form-control">

                      <!-- <select class="form-control" id="table_name" name="table_name">
                        < ?php if($order_data['order_table']['id']): ?>
                          <option value="< ?php echo $order_data['order_table']['id']; ?>" < ?php if($order_data['order_table']['id'] == $order_data['order']['table_id']) { echo "selected='selected'"; } ?> >< ?php echo $order_data['order_table']['table_name']; ?></option>
                        < ?php endif; ?>

                        < ?php foreach ($table_data as $key => $value): ?>
                          <option value="< ?php echo $value['id'] ?>" < ?php if($order_data['order']['table_id'] == $value['id']) { echo 'selected="selected"'; } ?> >< ?php echo $value['table_name'] ?></option>  
                        < ?php endforeach; ?>
                        
                      </select> -->
                    </div>
                  </div>                  
                </div>

                <!-- <div class="col-sm-5">
                  <div class="form-group">
                    <label for="customer" class="col-sm-4 control-label" style="text-align:left;">Customer Name</label>
                    <div class="col-sm-7">
                      <input type="text" name="customer" class="form-control">
                    </div>
                  </div>
                </div> -->
                
                <br /> <br/><br>
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
                    <?php if(isset($order_data['order_item'])): ?>
                      <?php $x = 1; ?>
                      <?php foreach ($order_data['order_item'] as $key => $val): ?>
                        <?php //print_r($v); exit; ?>
                       <tr id="row_<?php echo $x; ?>">
                        <td>
                            <input type="hidden" name="product_id[]" id="pid_1" class="form-control" value="<?php echo $val['product_id'];  ?>" required >
                          <input list="test_<?php echo $x; ?>" class="form-control" data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>"  name="product[]" style="width:100%;" value="<?php echo $val['name'];  ?>" onchange="getProductData(<?php echo $x; ?>)" required>
                            <datalist id="test_<?php echo $x; ?>" >
                            <option value=""></option>
                            <?php foreach ($products as $rows): ?>
                              <option value="<?php echo $rows['name'] ?>"><?php echo $rows['name'] ?></option>
                            <?php endforeach ?>
                          </datalist>
                      </td>
                        </td>
                        <td><input type="text" name="qty[]" id="qty_<?php echo $x; ?>" class="form-control" required onkeyup="getTotal(<?php echo $x; ?>)" value="<?php echo $val['qty'] ?>" autocomplete="off" readonly=""></td>
                       <td>
                       <input type="text" name="unit[]" id="unit_1" value="<?php echo $val['unit'] ?>"  class="form-control" disabled autocomplete="off">
                        <input type="hidden" name="unit_value[]" id="unit_value_1"value="<?php echo $val['unit'] ?>"  class="form-control" autocomplete="off">
                       </td>
                        <td>
                          <input type="text" name="gst[]" id="gst_1" value="<?php echo $val['gst'] ?>" class="form-control" disabled autocomplete="off">
                          <input type="hidden" name="gst_value[]" id="gst_value_1" value="<?php echo $val['gst'] ?>" class="form-control" autocomplete="off">

                          <input type="hidden" name="total_gst_rate_value[]" id="total_gst_rate_value_1" class="form-control" autocomplete="off">
                      </td>
                      <td>
                       <input type="text" name="hsn[]" id="hsn_1" value="<?php echo $val['hsn'] ?>" class="form-control" disabled autocomplete="off">
                        <input type="hidden" name="hsn_value[]" value="<?php echo $val['hsn'] ?>" id="hsn_value_1" class="form-control" autocomplete="off">
                      </td>
                          <td>
                            <input type="text" name="rate[]" id="rate_<?php echo $x; ?>" class="form-control" disabled value="<?php echo $val['rate'] ?>" autocomplete="off">
                            <input type="hidden" name="rate_value[]" id="rate_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['rate'] ?>" autocomplete="off">
                          </td>
                          <td>
                            <input type="text" name="amount[]" id="amount_<?php echo $x; ?>" class="form-control" disabled value="<?php echo $val['amount'] ?>" autocomplete="off">
                            <input type="hidden" name="amount_value[]" id="amount_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['amount'] ?>" autocomplete="off">

                            <input type="hidden" name="kot[]" id="kot_<?php echo $x; ?>" value="<?php echo $val['kot_status'] ?>">
                          </td>
                          <td><button type="button" class="btn btn-default" onclick="removeRow('<?php echo $x; ?>')"><i class="fa fa-close"></i></button></td>
                       </tr>
                       <?php $x++; ?>
                     <?php endforeach; ?>
                   <?php endif; ?>
                   </tbody>
                </table>
                </div>

                <br /> <br/>

                <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="gross_amount" value="<?php echo $order_data['order']['gross_amount']; ?>"  name="gross_amount" disabled autocomplete="off">
                      <input type="hidden" class="form-control" value="<?php echo $order_data['order']['gross_amount']; ?>" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                    </div>
                  </div>
                  <?php if($is_service_enabled == true): ?>
                  <div class="form-group">
                    <label for="service_charge" class="col-sm-5 control-label">S-Charge <?php echo $company_data['service_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" value="<?php echo $order_data['order']['service_charge_amount']; ?>" id="service_charge" name="service_charge" disabled autocomplete="off">
                      <input type="hidden" class="form-control" value="<?php echo $order_data['order']['service_charge_amount']; ?>"  id="service_charge_value" name="service_charge_value" autocomplete="off">
                    </div>
                  </div>
                  <?php endif; ?>
                  <?php //if($is_vat_enabled == true): ?>
                  <div class="form-group">
                    <label for="gst_amount" class="col-sm-5 control-label">Gst Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" value="<?php echo $order_data['order']['totalgst']; ?>"  id="gst_amount" name="gst_amount" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="gst_amount_value"   name="gst_amount_value" autocomplete="off">
                    </div>
                  </div>
                  <?php //endif; ?>
                  <div class="form-group">
                    <label for="discount" class="col-sm-5 control-label">Discount (in %)</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="discount" value="<?php echo $order_data['order']['discount']; ?>" name="discount" placeholder="Discount" onkeyup="subAmount()" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" value="<?php echo $order_data['order']['net_amount']; ?>"  id="net_amount" name="net_amount" disabled autocomplete="off">
                      <input type="hidden" value="<?php echo $order_data['order']['net_amount']; ?>"  class="form-control" id="net_amount_value" name="net_amount_value" autocomplete="off">
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

             

                <!--<a target="__blank" href="< ?php echo base_url() . 'orders/printDiv/'.$order_data['order']['id'] ?>" class="btn btn-default" >Print</a>-->
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('orders/') ?>" class="btn btn-success">Back</a>
              </div>
            </form>
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
                    '<input list="test_'+row_id+'" class="form-control" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getProductData('+row_id+')">'+
                    '<datalist id="test_'+row_id+'">'+
                        '<option value=""></option>';
                        $.each(response, function(index, value) {
                          html += '<option value="'+value.name+'">'+value.name+'</option>';             
                        });
                        
                      html += '</datalist>'+
                    '</td>'+ 

                    '<td><input type="text" name="qty[]" id="qty_'+row_id+'" class="form-control" onkeyup="getTotal('+row_id+')"></td>'+

                    '<td><input type="text" name="unit[]" id="unit_'+row_id+'" class="form-control" disabled><input type="hidden" name="unit_value[]" id="unit_value_'+row_id+'" class="form-control"></td>'+

                    '<td><input type="text" name="gst[]" id="gst_'+row_id+'" class="form-control" disabled><input type="hidden" name="gst_value[]" id="gst_value_'+row_id+'" class="form-control"><input type="hidden" name="total_gst_rate_value[]" id="total_gst_rate_value_'+row_id+'" class="form-control" autocomplete="off"></td>'+

                    '<td><input type="text" name="hsn[]" id="hsn_'+row_id+'" class="form-control" disabled><input type="hidden" name="hsn_value[]" id="hsn_value_'+row_id+'" class="form-control"></td>'+

                    '<td><input type="text" name="rate[]" id="rate_'+row_id+'" class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_'+row_id+'" class="form-control">'+

                    '<td><input type="text" name="amount[]" id="amount_'+row_id+'" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_'+row_id+'" class="form-control"></td>'+

                    '<input type="hidden" name="kot[]" id="kot_'+row_id+'" value="1">'+


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
	  var gsttot=0;
      total = total.toFixed(2);
      $("#amount_"+row).val(total);
      $("#amount_value_"+row).val(total);
      $("#total_gst_rate_value_"+row).val(gsttot);
          
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

    } else {
      $.ajax({
        url: base_url + 'orders/getProductValueById',
        type: 'post',
        data: {product_name : product_name},
        dataType:'json',
        success:function(response) {
          // setting the rate value into the rate input field
          console.log(response);

            $("#pid_"+row_id).val(response.sr_no);
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
      
           //var gst_value = $('#gst_value_'+row_id).val();
          // var total_amt=Number(response.price)*
          // var sgst_value = $('#sgst_value_'+row_id).val();
     
           //var gstTotal_value = ((total * gst_value)/100);
      
          // var sgstTotal_value = ((total * cgst_value)/100);
          // var gstTotal_value =cgstTotal_value+sgstTotal_value;
          
          // $("#cgst_rate_value_"+row_id).val(cgstTotal_value);
          // $("#sgst_rate_value_"+row_id).val(sgstTotal_value);
          //$("#total_gst_rate_value_"+row_id).val(gstTotal_value);
          
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
    
      //totaltaxAmount=Number(totaltaxAmount) + $("#total_gst_rate_value_"+count).val();
      
     // alert(totaltaxAmount);
    } 

    totalSubAmount = totalSubAmount.toFixed(2);

    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

  
    totaltaxAmount = totaltaxAmount.toFixed(2);
    
    //alert(totaltaxAmount);
    $("#gst_amount").val(totaltaxAmount);
    $("#gst_amount_value").val(totaltaxAmount);

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

    
    
    if(discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);

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

    showOrders();

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
         console.log(data);
        }
      }); 

      return false;
  }
}


</script>