<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
          <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.kas')}}">
          <span class="icon-bg"><i class="mdi mdi-format-list-bulleted menu-icon"></i></span>
          <span class="menu-title">Kas</span>
        </a>
      </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('admin.users')}}">
            <span class="icon-bg"><i class="mdi mdi-contacts menu-icon"></i></span>
            <span class="menu-title">Users</span>
          </a>
        </li>
      <li class="nav-item sidebar-user-actions">
        <div class="sidebar-user-menu">
          <a href="#" class="nav-link"><i class="mdi mdi-settings menu-icon"></i>
            <span class="menu-title">Settings</span>
          </a>
        </div>
      </li>
      <li class="nav-item sidebar-user-actions">
        <div class="sidebar-user-menu">
          <a href="#" class="nav-link"><i class="mdi mdi-speedometer menu-icon"></i>
            <span class="menu-title">Logs</span></a>
        </div>
      </li>
    </ul>
  </nav>