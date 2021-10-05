<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> -->
        <div class="sidebar-brand-text mx-3">REKAMJASA <sup>v1</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Beranda -->
    <li class="nav-item <?=isset($home)?'active':'';?>">
        <a class="nav-link" href="?#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>
    
    
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?=isset($prod)?'active':'';?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#prod" aria-expanded="true"
            aria-controls="a">
            <i class="fas fa-fw fa-folder"></i>
            <span>Product</span>
        </a>
        <div id="prod" class="collapse <?=isset($prod)?'show':'';?>" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">  
                <a class="collapse-item <?=isset($asset)?'active':'';?>" href="?asset">Asset</a>
                <a class="collapse-item <?=isset($cat)?'active':'';?>" href="?cat">Category</a>
                <a class="collapse-item <?=isset($brand)?'active':'';?>" href="?brand">Brand</a>
                <a class="collapse-item <?=isset($tipe)?'active':'';?>" href="?tipe">Type</a>
                <a class="collapse-item <?=isset($loc)?'active':'';?>" href="?loc">Location</a>
                <a class="collapse-item <?=isset($sup)?'active':'';?>" href="?sup">Supplier</a>
            </div>
        </div>
    </li> 

    <li class="nav-item <?=isset($cust)?'active':'';?>">
        <a class="nav-link collapsed" href="?#" data-toggle="collapse" data-target="#cust" aria-expanded="true"
            aria-controls="b">
            <i class="fas fa-fw fa-users"></i>
            <span>Customer</span>
        </a>
        <div id="cust" class="collapse <?=isset($cust)?'show':'';?>" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">  
                <a class="collapse-item <?=isset($listcust)?'active':'';?>" href="?listcust"> List</a>
                <a class="collapse-item <?=isset($soon)?'active':'';?>" href="?soon">Soon</a>
                <a class="collapse-item <?=isset($expired)?'active':'';?>" href="?expired">Expired</a>

            </div>
        </div>
    </li> 

    <?php if($_SESSION['level']=='Admin'):?>
        <li class="nav-item <?=isset($pengguna)?'active':'';?>">
        <a class="nav-link" href="?pengguna">
            <i class="fas fa-fw fa-key"></i>
            <span>Site Account</span>
        </a>
    </li>
    <?php endif; ?>
    <?php if($_SESSION['level']=='Admin' || $_SESSION['level']=='User'):?>

    
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?=isset($transaksi)?'active':'';?>">
        <a class="nav-link" href="?transaksi">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Transaksi</span>
        </a>
    </li>
    <?php endif; ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->