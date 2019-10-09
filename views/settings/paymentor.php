<!--<  ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

<!-- < ?php print_r($allData); exit(); ?> -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        Manage
        <small>Payment-Term</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Payment_Term</li>
      </ol>
    </section> -->

    <div id="messages"></div>
            

            <?php echo validation_errors(); ?>  

                  <?php if(!empty($errors)) {
                    echo $errors;
                  } 
              ?>
              
          

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

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          


          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><span style="padding-left: 0px; font-size: 28px"><i class="fa fa-address-book" aria-hidden="true"></i> Payment</span></h3>

              <?php if(in_array('createStore', $user_permission)): ?>
                <button class="btn pull-right" data-toggle="modal" data-target="#addModal" style="background-color: #428bca; color: white"><i class="fa fa-plus"></i></button>
                <br /> <br />
              <?php endif; ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top: 15px">
                <div class="table-responsive">
              <table id="example"  class="table table-bordered table-striped">
                <thead>
                <tr style="background-color: #428bca; color: white">
                    <th width="9%">Sr. No.</th>
                  <th>Name</th>
                  <th>Status</th>
                  <?php if(in_array('updateStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
                  <th width="15%">Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>

                  <?php $no = 1; foreach($allData as $rows): ?>

                    <?php
                       if($rows->active == 1)
                        {
                          $label = '<label class="label label-success">Active</label>';
                        }
                        else
                        {
                          $label = '<label class="label label-danger">Inctive</label>';
                        }
                    ?>

                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo ucwords($rows->name); ?></td>
                      <td>
                          <?php echo $label; ?>
                        <!-- 
                        <a href="javascript:void(0);" data-id="< ?php echo $rows->id ?>" data-active="< ?php echo $rows->active ?>" class="status btn btn-sm < ?php echo ($rows->active == 1) ? "btn-success" : "btn-danger" ?>"> < ?php echo ($rows->active == 1) ? "Active" : "Inactive" ?></a> -->

                      </td>
                      <td>
                        <a href="javascript:void(0);" class="btn btn-sm btn-info paymentor_edit" data-id="<?php echo $rows->id ?>" data-name="<?php echo $rows->name ?>" data-active="<?php echo $rows->active ?>" ><i class="fa fa-pencil"></i></a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger paymentor_Delete" data-id="<?php echo $rows->id ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php $no++; endforeach; ?>

                </tbody>
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

<!-- MODAL Add-->
  <form role="form" action="<?php echo base_url('paymentor/create') ?>" method="post" id="createForm">
      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> Add Payment-Type</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <!-- <form role="form" action="< ?php echo base_url('tables/create') ?>" method="post" id="createForm"> -->

              <div class="modal-body">

                <div class="form-group">
                  <label for="brand_name">Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Payement Term name" autocomplete="off" required>
                </div>
               
                <div class="form-group">
                  <label for="active">Status</label>
                  <select class="form-control" id="active" name="active">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
              </div>

            <!-- </form> -->
          </div>
        </div>
      </div>
  </form>

  <!-- MODAL Edit-->
  <form role="form" action="<?php echo base_url('paymentor/updatePaymentor') ?>" method="post" id="editForm">
      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Update Payment-Type</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
              <div class="modal-body">
                <input type="hidden" id="id_edit" name="id_edit" >

                <div class="form-group">
                  <label for="brand_name">Name</label>
                  <input type="text" class="form-control" id="name_edit" name="name_edit" placeholder="Enter Payment Term name" autocomplete="off" required>
                </div>
               
                <div class="form-group">
                  <label for="active">Status</label>
                  <select class="form-control" id="active_edit" name="active_edit">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
              </div>

          </div>
        </div>
      </div>
  </form>


  <!-- MODAL Edit-->
  <form role="form" action="<?php echo base_url('paymentor/deletePaymentor') ?>" method="post" id="deleteForm">
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


  <!-- MODAL Edit-->
  <form role="form" action="<?php echo base_url('paymentor/statusWaiter') ?>" method="post" id="deleteForm">
      <div class="modal fade" id="statusWaiterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Change Active Status</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
              <div class="modal-body">
                <input type="hidden" id="id_edit" name="id_edit" >
                <input type="hidden" id="active_edit" name="active_edit" >

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



  <script type="text/javascript">
    //get data for update record
    $('.paymentor_edit').on('click', function(){

        var id = $(this).data('id');
        var name = $(this).data('name');
        var active = $(this).data('active');
        // alert(waiter_id);
        $('#editModal').modal('show');
        $('[name="id_edit"]').val(id);
        $('[name="name_edit"]').val(name);
        $('[name="active_edit"]').val(active);
    });

    $('.paymentor_Delete').on('click', function(){

        var id = $(this).data('id');
        $('#deleteWaiterModal').modal('show');
        $('[name="id_edit"]').val(id);
    });

    $('.status').on('click', function(){

        var id = $(this).data('id');
        var active = $(this).data('active');
        $('#statusWaiterModal').modal('show');
        $('[name="id_edit"]').val(id);
        $('[name="active_edit"]').val(active);
    });

     $(document).ready(function() {
      $('#example').DataTable( {
      } );
  } );
</script>