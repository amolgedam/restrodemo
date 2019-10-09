<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <!-- <section class="content-header">
    <h1>
      Manage
      <small>Orders</small>
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
        <?php elseif($this->session->flashdata('errors')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('errors'); ?>
          </div>
        <?php endif; ?>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">


        <!--< ?php if(in_array('createOrder', $user_permission)): ?>-->
        <!--  <a href="< ?php echo base_url('orders/create') ?>" class="btn btn-primary">Add Order</a>-->
        <!--  <br /> <br />-->
        <!--< ?php endif; ?>-->

        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><span style="padding-left: 0px; font-size: 28px;"><i class="fa fa-address-book" aria-hidden="true"></i> Orders</span></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="margin-top: 15px">
              <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped">
                  <thead>
                  <tr style="background-color: #428bca; color: white">
                    <!-- <th width="7%">Sr. No.</th> -->
                    <th>Inv. No.</th>
                    <th>Date</th>
                    <th>Table/Parcel</th>
                    <th>Waiter</th>
                    <th>S.Type</th>
                    <th>Grs Amt</th>
                    <th>Discount</th>
                    <th>GST</th>
                    <th>Net Amt</th>
                    <th>P. Status</th>
                    <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                      <th width="90px">Action</th>
                    <?php endif; ?>
                  </tr>
                  </thead>
    
                </table>
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
        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-trash"></i> Delete Record</h3>
      </div>

      <form role="form" action="<?php echo base_url('orders/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p style="font-size: 16px;">Do you really want to Delete This Record?</p>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save</button>
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
                    <br><br>
                  </div>
                  <div class="col-md-6 col-xs-12 pull pull-left">
                    <div class="form-group">
                      <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Waiter Name</label>
                      <div class="col-sm-7">
                        <input type="text" name="showWaiter" class="form-control" readonly>
                      </div>
                    </div>
                    <br>
                  </div>
                  <div class="col-md-6 col-xs-12 pull pull-left">
                    <div class="form-group">
                      <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Payment-Type</label>
                      <div class="col-sm-7">
                        <input type="text" name="showPaymentor" class="form-control" readonly>
                      </div>
                    </div>
                    <br>
                  </div>
                  <div class="col-md-6 col-xs-12 pull pull-left">
                    <div class="form-group">
                      <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Sales Type</label>
                      <div class="col-sm-7">
                        <input type="text" name="showSalesType" class="form-control" readonly>
                      </div>
                    </div>
                    <br>
                  </div>
                  <div class="col-md-6 col-xs-12 pull pull-left">
                    <div class="form-group">
                      <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Bill Date</label>
                      <div class="col-sm-7">
                        <input type="text" name="billdate" id="billdate" class="form-control" readonly>
                      </div>
                    </div>
                    <br>
                  </div>

                  <br><br><br><br>
                  <div class="table table-responsive">
                    <table class="table table-bordered" id="product_info_table">
                      <thead>
                        <tr>
                          <th style="min-width:150px">Product</th>
                          <th style="min-width:80px">Qty</th>
                          <th style="min-width:100px">Unit</th>
                          <th style="min-width:80px">GST(%)</th>
                          <th style="min-width:80px">HSN</th>
                          <th style="min-width:150px">Rate</th>
                          <th style="min-width:170px">Amount</th>
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
        dataType: 'JSON',
        success:function(response) {

          // console.log(response);

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> </strong>'+response.messages+
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
            
          // console.log(data);

          $('[name="table_name"]').val(data[0]['table_name']);
          $('[name="showWaiter"]').val(data[0]['waiter_name']);
          $('[name="showPaymentor"]').val(data[0]['paymentor_name']);
          $('[name="showSalesType"]').val(data[0]['sales_type_name']);

          var date = data[0]['created'];
          var dateSplit = date.split(" ");
          var dateSplit2 = dateSplit[0].split("-");
          var formattedDate = dateSplit2.reverse().join('-');
          
          $('#billdate').val(formattedDate);

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
                            '<input type="text" name="qty" class="form-control" value="'+data[1][i]['qty']+'" readonly>'+
                        '</td>'+
                        '<td>'+ 
                            '<input type="text" name="unit" class="form-control" value="'+data[1][i]['unit']+'" readonly>'+
                        '</td>'+
                        '<td>'+ 
                            '<input type="text" name="gst" class="form-control" value="'+data[1][i]['gst']+'" readonly>'+
                        '</td>'+
                        '<td>'+ 
                            '<input type="text" name="hsn" class="form-control" value="'+data[1][i]['hsn']+'" readonly>'+
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
