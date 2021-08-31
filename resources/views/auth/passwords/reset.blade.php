<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <title>{{__('Reset Password ')}}- {{env("APP_NAME")}}</title>


    <link rel="icon" type="image/png" href="{{ static_asset('frontend/images/fav.png') }}">

    @include('frontend.inc.styles')

</head>

<body class="coming_soon_style">

    <div class="coming_soon_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cmtk_group">
                        <div class="ct-logo">
                            <a href="{{ url('/') }}"><img src="{{ static_asset('/frontend/images/ct_logo.svg') }}" alt=""></a>
                        </div>
                        <div class="cmtk_dt">
                            <h4 class="thnk_coming_title">{{__('Reset Password')}}</h4>
                            <h4 class="thnk_title1">
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif
                            </h4>

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf


                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="user_type" value="{{ $user_type }}">

                                <div class="form-group row">

                                    <div class="col-md-6 offset-md-3">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                                            placeholder={{__('Email')}}>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">


                                    <div class="col-md-6 offset-md-3">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password" placeholder="{{ __('Password') }}">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">


                                    <div class="col-md-6 offset-md-3">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="{{ __('Confirm Password') }}">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-3">
                                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-danger">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <p class="thnk_des">{{ __('Go want to back ?') }} <a href="{{url('/')}}">{{__('Click Here')}}</a>
                                </span>

                        </div>
                        @include('frontend.inc.footer2')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.inc.scripts')

</body>

</html>