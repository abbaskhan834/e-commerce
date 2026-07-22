
<aside class="left-sidebar sidebar-dark" id="left-sidebar">
          <div id="sidebar" class="sidebar sidebar-with-footer">
            <!-- Aplication Brand -->
            <div class="app-brand">
              <a href="#">
                <img src="" alt="">
                <span class="brand-name"><strong>Ecommerce</strong></span>
              </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-left" data-simplebar style="height: 100%;">
              <!-- sidebar menu -->
              <ul class="nav sidebar-inner" id="sidebar-menu">
                
                  <li
                   class="active">
                    <a class="sidenav-item-link" href="dashboard.php">
                      <i class="mdi mdi-briefcase-account-outline"></i>
                      <span class="nav-text">Ecommerce Dashboard</span>
                    </a>
                  </li>
        
                 <!-- ADD USERS -->
                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#users"
                      aria-expanded="false" aria-controls="users">
                      <i class="fa fa-user-plus"></i>
                      <span class="nav-text">User</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="users"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">
                            <li>
                              <a class="sidenav-item-link" href="add-users.php">
                                <span>Add Users</span>
                              </a>
                            </li>  
                      </div>
                    </ul>
                </li>

              <!-- ADD PRODUCTS -->
               <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#product"
                      aria-expanded="false" aria-controls="product">
                      <i class="fas fa-shop"></i>
                      <span class="nav-text">Products</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="product"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">
                            <li>
                              <a class="sidenav-item-link" href="add_products.php">
                                <span class="nav-text">Add Products</span>
                              </a>
                            </li>
                      </div>
                    </ul>
                  </li>

                <!--ORDERS-->
                 <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#order"
                      aria-expanded="false" aria-controls="order">
                      <i class="fas fa-shopping-cart"></i>
                      <span class="nav-text">Orders</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="order"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">
                            <li>
                              <a class="sidenav-item-link" href="orders.php">
                                <span class="nav-text">All Orders</span>
                              </a>
                            </li>
                      </div>
                    </ul>
                  </li>
              </ul>
            </div>
          </div>
        </aside>