<x-guest-layout>
<div class="container border-dark">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    <p class="text-justify">
                        Forgot your password? No problem. Just let us know your email address and we will
                        email you a password reset link that will allow you to choose a new one.
                    </p>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12  col-md-6">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>

                        <input id="email" type="email" class="form-control email_login @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo"
                               autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror

                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button class="btn btn-primary btn-block">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-12  col-md-6 d-none d-md-block">
                <a href="/">
                    <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->
                    <img src="{{url('/')}}/imgs/logo-general.jpeg" alt="logo" width="87px" height="80px">
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
