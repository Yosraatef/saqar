<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('public/admin/images/صقر@3x.png')}}"
                 alt="Al Badr"
                 title="Al Badr"
                 class="rounded-circle img-thumbnail avatar-lg"></a>
            <div class="dropdown">
                <a href="{{route('adminPanal')}}"
                   class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                   data-toggle="dropdown"></a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>

        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">الاقسام</li>
                
                 <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span style="font-size: 20px;">المستخدمين</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('users.index')}}"><i class="mdi mdi-eye"></i>
                        كل  المستخدمين </a></li>
                    <li><a href="{{route('users.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  مستخدم</a></li>
                  </ul>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span style="font-size: 20px;">الخدمات</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('categories.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الخدمات </a></li>
                    <li><a href="{{route('categories.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  خدمة</a></li>
                  </ul>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span style="font-size: 20px;">خدمات فرعية</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('subCategories.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الخدمات الفرعية </a></li>
                    <li><a href="{{route('subCategories.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  خدمة فرعية جديدة</a></li>
                  </ul>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span style="font-size: 20px;">مزودي الخدمات</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('services.index')}}"><i class="mdi mdi-eye"></i>
                        كل  مزودي الخدمات </a></li>
                    <li><a href="{{route('services.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  مزود خدمه</a></li>
                  </ul>
                </li>
                 <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span style="font-size: 20px;">الطلبات</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('orders.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الطلبات </a></li>
                    
                  </ul>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span style="font-size: 20px;">الحسابات </span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('accounts.index')}}"><i class="mdi mdi-eye"></i>
                        كل الحسابات </a></li>
                    <li><a href="{{route('accounts.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  حساب</a></li>
                  </ul>
                </li>
                 <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span style="font-size: 20px;">التحويلات</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('commissions.index')}}"><i class="mdi mdi-eye"></i>
                        كل  التحويلات </a></li>
                    
                  </ul>
                </li>
                <li>
                    <a href="{{route('commissions.create')}}">
                        <i class="mdi mdi-theater"></i>
                        <span style="font-size: 20px;"> ارسال تنبيهات لدفع العموله </span>
                    </a>
                </li>
                 <li>
                    <a href="{{route('settings.create')}}">
                        <i class="mdi mdi-theater"></i>
                        <span style="font-size: 20px;"> الاعدادت </span>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('contact.index')}}">
                        <i class="mdi mdi-theater"></i>
                        <span> رسائل تواصل معنا </span>
                    </a>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->