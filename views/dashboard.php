<!-- < ?php echo "<pre>"; print_r($tablesData); echo "</pre>"; exit(); ?> -->
<style type="text/css">

    /*#dashboardTimer{
      display: none;
    }*/

    #responsiveDashboard{
        display: none;
      }

    @media (max-width: 1190px){

      #dashboardTimer{
        display: none;
      }
      #responsiveDashboard{
        display: block;
      }
    }
</style>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <!--  <h1>
        <i class="fa fa-user"></i> Dashboard
      </h1> -->
      <h1 class="box-title" id="dashboardTitle">
          <span style="padding-left: 0px; font-size: 28px;"><i class="fa fa-address-book" aria-hidden="true"></i>
          Dashboard
          </span>
      </h1>

      <!-- <li class="header"> -->
        
      <!-- </li> -->
      <ol class="breadcrumb" id="dashboardTimer">
        <li>

          <?php

            // Get Parent Data
            $parentData = $this->model_users->getUserData($this->session->userdata('parent_id'));

            if($this->session->userdata('parent_id') == 1)
            {
              $adminid = $this->session->userdata('id');
            }
            else
            {
              $adminid = $parentData['id'];
            }

            $adminData = $this->model_users->getUserData($adminid);

            // echo "<pre>"; print_r($adminid); 
            // echo "<pre>"; print_r($adminData);  
            // exit();

          ?>


          <span style="font-size: 16px; text-align: center;">
              <i class="fa fa-calendar"></i> Installed : <?php echo $regDat = date('d-m-Y', strtotime($adminData['validitystartdate'])) ." &nbsp;"; ?>

              <i class="fa fa-hourglass-half"></i> Expiry : <?php echo $expDate = date('d-m-Y', strtotime($adminData['validitystartdate']. '+ '.$adminData['validity'].' months') ) ." &nbsp;"; ?>
              

 <?php 

 $date1 = strtotime($adminData['validitystartdate']);
 $date2 = strtotime($adminData['validitystartdate']. '+ '.$adminData['validity'].' months');

 $cdate = strtotime(date('d-m-Y'));

 $diff = $date2 - $cdate; 
 $rdate = round($diff/86400); 

 // echo "<pre>"; print_r($adminData); //exit();

if($adminData['isSuperadmin'] != 1)
{
   if($rdate <= 0)
   {
    // echo $rdate; exit();
      // Inactive admin and child accounts
      $updateAdmin = array(
                              'id' => $adminData['id'],
                              'loginstatus' => '0'
                        );
      $this->model_users->update($updateAdmin);

      redirect('auth/logout');
   }
   // exit();
} 
 

 ?> 


              <i class="fa fa-bell"></i> Remaining Days : <?php echo $rdate ." &nbsp;"; ?>
          </span>
          &nbsp;

          <span style="font-weight: bold; font-size: 16px; text-align: center;" class="pull-right">
          <?php echo date('d F Y')." &nbsp;"; ?> <span id="myTime">
        </span>
      </span>
        </li>
      </ol>

      <div class="rows" id="responsiveDashboard">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <span style="font-size: 16px; text-align: center;">
              <i class="fa fa-calendar"></i> Installed : <?php echo $regDat = date('d-m-Y', strtotime($adminData['validitystartdate'])) ." &nbsp;"; ?>
            </span>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <span style="font-size: 16px; text-align: center;">
                <i class="fa fa-hourglass-half"></i> Expiry : <?php echo $expDate = date('d-m-Y', strtotime($adminData['validitystartdate']. '+ '.$adminData['validity'].' months') ) ." &nbsp;"; ?>
            </span>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <span style="font-size: 16px; text-align: center;">
              <i class="fa fa-bell"></i> Remaining Days : <?php echo $rdate ." &nbsp;"; ?>

            </span>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">

          <span style="font-weight: bold; font-size: 16px; text-align: center;">
           <?php echo date('d F Y')." &nbsp;"; ?> <span id="myTime">
           </span></span>
        </div>
       
      </div>
    </section>
    
  

    <!-- Main content -->
    <section class="content">
     
      
      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="container">
            <div class="row">

                <div style="text-align: center;">
                  <?php foreach($tablesData as $rows): ?>

                    <?php

                      if($rows->available == 1)
                      {

                        $path = 'orders/createFromDashboard?id='.$rows->id.'&name='.$rows->table_name.'&tran_type=tb';
                      }
                      else
                      {
                        $path = 'order/updateTableOrder/'.$rows->currentorder_id;
                      }

                    ?>

                    <a href="<?php echo base_url().$path; ?>">
                      
                    <!-- </a> -->


                  <!--   <a href="< ?php echo base_url(); ?>orders/< ?php echo ($rows->available == 1) ? 'createFromDashboard?id='.$rows->id.'&name='.$rows->table_name.'&tran_type=tb': 'updateOrderFromDashboard?id='.$rows->currentorder_id.'&table_id='.$rows->id.'&name='.$rows->table_name ?>">
                         -->
                      <div style="border: 2px solid <?php echo ($rows->available == 1) ? "green" : "red"; ?>; border-radius: 50%; width: 150px; height: 145px; float: left; margin: 10px; background-color: <?php echo ($rows->available == 1) ? "green" : "red"; ?>;">
                          
                        <div style="margin-top: 25%;">
                            <center>
                              <h2 style="color: #fff;"><center><?php echo ucwords($rows->table_name); ?></center></h2>
                              <div><center><span style="color: #fff;">Capacity : <?php echo  ucwords($rows->capacity); ?></span></center></div>
                            </center>
                        </div>
                      </div>
                    </a>
                  <?php endforeach; ?>
                </div>
              
            </div>

            <div class="row">

                <div style="text-align: center;">
                  <?php foreach($parcelData as $rows): ?>

                    <?php

                      if($rows->available == 1)
                      {

                        $path = 'order/createParcel?id='.$rows->id.'&name='.$rows->table_name.'&tran_type=pb';
                      }
                      else
                      {
                        $path = 'order/updateParcel/'.$rows->currentorder_id;
                      }

                    ?>

                    <a href="<?php echo base_url().$path; ?>">

                    <!-- <a href="< ?php echo base_url(); ?>orders/< ?php echo ($rows->available == 1) ? 'createFromDashboard?id='.$rows->id.'&name='.$rows->table_name .'&tran_type=pb': 'updateOrderFromDashboard?id='.$rows->currentorder_id.'&table_id='.$rows->id.'&name='.$rows->table_name ?>"> -->
                      <div style="border: 2px solid <?php echo ($rows->available == 1) ? "green" : "red"; ?>; border-radius: 10%; width: 150px; height: 145px; float: left; margin: 10px; background-color: <?php echo ($rows->available == 1) ? "green" : "red"; ?>;">
                        <div style="margin-top: 25%;">
                            <center>
                              <h2 style="color: #fff;"><center><?php echo ucwords($rows->table_name); ?></center></h2>
                              <div><center><span style="color: #fff;">Capacity : <?php echo  ucwords($rows->capacity); ?></span></center></div>
                            </center>
                        </div>
                      </div>
                    </a>
                  <?php endforeach; ?>
                </div>
              
            </div>
          </div>
        </div>

      </div> 


       <?php 

       // echo "<pre>"; print_r($_SESSION); 

       if($this->session->userdata('role') == 2): ?>

        <div class="row"> 

          <br><br>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-first-order"></i></span>

              <div class="info-box-content" style="text-align: center;">
                <span class="info-box-text" style="font-size: 15px; margin-top: 5px">TODAY'S ORDERS</span>
                
                <span class="info-box-number" style="font-size: 28px; text-align: center; margin-top: 7px;"><?php echo $daily_salevolum ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-table"></i></span>

            <div class="info-box-content" style="text-align: center;">
              <span class="info-box-text" style="font-size: 15px;  margin-top: 5px">DIVE IN</span>
              <span class="info-box-number" style="font-size: 28px; text-align: center;  margin-top: 7px"><?php echo $dive_in ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content" style="text-align: center;">
              <span class="info-box-text" style="font-size: 15px;  margin-top: 5px">TAKE AWAY</span>
              <span class="info-box-number" style="font-size: 28px; text-align: center;  margin-top: 7px"><?php echo $take_away ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

         <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-product-hunt"></i></span>

            <div class="info-box-content" style="text-align: center;  margin-top: 5px">
              <span class="info-box-text" style="font-size: 15px;">TOTAL PRODUCTS</span>
              <span class="info-box-number" style="font-size: 28px; text-align: center;  margin-top: 7px"><?php echo $total_products; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

         

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-table"></i></span>

            <div class="info-box-content" style="text-align: center;">
              <span class="info-box-text" style="font-size: 15px;  margin-top: 5px">TABLE SALES</span>
              
              <span class="info-box-number" style="font-size: 28px; text-align: center;  margin-top: 7px"><?php echo $today_salesamt_tb['netamt'] == '' ? "0" : number_format($today_salesamt_tb['netamt'], 2); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-cart-plus"></i></span>

            <div class="info-box-content" style="text-align: center;">
              <span class="info-box-text" style="font-size: 15px;  margin-top: 5px">PARCEL SALES</span>
              <span class="info-box-number" style="font-size: 28px; text-align: center;  margin-top: 7px"><?php echo $today_salesamt_pb['netamt'] == '' ? "0" : number_format($today_salesamt_pb['netamt'], 2); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-inr"></i></span>

            <div class="info-box-content" style="text-align: center;">
              <span class="info-box-text" style="font-size: 15px;  margin-top: 5px">TODAY'S EXPENSES</span>
              <span class="info-box-number" style="font-size: 28px; text-align: center;  margin-top: 7px"><?php echo $today_exp['amt'] == '' ? "0" : number_format($today_exp['amt'], 2); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

            <div class="info-box-content" style="text-align: center;  margin-top: 5px">
              <span class="info-box-text" style="font-size: 15px;">TODAY'S SALES</span>
              <span class="info-box-number" style="font-size: 28px; text-align: center;  margin-top: 7px"><?php echo $today_sales['netamt'] == '' ? "0" : number_format($today_sales['netamt'], 2); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

       
          
        </div>

        <div class="row">

            <div class="col-md-12">

              <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"> <span style="font-weight: bold; font-size: 21px"><i class="fa fa-bell"></i> Unpaid Expences</span></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table border="1" width="100%">
                  <thead>
                  <tr>
                    <th><center style="font-size: 15px;"> SR. No.</center></th>
                    <th><center style="font-size: 15px;"> Date</center></th>
                    <th><center style="font-size: 15px;"> Expenses Name</center></th>
                    <th><center style="font-size: 15px;"> Expenses Category</center></th>
                    <th><center style="font-size: 15px;"> Amount</center></th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php if(!empty($unpaid_exp)){ ?>

                      <?php $no=1; foreach ($unpaid_exp as $key => $value) { ?>

                        <?php
                            $expCat = $this->model_expences->fecthCategoryDataByID($value['expcat_id']);
                        ?>
                        
                          <tr>
                            <td><center> <a href="<?php echo base_url() ?>expences/updateExpences/<?php echo $value['id']; ?>"><?php echo $no; ?></a></center></td>
                            <td><center> <?php echo date('d/m/Y', strtotime($value['date'])); ?></center></td>
                            <td><center> <?php echo $value['name']; ?></center></td>
                            <td><center> <?php echo $expCat['name']; ?></center></td>
                            <td><center> <?php echo $value['amount']; ?></center></td>

                          </tr>

                      <?php $no++; } ?>
                    <?php  }else{ ?>
                           <tr>
                            <td colspan="5">Data Not Found</td>
                          </tr>

                    <?php } ?>

                  
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>


          </div>


        </div>


      </div>

      <?php endif; ?>  

    </section>
    <?php if($this->session->userdata('role') == 0){ ?>
  </div>
<?php } ?>
    <!-- /.content -->
  <!-- </div> -->
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $("#dashboardMainMenu").addClass('active');
    });
  </script>
