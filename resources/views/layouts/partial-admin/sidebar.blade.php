<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('default-avatar.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li class="{{ (!Request::segment(2) ? 'treeview active' : '')}}">
          <a href="{{ route('home') }}">
            <i class="fa fa-th"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="{{ (Request::segment(2) == 'category' || Request::segment(2) == 'tag') ? 'active treeview menu-open' : 'treeview' }}">
          <a href="#">
            <i class="fa fa-cog"></i>
            <span>Manage</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ (Request::segment(2) == 'category') ? 'active' : '' }}"><a href="{{ route('category.index') }}"><i class="fa fa-circle-o"></i>Kategori</a></li>
            <li class="{{ (Request::segment(2) == 'tag') ? 'active' : '' }}"><a href="{{ route('tag.index') }}"><i class="fa fa-circle-o"></i>Tag</a></li>
          </ul>
        </li>

        <li class="{{ (Request::segment(2) == 'logs') ? 'treeview active' : ''}}">
          <a href="{{ route('logs.index') }}">
            <i class="fa fa-fw fa-wrench"></i> <span>Logs</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>
