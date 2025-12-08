<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>Dashcode - Register</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/rt-plugins.css') }}">
    <link href="https://unpkg.com/aos@2.3.0/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <!-- START : Theme Config js-->
    <script src="{{ asset('assets/js/settings.js') }}" sync></script>
    <!-- END : Theme Config js-->
</head>

<body class="font-inter skin-default">

    <div class="loginwrapper">
        <div class="lg-inner-column">
            <div class="left-column relative z-[1]">
                <div class="max-w-[520px] pt-20 ltr:pl-20 rtl:pr-20">
                    <!--<a href="{{ url('/') }}">
                        <img src="{{ asset('assets/images/logo/logo.svg') }}" alt="" class="mb-10 dark_logo">
                        <img src="{{ asset('assets/images/logo/logo-white.svg') }}" alt="" class="mb-10 white_logo">
                    </a>-->
                    <div class="space-y-2">
                        <h4 class="text-3xl font-bold text-slate-900 dark:text-white leading-tight">
                            Welcome to Binimoy
                        </h4>
                        <p class="text-slate-600 dark:text-slate-300 text-base font-normal">
                            Create your account and start managing
                            <span class="text-primary font-semibold">
                                Binimoy effectively
                            </span>
                        </p>
                    </div>
                </div>
                <div class="absolute left-0 2xl:bottom-[-160px] bottom-[-130px] h-full w-full z-[-1]">
                    <img src="{{ asset('assets/images/auth/ils1.svg') }}" alt="" class=" h-full w-full object-contain">
                </div>
            </div>
            <div class="right-column relative">
                <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                    <div class="auth-box h-full flex flex-col justify-center">
                        <div class="mobile-logo text-center mb-6 lg:hidden block">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/images/logo/logo.svg') }}" alt="" class="mb-10 dark_logo">
                                <img src="{{ asset('assets/images/logo/logo-white.svg') }}" alt="" class="mb-10 white_logo">
                            </a>
                        </div>
                        <div class="text-center 2xl:mb-10 mb-4">
                            <h4 class="font-medium">Sign Up</h4>
                            <div class="text-slate-500 text-base">
                              Join Binimoy Management System and get started today
                            </div>
                        </div>

                        <!-- BEGIN: Register Form -->
                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf

                            <div class="formGroup">
                                <label class="block capitalize form-label">Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                    autocomplete="name" autofocus
                                    class="form-control py-2 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="formGroup">
                                <label class="block capitalize form-label">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    autocomplete="email"
                                    class="form-control py-2 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="formGroup">
                                <label class="block capitalize form-label">Password</label>
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                    class="form-control py-2 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="formGroup">
                                <label class="block capitalize form-label">Confirm Password</label>
                                <input id="password-confirm" type="password" name="password_confirmation" required
                                    autocomplete="new-password" class="form-control py-2">
                            </div>

                            <button type="submit" class="btn btn-dark block w-full text-center">
                                Register
                            </button>
                        </form>
                        <!-- END: Register Form -->

                        <div class="md:max-w-[345px] mx-auto font-normal text-slate-500 dark:text-slate-400 mt-6 uppercase text-sm">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-slate-900 dark:text-white font-medium hover:underline">
                                Sign in
                            </a>
                        </div>
                    </div>
                    <!--<div class="auth-footer text-center mt-6">
                        Copyright 2021, Dashcode All Rights Reserved.
                    </div>-->
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
