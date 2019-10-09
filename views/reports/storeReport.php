<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

<!-- < ?php echo "<pre>"; print_r($storeData); echo "</pre>"; exit(); ?> -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Report
      <small>- Store</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Store Report</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <!-- <div class="box">

          <form name="search" method="POST" action="< ?php echo base_url() ?>reports/waiterReportData">
            <div class="box-header">
              <div class="col-md-3">
                <label>Date From</label>
                <input type="date" name="from" class="form-control" value="< ?= set_value('from') ?>">  
              </div>
              <div class="col-md-3">
                <label>Date To</label>
                <input type="date" name="to" class="form-control" value="< ?= set_value('to') ?>">  
              </div>
              <div class="col-md-3">
                <br>
                <input type="submit" name="search" value="Search" class="btn btn-success">  
              </div>
            </div>
          </form>
          
        </div> -->

        <div class="box">
          <!-- /.box-header -->
          <div class="box-body">
              <div class="table-responsive">
            <table id="myDataTables" class="display nowrap table table-bordered table-striped">
              <thead>
              <tr>
                <th>Name</th>
                <th>Status</th>
              </tr>
              </thead>

              <?php if($storeData == NULL){ ?>
                <tr>
                  <td>Data Not Found</td>
                </tr>
              <?php } ?>

              <?php foreach($storeData as $rows): ?>
                  <tr>
                    <th><?php echo $rows->name; ?></th>
                    <th><?php echo ($rows->active == 1) ? "Active" : "Inactive"; ?></th>
                  </tr>
              <?php endforeach; ?>
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
              'csv', 'excel', 'pdf', 'print'
          ]
      } );
  } );
</script>