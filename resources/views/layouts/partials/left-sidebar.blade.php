 <!-- ========== Left Sidebar Start ========== -->
 <div class="vertical-menu">

     {{-- <!-- LOGO -->
     <div class="navbar-brand-box">
         <a href="{{ route('home') }}" class="logo logo-dark">
             <div class="app-header__logo pl-0 pr-5">
                 <div class="logo-src"></div>
             </div>
         </a>

         <a href="{{ route('home') }}" class="logo logo-light">
             <div class="app-header__logo pl-0 pr-5">
                 <div class="logo-src"></div>
             </div>
         </a>
     </div> --}}

     <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
         <i class="fa fa-fw fa-bars"></i>
     </button>

     <div data-simplebar class="sidebar-menu-scroll">

         <!--- Sidemenu -->
         <div id="sidebar-menu">
             <!-- Left Menu Start -->
             <ul class="metismenu list-unstyled" id="side-menu">
                 @include('layouts.menu')
             </ul>
         </div>
         <!-- Sidebar -->
     </div>
 </div>
 <!-- Left Sidebar End -->
