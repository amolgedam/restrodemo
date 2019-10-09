<!--<  ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <!--<section class="content-header">-->
  <!--  <h1>-->
  <!--    Manage-->
  <!--    <small>Orders</small>-->
  <!--  </h1>-->
  <!--  <ol class="breadcrumb">-->
  <!--    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
  <!--    <li class="active">Orders</li>-->
  <!--  </ol>-->
  <!--</section>-->

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('errors')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('errors'); ?>
          </div>
        <?php endif; ?>

        <!--< ?php if(in_array('createOrder', $user_permission)): ?>-->
        <!--  <a href="< ?php echo base_url('orders/create') ?>" class="btn btn-primary">Add Order</a>-->
        <!--  <br /> <br />-->
        <!--< ?php endif; ?>-->

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Product Wise Report</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
		    <form name="search" method="POST" action="<?php echo base_url() ?>reports/productReportData">
            <div class="box-header">
              <!-- <div class="col-md-6 col-xs-12 pull pull-left">
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Waiter Name</label>
                    <div class="col-sm-7">
                      <select class="form-control select_group" id="showWaiter" name="showWaiter">
                      </select>
                    </div>
                  </div>
                </div> -->
			 <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
   $( function() {
    $( "#datepicker2" ).datepicker();
  } );
  </script>
  <?php
  
  $date=date('m/d/Y',time());
  ?>	
				
				
              <div class="col-md-3">
                <label>Date From</label>
                <input type="text" name="from" id="datepicker" class="form-control" value="<?= $date ?>">  
              </div>
              <div class="col-md-3">
                <label>Date To</label>
                <input type="text" name="to" id="datepicker2" class="form-control" value="<?= $date ?>">  
              </div>
			 <div class="col-md-3 ">
                  <div class="form-group">
                    <label for="gross_amount" class=" control-label" style="text-align:left;">Product Name</label>
                    
                       <select class="form-control select_group" id="showProduct" name="showProduct">
                      </select>
                    
                  </div>
                </div>
			  
              <div class="col-md-3">
                <br>
                <input type="submit" name="search" value="Search" class="btn btn-success">  
              </div>
            </div>
          </form>
          
        </div>
        
        <div style="padding:10px">
            <div class="table-responsive">
		      <table id="myDataTables" class="display nowrap table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Bill no</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($waiterData == NULL){ ?>
                        <tr>
                            <td>Data Not Found</td>
                        </tr>
                    <?php } ?>
                    
                    <?php 
        			
        				  $totalamt=0;
        				  foreach($waiterData as $rows): 
        				  $totalamt=$totalamt+$rows->net_amount;
        			?>
                        <tr>
                            <th><?php echo $rows->bill_no; ?></th>
                            <th><?php echo $rows->net_amount; ?></th>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
        		<tfoot>
        			<th>Total amount</th>
                    <th><?php echo $totalamt;  ?></th>
        		</tfoot>
            </table>
		    </div>   
		   </div>
		  
		<div style="padding:10px">
		    <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Bill No</th>
                    <th>Store</th>
                    <th>Date Time</th>
                    <th>Total Products</th>
                    <th>Total Amount</th>
                    <th>Paid status</th>
                    <!--< ?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>-->
                    <!--  <th>Action</th>-->
                    <!--< ?php endif; ?>-->
                  </tr>
                  </thead>
                </table>
            </div>
        </div>
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
                      <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Payment-Term</label>
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

showProduct();

  function showProduct()
    {
        // alert('hi');
        $.ajax({
            type  : 'ajax',
            url   : base_url + '/products/productData/',
            async : false,
            dataType : 'json',
            success : function(data){
                
                console.log(data);
                $.each(data, function(i, data) {
                    $('#showProduct').append("<option value='" + data.sr_no + "'>" + data.name + "</option>");
                });
            }
        });
    }

</script>
 <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function() {
      $('#myDataTables').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'excel', 'pdf', 'print'
          ]
      } );
  } );
</script>