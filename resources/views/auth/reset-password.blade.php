<x-guest-layout>
<div class="container border-dark">
    <div class="row">
        <div class="mb-4 ml-3 text-sm text-gray-600 dark:text-gray-400">
            <h5>Reset Password</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>

                    <input id="email" type="email" class="form-control email_login @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email', $request->email) }}" required autocomplete="username" placeholder="Correo"
                           autofocus aria-autocomplete="" />
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="New password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-text-input id="password_confirmation" class="form-control"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password" />


                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"   />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button class="btn btn-primary btn-block">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-6 d-none d-md-block">
            <a href="/public">
                <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->
                <img src="{{url('/')}}/imgs/logo-general.jpeg" alt="logo" width="87px" height="80px">
            </a>
        </div>
    </div>
</div>
</x-guest-layout>








{{--<div class="container border-dark">--}}
{{--    <div class="row">--}}
{{--        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">--}}
{{--            <p class="text-justify">--}}
{{--                Forgot your password? No problem. Just let us know your email address and we will--}}
{{--                email you a password reset link that will allow you to choose a new one.--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-sm-6">--}}
{{--            <form method="POST" action="{{ route('password.store') }}">--}}
{{--                @csrf--}}

{{--                <!-- Password Reset Token -->--}}
{{--                <input type="hidden" name="token" value="{{ $request->route('token') }}">--}}

{{--                <!-- Email Address -->--}}

{{--                <div>--}}
{{--                    <x-input-label for="email" :value="__('Email')" />--}}
{{--                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />--}}
{{--                    <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--                </div>--}}

{{--                <!-- Password -->--}}
{{--                <div class="mt-4">--}}
{{--                    <x-input-label for="password" :value="__('Password')" />--}}
{{--                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />--}}
{{--                    <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--                </div>--}}

{{--                <!-- Confirm Password -->--}}
{{--                <div class="mt-4">--}}
{{--                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />--}}

{{--                    <x-text-input id="password_confirmation" class="block mt-1 w-full"--}}
{{--                                  type="password"--}}
{{--                                  name="password_confirmation" required autocomplete="new-password" />--}}

{{--                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />--}}
{{--                </div>--}}

{{--                <div class="flex items-center justify-end mt-4">--}}
{{--                    <x-primary-button>--}}
{{--                        {{ __('Reset Password') }}--}}
{{--                    </x-primary-button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--        <div class="col-sm-6">--}}
{{--            <a href="/">--}}
{{--                <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->--}}
{{--                <img src="{{url('/')}}/imgs/logo-general.jpeg" alt="logo" width="87px" height="80px">--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}



