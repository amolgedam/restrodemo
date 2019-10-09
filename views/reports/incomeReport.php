<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->
<style>
          .myBorder
        {
            border : 1px solid #000;
        }
        .topBorder
        {
            border-top : 1px solid #000;
        }
        .bottomBorder
        {
            border-bottom : 1px solid #000;
        }
        .leftBorder
        {
            border-left : 1px solid #000;
        }
        .rightBorder
        {
            border-right : 1px solid #000;
        }             
  </style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  

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


        <div class="box">

          <div class="box-header">
             <h3 class="box-title"><span style="padding-left: 0px; font-size: 28px"><i class="fa fa-book" aria-hidden="true"></i> Income Report</h3>
          </div>

          <!-- /.box-header -->
          <div class="box-body">
		    <form name="search" method="POST" action="<?php echo base_url() ?>reports/incomeReport">
            <div class="box-header">
              
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
				
				
              <div class="col-md-2">
                <label>Date From</label>
                <input type="text" name="from" id="datepicker" class="form-control" value="<?= set_value('from', $date) ?>">  
              </div>
              <div class="col-md-2">
                <label>Date To</label>
                <input type="text" name="to" id="datepicker2" class="form-control" value="<?= set_value('to', $date) ?>">  
              </div>
			         
			  
              <div class="col-md-5" style="padding-top: 5px">
                <br>
                <input type="submit" name="search" value="Search" class="btn btn-md btn-success">
                &nbsp;
                <a href="javascript:void(0)" class="btn btn--md btn-warning" id="printTableData">Print</a>
                &nbsp;
                 <a href="#" class=" btn btn-info" id="btnExport" >Download</a>
              </div>
            </div>
          </form>
          
        </div>
		
              
		    
		   
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->

      <div class="box">
        <div class="box-body">

            <div class="table-responsive">
                    <?php
                        $companyDetails = $this->model_company->getCompanyData(1);

                    ?>
                    <table border="1" width="100%" id="printTable">
                        <tr>
                            <td>
                                <center>
                                    <h3><b><?php echo strtoupper($companyDetails['company_name']); ?></b></h3>
                                    <h5><?php echo ucwords($companyDetails['address']).', '.ucwords($companyDetails['city']).' '.ucwords($companyDetails['state']).' - '.ucwords($companyDetails['postal_code']); ?></h5>
                                    <?php if($companyDetails['gstin'] != ''){ ?>
                                      <h5>GST No : <?php echo ucwords($companyDetails['gstin']); ?></h5>
                                    <?php } ?>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                    <h4><b>Income Report</b></h4>
                                    <span><b>Date From </b> <?= date('d/m/Y', strtotime(set_value('from', $date))) ?> &nbsp; <b>Date To </b> <?= date('d/m/Y', strtotime(set_value('from', $date))) ?></span>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border="1" id="test_table"  width="100%">
                        <tr>
                            <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Date</span></th>
                            <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Invoice No.</span></th>
                            <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Sales Type</span></th>
                            <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Payment Type</span></th>

                            <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Gross Amt.</span></th>
                            <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">GST Amt.</span></th>
                            <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Net Amount</span></th>
                        </tr>

                        <?php $famt = 0; foreach ($salesData as $key => $value) { ?>
                            
                            <?php
                            // echo "<pre>"; print_r($value);
                                if($value['sales_type'] != 0)
                                {
                                  $salestype = $this->model_salestype->fecthDataByID($value['sales_type']);
                                  $sales = $salestype['name'];                                    
                                }
                                else
                                {
                                  $sales = "None";
                                }

                                if($value['payment_term'] != 0)
                                {
                                  $payment_term = $this->model_paymentor->fecthAllDataById($value['payment_term']);
                                  $payment = $payment_term['name'];                                    
                                }
                                else
                                {
                                  $payment = "None";
                                }

                                $famt = $famt + $value['fnetamt'];

                                if($value['ordertype'] == 'tb')
                                {
                                  $link = base_url()."order/confirmTable/".$value['id'];
                                }
                                else
                                {
                                  $link = base_url()."order/confirmParcel/".$value['id'];
                                }

                                $date = date('d-m-Y', $value['date_time']);

                            ?>
                              <tr>
                                  <td style="text-align: center;">&nbsp; <?php echo $date; ?></td>

                                  <td style="text-align: center;">&nbsp; <a href="<?php echo $link; ?>"><?php echo $value['bill_no']; ?></a></td>
                                  <td style="text-align: center;">&nbsp; <?php echo $sales; ?></td>
                                  <td style="text-align: center;">&nbsp; <?php echo $payment; ?></td>

                                  <td style="text-align: center;">&nbsp; <?php echo $value['gross_amount']; ?></td>
                                  <!-- <td>&nbsp; < ?php echo $value['discount']; ?></td> -->
                                  <td style="text-align: center;">&nbsp; <?php echo $value['totalgst']; ?></td>
                                  <td style="text-align: center;">&nbsp; <?php echo $value['fnetamt']; ?></td>
                              </tr>
                          <?php } ?>

                          <tr>
                            <td>&nbsp; </td>
                            <td>&nbsp; </td>
                            <td>&nbsp; </td>
                            <td>&nbsp; </td>
                            <td>&nbsp; </td>
                            <td style="text-align: center; font-size: 14px; font-weight: bold;">&nbsp; Total </td>
                            <td style="text-align: center; font-size: 14px; font-weight: bold;">&nbsp; <?php echo $famt; ?></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                          </tr>
                          <tr>
                              <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Date</span></th>
                              <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Exp. Name</span></th>
                              <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Exp. Category</span></th>
                              <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Employee</span></th>
                              <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Payment Type</span></th>
                              <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Paid Status</span></th>
                              <th style="font-weight: bold; text-align: center;">&nbsp; <span style="font-size: 18px">Amount</span></th>
                          </tr>

                          <?php $totExp = 0; foreach ($expData as $key => $value) { ?>
                                        
                            <?php
                                // echo "<pre>"; print_r($value);

                                $expCat = $this->model_expences->fecthCategoryDataByID($value->expcat_id);
                                $emp = $this->model_waiter->fecthAllDataById($value->users_id);

                                if($value->payment_method != 0)
                                {
                                  $payment_term = $this->model_paymentor->fecthAllDataById($value->payment_method);
                                  $payment = $payment_term['name'];                                    
                                }
                                else
                                {
                                  $payment = "None";
                                }

                                $totExp = $totExp + $value->amount;
                            ?>
                            <tr>
                                <td style="text-align: center;">&nbsp; <?php echo date('d-m-Y', strtotime($value->date)); ?></td>

                                <td style="text-align: center; ">&nbsp; <a href="<?php echo base_url() ?>expences/updateExpences/<?php echo $value->id; ?>"><?php echo $value->name; ?></a></td>
                                <td style="text-align: center; ">&nbsp; <?php echo $expCat['name']; ?></td>
                                <td style="text-align: center; ">&nbsp; <?php echo $emp['name'] == '' ? "None" : $emp['name']; ?></td>
                                <td style="text-align: center;">&nbsp; <?php echo $payment; ?></td>
                                <td style="text-align: center; ">&nbsp; <?php echo $value->pstatus == 'paid' ? "Paid" : "Unpaid"; ?></td>
                                <td style="text-align: center; ">&nbsp; <?php echo $value->amount; ?></td>

                            </tr>
                          <?php } ?>

                          <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>

                              <td style="text-align: center; font-weight: bold; font-size: 14px">&nbsp; Total</td>
                              <td style="text-align: center; font-weight: bold; font-size: 14px">&nbsp; <?php echo $totExp; ?></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                          </tr>

                          <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            
                              <td style="font-weight: bold; text-align: center; font-size: 15px;">&nbsp; Total Income </td>
                              <td style="font-weight: bold; text-align: center; font-size: 15px;">&nbsp; <?php echo $famt - $totExp; ?></td>
                          </tr>

                      </table>

                      <table border="1" width="100%">
                        <tr>
                          <td>
                              <br>
                              &nbsp;
                              <span><b>* This is a Computer Generated Document hence no Signature is Required</b></span>
                          </td>
                      </tr>
                      </table>
                            </td>
                        </tr>
                        
                    </table>
                    
                    
                </div>

        </div>
        <!-- /.box-body -->
      </div>

    </div>
    <!-- /.row -->


    

  </section>
  <!-- /.content -->
<!-- </div> -->
<!-- /.content-wrapper -->


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

showWaiter();
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

</script>
 <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


  <!-- Export to excel -->
  <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

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

<script type="text/javascript">
  function printData()
  {
     var divToPrint=document.getElementById("printTable");
     newWin= window.open("");
     newWin.document.write(divToPrint.outerHTML);
     newWin.print();
     newWin.close();
  }

  $('#printTableData').on('click',function(){
     printData();
  })

  
</script>


<script type="text/javascript">
        $(function () {
            $("#btnExport").click(function () {

                $("#test_table").table2excel({
                    filename: "Employees.xls"
                });
            });
        });
    </script>
