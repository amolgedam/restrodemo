<aside class="main-sidebar">

    <section class="sidebar">

      <?php

          $userData = $this->model_users->getUserData($this->session->userdata['id']);
          // echo "<pre>"; print_r($userData); exit();

          if($userData['img'] == '')
          {
            $path = 'assets/dist/img/user2-160x160.jpg';
          }else
          {
            $path = 'assets/images/profile/'.$userData['img'];
          }
      ?>

      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url().$path ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="font-size: 15px"><?php echo ucwords($userData['firstname']); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" autocomplete="off" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
     
        <ul class="sidebar-menu" data-widget="tree">
            
            <li class="header" style="color: white;">MAIN NAVIGATION</li>
            
            <li>
              <a href="<?php echo base_url('dashboard') ?>" style="color: white; ">
                <i class="fa fa-th"></i> <span style="font-size: 16px;">&nbsp;&nbsp;&nbsp;Dashboard</span>
              </a>
            </li>
            
            <?php if(in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
            
                <li class="treeview">
                  <a href="#" style="color: white;">
                    <i class="fa fa-asterisk"></i>
                    <span style="font-size: 18px;">&nbsp;&nbsp;&nbsp;Master</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                    <ul class="treeview-menu">

                        <li class="treeview">
                          <a href="#"  style="color: white; font-size: 15px;"><i class="fa fa-product-hunt"></i>&nbsp;&nbsp;&nbsp;&nbsp;Product Master
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">
                               <?php if(in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
                                    <li>
                                      <a href="<?php echo base_url('category/') ?>"  style="color: white;font-size: 15px;"><i class="fa fa-circle-o"></i><span>&nbsp;&nbsp;Category</span></a>
                                    </li>
                                <?php endif ?>   
                                
                                <?php if(in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                                      <li id="manageProductSubMenu"><a href="<?php echo base_url('products') ?>" style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;Products</a></li>
                                <?php endif; ?>


                                      <li id="manageProductSubMenu"><a href="<?php echo base_url('gst') ?>" style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;GST Master</a></li>


                                
                                <?php if(in_array('updateSetting', $user_permission)): ?>
                                    <li id="settingMainNav"><a href="<?php echo base_url('unit_type/') ?>" style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i><span>&nbsp;&nbsp;Unit Master</span></a></li>
                                <?php endif; ?>
                                
                          </ul>
                        </li>


                        <li class="treeview">
                          <a href="#"  style="color: white; font-size: 15px;"><i class="fa fa-building"></i>&nbsp;&nbsp;&nbsp;&nbsp;Company Master
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">
                              
                              <li><a href="<?php echo base_url('paymentor/') ?>"  style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i><span>&nbsp;&nbsp;Payment Type</span></a></li>
                    
                              <li><a href="<?php echo base_url('sales_type/') ?>"  style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i><span>&nbsp;&nbsp;Sales Type</span></a></li>

                              <?php if(in_array('createStore', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>

                                <li>
                                  <a href="<?php echo base_url('stores/') ?>"  style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i><span>&nbsp;&nbsp;Store Type</span></a>
                                </li>
                              
                              <?php endif; ?>


                          </ul>
                        </li>


                        
                        <?php if(in_array('createTable', $user_permission) || in_array('updateTable', $user_permission) || in_array('viewTable', $user_permission) || in_array('deleteTable', $user_permission)): ?>
                        <li class="treeview">
                          <a href="#"  style="color: white; font-size: 15px;"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;&nbsp;Table And Parcel
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">
                            <li id="createOrderSubMenu"><a href="<?php echo base_url('tables/') ?>"  style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i><span>&nbsp;&nbsp;Manage Tables</span></a></li>
                            <li id="createOrderSubMenu"><a href="<?php echo base_url('parcel/') ?>"  style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i><span>&nbsp;&nbsp;Manage Parcel</span></a></li>
                          </ul>
                        </li>
                        <?php endif; ?>
                      
                    </ul>
                </li>
            <?php endif; ?>
            
            
            <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
            
            <li class="treeview">
              <a href="#" style="color: white;">
                <i class="fa fa-users"></i>
                <span style="font-size: 18px;">&nbsp;&nbsp;&nbsp;CRM</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
                <ul class="treeview-menu">
                    
                    <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                    
                        <li><a href="<?php echo base_url('waiter') ?>" style="color: white; font-size: 15px;"><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;&nbsp;Waitor/Employee</a></li>
                    <?php endif; ?>
                    
                     
                    <?php if(in_array('createTable', $user_permission) || in_array('updateTable', $user_permission) || in_array('viewTable', $user_permission) || in_array('deleteTable', $user_permission)): ?>
                    <li class="treeview">
                      <a href="#"  style="color: white; font-size: 15px;"><i class="fa fa-user-secret"></i>&nbsp;&nbsp;&nbsp;&nbsp;Administration
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li id="createOrderSubMenu"><a href="<?php echo base_url('groups') ?>"  style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i><span>&nbsp;&nbsp;Manage Group</span></a></li>
                        <li id="createOrderSubMenu"><a href="<?php echo base_url('users/') ?>"  style="color: white; font-size: 15px;"><i class="fa fa-circle-o"></i><span>&nbsp;&nbsp;Manage Users</span></a></li>
                           
                      </ul>
                    </li>
                    <?php endif; ?>


                    <li><a href="<?php echo base_url('compose') ?>" style="color: white; font-size: 15px;"><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;&nbsp;Email/ SMS</a></li>
                    
                    <!-- <li class="treeview">
                      <a href="#"  style="color: white; font-weight: bold; font-size: 15px;">
                        <i class="fa fa-circle-o"></i>
                        <span>Email/SMS</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="< ?php echo base_url() ?>compose/configEmail"  style="color: white; font-weight: bold; font-size: 15px;"><i class="fa fa-circle-o"></i>Email Config</a></li>
                        <li><a href="< ?php echo base_url() ?>compose/configSms"  style="color: white; font-weight: bold; font-size: 15px;"><i class="fa fa-circle-o"></i>SMS Config</a></li>
                         <li><a href="< ?php echo base_url() ?>compose"  style="color: white; font-weight: bold; font-size: 15px;"><i class="fa fa-circle-o"></i>Compose Email and SMS</a></li>
                        </ul>
                    </li>  -->
                    
                  
                </ul>
            </li>
         <?php endif; ?>
         
         <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
        
            <li>
              <a href="<?php echo base_url('orders') ?>" style="color: white;">
                <i class="fa fa-shopping-cart"></i><span style="font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;Sales</span>
              </a>
            </li>

        <?php endif; ?>
        
        <!--  < ?php if(in_array('createExpencesCategory', $user_permission) || in_array('updateExpencesCategory', $user_permission) || in_array('viewExpencesCategory', $user_permission) || in_array('deleteExpencesCategory', $user_permission) || in_array('createManageExpences', $user_permission) || in_array('updateManageExpences', $user_permission) || in_array('viewManageExpences', $user_permission) || in_array('deleteManageExpences', $user_permission)): ?> -->
          <li class="treeview">
            <a href="#" style="color: white;">
              <i class="fa fa-book"></i>
              <span style="font-size: 18px;">&nbsp;&nbsp;&nbsp;Expenses</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <!-- < ?php if(in_array('createExpencesCategory', $user_permission) || in_array('updateExpencesCategory', $user_permission) || in_array('viewExpencesCategory', $user_permission) || in_array('deleteExpencesCategory', $user_permission)): ?> -->
                <li><a href="<?php echo base_url() ?>expences/category" style="color: white; font-size: 15px;"><i class="fa fa-rub"></i>&nbsp;&nbsp;&nbsp;&nbsp;Expense Category</a></li>
              <!-- < ?php endif; ?> -->

              <!-- < ?php if(in_array('createManageExpences', $user_permission) || in_array('updateManageExpences', $user_permission) || in_array('viewManageExpences', $user_permission) || in_array('deleteManageExpences', $user_permission)): ?> -->
                <li><a href="<?php echo base_url() ?>expences/" style="color: white; font-size: 15px;"><i class="fa fa-dollar"></i>&nbsp;&nbsp;&nbsp;&nbsp;Manage Expenses</a></li>
              <!-- < ?php endif; ?> -->
              
            </ul>
          </li>
        <!-- < ?php endif; ?> -->
        
        
        <?php if($user_permission): ?>

            <li class="treeview" id="ReportMainNav">
              <a href="#" style="color: white;">
                <i class="fa fa-bar-chart-o"></i>
                <span style="font-size: 18px;">&nbsp;&nbsp; Reports</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('viewReport', $user_permission)): ?>

                  <li id="storeReportSubMenu"><a href="<?php echo base_url('reports/waiterReport') ?>" style="color: white; font-size: 15px;"><i class="fa fa-users"></i>&nbsp;&nbsp;&nbsp;&nbsp;Waiter Report</a></li>

                  <li id="storeReportSubMenu"><a href="<?php echo base_url('reports/tableReport') ?>" style="color: white; font-size: 15px;"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;&nbsp;Table/Parcel</a></li>

                  <li id="storeReportSubMenu"><a href="<?php echo base_url('reports/salesReport') ?>" style="color: white; font-size: 15px;"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;&nbsp;Sales Report</a></li>

                  <li id="storeReportSubMenu"><a href="<?php echo base_url('reports/expenseReport') ?>" style="color: white; font-size: 15px;"><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;&nbsp;Expense Report</a></li>

                  <li id="storeReportSubMenu"><a href="<?php echo base_url('reports/incomeReport') ?>" style="color: white; font-size: 15px;"><i class="fa fa-money"></i>&nbsp;&nbsp;&nbsp;&nbsp;Income Report</a></li>

                  <li id="storeReportSubMenu"><a href="<?php echo base_url('reports/gstReport') ?>" style="color: white; font-size: 15px;"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;&nbsp;GST Report</a></li>
                  
                  
                  
                <?php endif; ?>
              </ul>
            </li>

        <?php endif; ?>
        
        <!-- 
           < ?php if(in_array('updateSetting', $user_permission)): ?>
            <li class="treeview" id="ReportMainNav">
              <a href="#"  style="color: white; font-weight: bold; font-size: 17px;">
                <i class="fa fa-product-hunt"></i>
                <span>Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                < ?php if(in_array('updateSetting', $user_permission)): ?>
                    
                     <li><a href="< ?php echo base_url('company') ?>"  style="color: white; font-weight: bold; font-size: 15px;"><i class="fa fa-circle-o"></i>Company Profile</a></li>
                        <li><a href="< ?php echo base_url('users/setting/') ?>"  style="color: white; font-weight: bold; font-size: 15px;"><i class="fa fa-circle-o"></i>User Profile</a></li>
                    
                < ?php endif; ?>
              </ul>
            </li>
          < ?php endif; ?> -->

        
        </ul>
        
    </section>
    
</aside>
          
          