<!-- Sidebar user panel -->
<ul class="sidebar-menu">
    {{ \Acme\Helpers\Menu::Item('admin.index','Dashboard', '', 'fa-dashboard') }}
    <li class="treeview">
        <a href="#">
            <i class="fa fa-camera"></i>
            <span>Imagenes</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu" style="display:block;">
            {{ \Acme\Helpers\Menu::subItem('admin.pictures.index','Imagenes', '', '') }}
            {{ \Acme\Helpers\Menu::subItem('admin.albums.index','Albums', '', '') }}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Contenidos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display:block;">
                    {{ \Acme\Helpers\Menu::subItem('admin.performedworks.index', 'Proyectos', '', '') }}
                    {{ \Acme\Helpers\Menu::subItem('admin.clients.index','Clientes', '', '') }}
                </ul>
            </li>
        </ul>
    </li>
<!--    <li>-->
<!--        <a href="pages/mailbox.html">-->
<!--            <i class="fa fa-envelope"></i> <span>Mailbox</span>-->
<!--            <small class="badge pull-right bg-yellow">12</small>-->
<!--        </a>-->
<!--    </li>-->
</ul>