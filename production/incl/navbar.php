<div class="top_nav">
  <div class="nav_menu">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <nav class="nav navbar-nav">
      <ul class=" navbar-right">
        <li class="nav-item dropdown open" style="padding-left: 15px;">
          <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
            <img src="images/icon-person.jpg" alt=""><?php echo $rowUser['name'];?>
          </a>
          <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item"  href="index?link=profile"> Profile</a>
            <a class="dropdown-item"  href="logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
          </div>
        </li>

        <li role="presentation" class="nav-item dropdown open">
          <!-- <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bell-o"></i>
            <span class="badge bg-green" id="messageBadge"></span>
          </a> -->
          <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1" id="messageDropdown">
            <!-- Messages will be dynamically loaded here -->
            <li class="nav-item">
              <div class="text-center">
                <a class="dropdown-item">
                  <strong>See All Alerts</strong>
                  <i class="fa fa-angle-right"></i>
                </a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>