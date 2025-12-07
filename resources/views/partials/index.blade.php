<!DOCTYPE html>
<!-- Template Name: DashCode - HTML, React, Vue, Tailwind Admin Dashboard Template Author: Codeshaper Website: https://codeshaper.net Contact: support@codeshaperbd.net Like: https://www.facebook.com/Codeshaperbd Purchase: https://themeforest.net/item/dashcode-admin-dashboard-template/42600453 License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project. -->
<html lang="zxx" dir="ltr" class="light">

<head>
    @include('admin.css')
</head>

<body class=" font-inter dashcode-app" id="body_class">
    <main class="app-wrapper">
        @include('admin.sidebar')
        <div class="flex flex-col justify-between min-h-screen">
            <div>
                <!-- BEGIN: Header -->
                @include('admin.header')
                <!-- END: Header -->
                <div class="content-wrapper transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]"
                    id="content_wrapper">
                    <div class="page-content">
                        <div class="transition-all duration-150 container-fluid" id="page_layout">
                            <div id="content_layout">

                                <div>
                                    @yield('content')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BEGIN: Footer For Desktop and tab -->
            @include('admin.footer')
            <!-- END: Footer For Desktop and tab -->

            <div
                class="bg-white bg-no-repeat custom-dropshadow footer-bg dark:bg-slate-700 flex justify-around items-center
    backdrop-filter backdrop-blur-[40px] fixed left-0 bottom-0 w-full z-[9999] bothrefm-0 py-[12px] px-4 md:hidden">
                <a href="chat.html">
                    <div>
                        <span
                            class="relative cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center mb-1 dark:text-white
          text-slate-900 ">
                            <iconify-icon icon="heroicons-outline:mail"></iconify-icon>
                            <span
                                class="absolute right-[5px] lg:hrefp-0 -hrefp-2 h-4 w-4 bg-red-500 text-[8px] font-semibold flex flex-col items-center
            justify-center rounded-full text-white z-[99]">
                                10
                            </span>
                        </span>
                        <span class="block text-[11px] text-slate-600 dark:text-slate-300">
                            Messages
                        </span>
                    </div>
                </a>
                <a href="profile.html"
                    class="relative bg-white bg-no-repeat backdrop-filter backdrop-blur-[40px] rounded-full footer-bg dark:bg-slate-700
      h-[65px] w-[65px] z-[-1] -mt-[40px] flex justify-center items-center">
                    <div class="h-[50px] w-[50px] rounded-full relative left-[0px] hrefp-[0px] custom-dropshadow">
                        <img src="assets/images/users/user-1.jpg" alt=""
                            class="w-full h-full rounded-full border-2 border-slate-100">
                    </div>
                </a>
                <a href="#">
                    <div>
                        <span
                            class=" relative cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center mb-1 dark:text-white
          text-slate-900">
                            <iconify-icon icon="heroicons-outline:bell"></iconify-icon>
                            <span
                                class="absolute right-[17px] lg:hrefp-0 -hrefp-2 h-4 w-4 bg-red-500 text-[8px] font-semibold flex flex-col items-center
            justify-center rounded-full text-white z-[99]">
                                2
                            </span>
                        </span>
                        <span class=" block text-[11px] text-slate-600 dark:text-slate-300">
                            Notifications
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </main>
    <!-- scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
