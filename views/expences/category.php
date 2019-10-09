
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
         Expense Categories

      </h1>
      <ol class="breadcrumb">
        <li><a href="< ?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Expense Category List</li>
      </ol>
    </section> -->

     <div style="padding: 10px">

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
              Expense Category
              </span>
              
          </h3>
            <a href="#" class="btn pull-right" data-toggle="modal" data-target="#myModal" style="background-color: #428bca; color: white"><i class="fa fa-plus"></i></a>
          </div>


<form role="form" action="<?php echo base_url('expences/createExpencesCategory') ?>" method="post" id="createForm">
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Create new category</h3>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Category Name</label>
              <input type="text" name="name" class="form-control"  placeholder="Enter Category">
            </div>
            <!-- <div class="form-group">
              <label for="exampleInputEmail1">Type</label>
              <select name="type" class="form-control">
                <option value="income">Income</option>
                <option value="exp">Expense</option>
              </select>
            </div>   -->
            <div class="form-group">
              <label for="exampleInputEmail1">Status</label>
              <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-success"> Save</button>
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
                      <th>Name</th>
                      <!-- <th>Type</th> -->
                      <th>Status</th>
                      <!-- < ?php if(in_array('updateCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?> -->
                        <th>Action</th>
                      <!-- < ?php endif; ?> -->

                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($allData as $rows): ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo ucwords($rows->name); ?></td>
                        <!-- <td>< ?php echo ucwords($rows->type); ?></td> -->
                        <td>
                          <label class="label <?php echo $rows->status == 'active' ? 'label-success' : 'label-danger' ?>"><?php echo ucwords($rows->status) ?></label>
                        </td>

                      <!-- < ?php if(in_array('updateCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?> -->

                        <td width="170px">

                          <!-- < ?php if(in_array('updateCategory', $user_permission)): ?> -->
                            <a href="javascript:void(0);" class="btn btn-sm btn-info editData" data-id="<?php echo $rows->id ?>" data-name="<?php echo $rows->name ?>" data-active="<?php echo $rows->status ?>" ><i class="fa fa-pencil"></i> </a>
                          <!-- < ?php endif; ?> -->

                          <!-- < ?php if(in_array('deleteCategory', $user_permission)): ?> -->
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger deleteData" data-id="<?php echo $rows->id ?>"><i class="fa fa-trash"></i> </a>
                          <!-- < ?php endif; ?> -->

                        </td>
                          <!-- < ?php endif; ?> -->
                        
                      </tr>
                    <?php $no++; endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
 
<form role="form" action="<?php echo base_url('expences/updateExpencesCategory') ?>" method="post">
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title"><i class="fa fa-edit"></i> Edit Categories</h3>
        </div>
        <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Category Name</label>
                  <input type="text" name="edit_expname" class="form-control"  placeholder="Enter Category">
                  <input type="hidden" name="edit_expid" class="form-control"  placeholder="Enter Category">
                </div>
               <!--  <div class="form-group">
                  <label for="exampleInputEmail1">Type</label>
                  <select name="edit_exptype" class="form-control">
                    <option value="income">Income</option>
                    <option value="exp">Expense</option>
                  </select>
                </div>   -->
                <div class="form-group">
                  <label for="exampleInputEmail1">Status</label>
                  <select name="edit_expstatus" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
              </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success"> Save</button>

        </div>
      </div>
    </div>
  </div>
</form>

<form role="form" action="<?php echo base_url('expences/deleteExpencesCategory') ?>" method="post" id="deleteForm">
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



          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- <div class="control-sidebar-bg"></div> -->

<!-- </div> -->

<script type="text/javascript">
    $('.editData').on('click', function(){

      var id = $(this).data('id');
      var name = $(this).data('name');
      var active = $(this).data('active');
      // alert(id);
      $('#myModal1').modal('show');
      $('[name="edit_expid"]').val(id);
      $('[name="edit_expname"]').val(name);
      $('[name="edit_expstatus"]').val(active);
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