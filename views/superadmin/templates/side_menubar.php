<aside class="main-sidebar">

    <section class="sidebar">

      <?php

          $userData = $this->model_users->getUserData($this->session->userdata['id']);
          // echo "<pre>"; print_r($_SESSION); exit();

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
          <p><?php echo ucwords($userData['firstname']); ?></p>
          
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> 

      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
     
        <ul class="sidebar-menu" data-widget="tree">
            
            <li class="header" style="color: white; font-weight: bold;">MAIN NAVIGATION</li>
            
            <li>
              <a href="<?php echo base_url('superadmin/dashboard') ?>" style="color: white; ">
                <i class="fa fa-th"></i> <span style="font-size: 17px;">Dashboard</span>
              </a>
            </li>

            <li>
              <a href="<?php echo base_url('/superadmin/manageAdmin') ?>" style="color: white; ">
                <i class="fa fa-users"></i> <span style="font-size: 17px;">Manage Admin</span>
              </a>
            </li>
           
        </ul>
        
    </section>
    
</aside>
          
          