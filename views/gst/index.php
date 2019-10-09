<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        Manage
        <small>GST</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">GST</li>
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
              <h3 class="box-title">
                <span style="padding-left: 0px; font-size: 28px"><i class="fa fa-address-book" aria-hidden="true"></i>
                 GST
                </span>
                
            </h3>
                <button class="btn pull-right" data-toggle="modal" data-target="#addGstModal" style="background-color: #428bca; color: white"><i class="fa fa-plus"></i></button>
                  <!-- <a href="< ?php echo base_url('products/create') ?>" class="btn btn-primary pull-right"> Add New</a> -->
            </div>
            <!-- <div class="box-header">
              <h3 class="box-title">Manage GST</h3>
            </div> -->

            <!-- /.box-header -->
            <div class="box-body" style="margin-top: 15px">
                <div class="table-responsive">
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr style="background-color: #428bca; color: white">
                  <th>Sr. No.</th>
                  <th>Name</th>
                  <!-- <th>HSN/SAC</th> -->
                  <th>SGST</th>
                  <th>CGST</th>
                  <th>IGST</th>
                  <th>Total GST</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                  <?php $no=1; foreach($allData as $rows): ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo ucwords($rows->name); ?></td>
                      <!-- <td>< ?php echo $rows->hsn; ?></td> -->
                      <td><?php echo $rows->sgst; ?></td>
                      <td><?php echo $rows->cgst; ?></td>
                      <td><?php echo $rows->igst; ?></td>
                      <td><?php echo $rows->total_gst; ?></td>
                      <td>
                        <a href="javascript:void(0);" class="btn btn-sm btn-info gst_edit" data-gst_id="<?php echo $rows->gst_id ?>" data-gst_name="<?php echo $rows->name ?>" data-hsn="<?php echo $rows->hsn ?>" data-sgst="<?php echo $rows->sgst ?>" data-cgst="<?php echo $rows->cgst ?>" data-igst="<?php echo $rows->igst ?>" ><i class="fa fa-pencil"></i></a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger gstDelete" data-gst_id="<?php echo $rows->gst_id ?>"><i class="fa fa-trash"></i></a>
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
  <form role="form" action="<?php echo base_url('gst/create') ?>" method="post" id="createForm">
      <div class="modal fade" id="addGstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLabel">
               <i class="fa fa-plus-square"></i> Add GST</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <!-- <form role="form" action="< ?php echo base_url('tables/create') ?>" method="post" id="createForm"> -->

              <div class="modal-body">

                <div class="form-group">
                  <label for="brand_name">Name</label>
                  <input type="text" class="form-control" id="gst_name" name="gst_name" placeholder="Enter GST name" autocomplete="off" required="">
                </div>
                <div class="form-group" style="display: none">
                  <label for="brand_name">HSN/SAC</label>
                  <input type="text" class="form-control" id="hsn" name="hsn" placeholder="Enter HSN name" autocomplete="off" required="" value="0">
                </div>
                <div class="form-group">
                  <label for="brand_name">SGST</label>
                  <input type="text" class="form-control" id="sgst" name="sgst" placeholder="Enter SGST" autocomplete="off" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                </div>
                <div class="form-group">
                  <label for="active">CGST</label>
                 <input type="text" class="form-control" id="cgst" name="cgst" placeholder="Enter CGST" autocomplete="off" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                </div>
                <div class="form-group">
                  <label for="active">IGST</label>
                  <input type="text" class="form-control" id="igst" name="igst" placeholder="Enter IGST" autocomplete="off" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
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
  <form role="form" action="<?php echo base_url('gst/updateGst') ?>" method="post" id="editForm">
      <div class="modal fade" id="editGstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Update GST</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
              <div class="modal-body">
                <input type="hidden" id="gst_id_edit" name="gst_id_edit" >

                <div class="form-group">
                  <label for="brand_name">Name</label>
                  <input type="text" class="form-control" id="gst_name_edit" name="gst_name_edit" placeholder="Enter GST name" autocomplete="off" required="">
                </div>
                <div class="form-group" style="display: none;">
                  <label for="brand_name">HSN</label>
                  <input type="text" class="form-control" id="hsn_name_edit" name="hsn_name_edit" placeholder="Enter GST name" autocomplete="off" required="" value="0">
                </div>
                
                <div class="form-group">
                  <label for="brand_name">SGST</label>
                  <input type="text" class="form-control" id="sgst_edit" name="sgst_edit" placeholder="Enter SGST" autocomplete="off" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                </div>
                <div class="form-group">
                  <label for="active">CGST</label>
                 <input type="text" class="form-control" id="cgst_edit" name="cgst_edit" placeholder="Enter CGST" autocomplete="off" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                </div>
                <div class="form-group">
                  <label for="active">IGST</label>
                  <input type="text" class="form-control" id="igst_edit" name="igst_edit" placeholder="Enter IGST" autocomplete="off" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
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
  <form role="form" action="<?php echo base_url('gst/deleteGst') ?>" method="post" id="deleteForm">
      <div class="modal fade" id="deleteGstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-trash"></i> Delete Record</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
              <div class="modal-body">
                <input type="hidden" id="gst_id_edit" name="gst_id_edit" >

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
    $('.gst_edit').on('click', function(){

        var gst_id = $(this).data('gst_id');
        var gst_name = $(this).data('gst_name');
        var hsn = $(this).data('hsn');
        var sgst = $(this).data('sgst');
        var cgst = $(this).data('cgst');
        var igst = $(this).data('igst');
        // alert(hsn);
        // alert(gst_id);
        $('#editGstModal').modal('show');
        $('[name="gst_id_edit"]').val(gst_id);
        $('[name="gst_name_edit"]').val(gst_name);
        $('[name="hsn_name_edit"]').val(hsn);
        $('[name="sgst_edit"]').val(sgst);
        $('[name="cgst_edit"]').val(cgst);
        $('[name="igst_edit"]').val(igst);
    });

    $('.gstDelete').on('click', function(){

        var gst_id = $(this).data('gst_id');
         $('#deleteGstModal').modal('show');
        $('[name="gst_id_edit"]').val(gst_id);
    });

    $(document).ready(function() {
      $('#example').DataTable( {
      } );
  });
</script>