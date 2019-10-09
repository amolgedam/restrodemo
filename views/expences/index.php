<!--< ?php echo "<pre>"; print_r($allData); echo "</pre>"; exit(); ?>-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <!--  <section class="content-header">
      <h1>
        <i class="fa fa-gift" aria-hidden="true"></i> Expenses
      </h1>
      <ol class="breadcrumb">
        <li><a href="< ?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Expenses </li>
      </ol>
    </section> -->

    <div style="padding: 10px">
        <?php
            if($feedback = $this->session->flashdata('feedback'))
            {
                $feedback_class = $this->session->flashdata('feedback_class');
        ?>
                <div class="form-group col-12">
                    <div class="">
                        <div class="alert <?= $feedback_class?>">
                            <?= $feedback ?>
                        </div>
                    </div>
                </div>
        <?php }?>
    </div>   

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
               <h3 class="box-title">
              <span style="padding-left: 0px; font-size: 28px"><i class="fa fa-address-book" aria-hidden="true"></i>
              Expenses
              </span>
            </h3>
            <?php if(in_array('createProduct', $user_permission)): ?>
              <!-- <div class="box-header"> -->
                <a href="<?php echo base_url() ?>expences/create" class="btn pull-right" style="background-color: #428bca; color: white"><i class="fa fa-plus"></i></a>
                <!-- <a href="#" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add New</a> -->
              <!-- </div> -->
            <?php endif; ?>
          </div>

            

<form role="form" action="<?php echo base_url('expences/deleteExpences') ?>" method="post" id="deleteForm">
      <div class="modal fade" id="deleteWaiterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
             <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-trash"></i> Delete Record</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div class="modal-body">
                <input type="hidden" id="id_edit" name="id_edit" >
          <p style="font-size: 16px;">Do you really want to Delete This Record?</p>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
              </div>
          </div>
        </div>
      </div>
  </form>

              
            
            <div class="box-body" style="margin-top: 15px">
              <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped mydatatable">
                  <thead>
                    <tr style="background-color: #428bca; color: white">
                      <th>Sr.No.</th>
                      <th>Date</th>
                      <th width="130px">Exp. Name</th>
                      <th>Exp.Category</th>
                      <th>Employee</th>
                      <th>Payment</th>
                      <th>Amount</th>
                      <th width="70px">Paid Status</th>
                      <th>P. Date</th>
                      <?php if(in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                        <th width="50px">Action</th>
                      <?php endif; ?>

                    </tr>
                  </thead>
                  <tbody>

                    <?php 
                      $no=1; foreach($allData as $rows): 

                      $expCat = $this->model_expences->fecthCategoryDataByID($rows->expcat_id);
                      $empData = $this->model_waiter->fecthAllDataById($rows->users_id);
                      $paymentData = $this->model_paymentor->fecthAllDataById($rows->payment_method);

                      if($rows->pstatus == 'paid')
                      {
                        $ptype = "Paid";
                      }
                      else if($rows->pstatus == 'partial')
                      {
                        $ptype = "Partial";
                      }
                      else
                      {
                        $ptype = "Unpaid";
                      }

                        

                    ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($rows->date)); ?></td>
                        <td><?php echo $rows->name; ?></td>
                        <td><?php echo $expCat['name']; ?></td>
                        <td><?php echo $empData == '' ? "None" : $empData['name']; ?></td>
                        <td><?php echo $rows->pstatus == 'paid' ? $paymentData['name'] : "None"; ?></td>

                        <td><?php echo $rows->amount; ?></td>
                        <td><?php echo $ptype ?></td>

                        <td><?php echo $rows->pstatus == 'paid' ? date('d/m/Y', strtotime($rows->pdate)) : "None"; ?></td>

                      <?php if(in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>

                        <td>

                          <?php if(in_array('updateProduct', $user_permission)): ?>
                           <a href="<?php echo base_url() ?>expences/updateExpences/<?php echo $rows->id ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> </a>
                          <?php endif; ?>

                         <!--  <a href="javascript:void(0);" class="btn btn-sm btn-info editData" data-id="< ?php echo $rows->id ?>" data-name="< ?php echo $rows->name ?>" data-date="< ?php echo $rows->date ?>" data-description="< ?php echo $rows->description ?>" data-amount="< ?php echo $rows->amount ?>" data-pmethod="< ?php echo $rows->payment_method ?>" data-cheque_no ="< ?php echo $rows->cheque_no ?>" data-reference ="< ?php echo $rows->reference ?>" ><i class="fa fa-pencil"></i>Edit</a> -->

                          <?php if(in_array('deleteProduct', $user_permission)): ?>
                           <a href="javascript:void(0);" class="btn btn-sm btn-danger deleteData" data-id="<?php echo $rows->id ?>"><i class="fa fa-trash"></i> </a>
                          <?php endif; ?>

                        </td>
                          <?php endif; ?>
                        
                      </tr>
                    <?php $no++; endforeach; ?>

                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
 
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <!--  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer> -->

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <!-- <div class="control-sidebar-bg"></div>

</div> -->


<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  $('#accountholder').on('blur', function(){

      // alert('hi');
      var accountholderID = $(this).val();
      // alert(accountholderID);
      $.ajax({
              type : "POST",
              url  : base_url + 'banking/holderData',
              dataType : "JSON",
              data : {accountholderID:accountholderID},
              success: function(data){
                  // alert(data);
                  // console.log(data);
                  $('#account_id').val(data['id']);
                  $('#number').val(data['ac_number']);
                  $('#pre_amt').val(data['amt']);
              }
          });
  });

  $('.editData').on('click', function(){

        var id = $(this).data('id');
        var name = $(this).data('name');
        var date = $(this).data('date');
        var description = $(this).data('description');
        var amount = $(this).data('amount');
        var pmethod = $(this).data('pmethod');
        var cheque_no = $(this).data('cheque_no');
        var reference = $(this).data('reference');

        $('#myModal1').modal('show');
        // alert(status);
        $('[name="expenseid"]').val(id);
        $('[name="edit_expensename"]').val(name);
        $('[name="edit_date"]').val(date);
        $('[name="edit_description"]').val(description);
        $('[name="edit_amount"]').val(amount);
        $('[name="edit_payment_method"]').val(pmethod);
        $('[name="edit_cheque_no"]').val(cheque_no);
        $('[name="edit_reference"]').val(reference);

    });


  $('.deleteData').on('click', function(){

        var id = $(this).data('id');
        // alert(id);
        $('#deleteWaiterModal').modal('show');
        $('[name="id_edit"]').val(id);
    });

  $(document).ready(function() {
      $('#example').DataTable( {
      } );
  } );
</script>