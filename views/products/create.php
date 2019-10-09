<style type="text/css">
  .star
  {
    color: red; font-size: 15px;
  }
</style>

<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->
<?php
  // echo "<pre>"; print_r($gst); exit();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
 <!--  <section class="content-header">
    <h1>
      Manage
      <small>Products</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
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

                <?php echo validation_errors(); ?>
          
        <?php endif; ?>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">




        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <span style="padding-left: 11px; font-size: 28px"><i class="fa fa-plus-square"></i> &nbsp; Add Product</span>
            </h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body" style="margin-top: 40px">


                <!-- <div class="form-group">
                  <label for="product_image">Image</label>
                  <div class="kv-avatar">
                      <div class="file-loading">
                          <input id="product_image" name="product_image" type="file">
                      </div>
                  </div>
                </div> -->
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_name">Product Code</label>
                    <input type="text" class="form-control" id="sr_no" name="sr_no" placeholder="Enter Product Code" autocomplete="off" value="<?php echo $this->input->post('sr_no') ?>" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_name">Product name</label> <span class="star">* </span>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" autocomplete="off" value="<?php echo $this->input->post('product_name') ?>" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Price</label> <span class="star">* </span>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" autocomplete="off" value="<?php echo $this->input->post('price') ?>"/>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="category">Category</label> <span class="star">* </span>
                    <input type="hidden" name="category" id="category" class="form-control" readonly>

                    <input list="test_1" class="form-control" id="product"  name="product[]" autofocus required autocomplete="off">
                      <datalist id="test_1" >
                      <option value=""></option>
                      <?php foreach ($category as $k => $v): ?>
                        <option value="<?php echo $v['name'] ?>"><?php echo $v['name'] ?></option>
                      <?php endforeach ?>
                    </datalist>

                    <!-- <select class="form-control" id="category" name="category[]">
                      < ?php foreach ($category as $k => $v): ?>
                        <option value="< ?php echo $v['id'] ?>">< ?php echo $v['name'] ?></option>
                      < ?php endforeach ?>
                    </select> -->
                  </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="store">Store</label> <span class="star">* </span>
                      <select class="form-control" id="store" name="store[]">
                        <option value="0">Select Option</option>
                        <?php foreach ($stores as $k => $v): ?>
                          <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-4">
                     <div class="form-group">
                      <label for="sgst">Unit</label> <span class="star">* </span>
                      <select class="form-control" id="unit" name="unit" >
                        <option value="0">Select Option</option>
                        
                        <?php foreach ($unit_type as $row): ?>
                          <option value="<?php echo $row->id ?>"><?php echo $row->name ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="sgst">GST</label> <span class="star">* </span>
                      <select class="form-control" id="gst" name="gst" >
                        <?php foreach ($gst as $row): ?>
                          <option value="<?php echo $row->gst_id ?>"><?php echo $row->name ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="store">Active</label>
                      <select class="form-control" id="active" name="active">
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                      </select>
                    </div>
                </div>

                <div class="col-md-4">

                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control" name="description" placeholder="Enter 
                    description" autocomplete="off">
                    <?php echo $this->input->post('description') ?>
                    </textarea>
                  </div>
                </div>

                

                
               

                <!-- <div class="form-group">
                  <label for="sgst">HSN</label>
                  <select class="form-control select_group" id="unit" name="unit" >
                    < ?php foreach ($gst as $row): ?>
                      <option value="< ?php echo $row->hsn ?>">< ?php echo $row->hsn ?></option>
                    < ?php endforeach ?>
                  </select>
                </div> -->

                

                

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                  <div style="float: right; padding-right: 12px">

                    <a href="<?php echo base_url('products/') ?>" class="btn btn-danger">Close</a>
                    <button type="submit" class="btn btn-success">Save</button>

                  </div>
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
  $(document).ready(function() {


    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#productMainNav").addClass('active');
    $("#createProductSubMenu").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
    $("#product_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });

  });

  $('#product').on('blur', function(){

      var product_cat = $(this).val();    
      // alert(product_cat);

    var base_url = '<?php echo base_url() ?>';


      $.ajax({
        url: base_url + 'category/getDataByName',
        type: 'post',
        data: {product_cat : product_cat},
        dataType:'JSON',
        success:function(response) {
        
          // console.log(response);
          $('#category').val(response.id);
         
        } // /success
      }); // /ajax function to fetch the product data 
  });
</script>