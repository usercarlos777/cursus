@extends('layouts.admin-master')

@section('title')
{{ __('Settings') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Settings') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">{{ __('Home') }}</a></div>
            <div class="breadcrumb-item"><a href="#">{{ __('Settings') }}</a></div>
            <div class="breadcrumb-item"><a href="#">{{ __('Appearance') }}</a></div>
        </div>
    </div>

    <div class="section-body">
        <x-alert-msg></x-alert-msg>
        <div class="row">

            <div class="col-12 col-md-12 col-lg-12 ">
                <form action="{{ route('setting.update') }}" method="POST" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Appearance Setting')}}</h4>

                        </div>
                        <div class="card-body ">
                            <form method="post">
                                <div class="row">

                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Logo') }}</label>
                                            <input type="file" name="logo" class="form-control-file "
                                                accept="image/svg">
                                            <small class="form-text text-muted">
                                                Only .svg formate image are supported, covert <a
                                                    href="https://image.online-convert.com/convert-to-svg"
                                                    target="_blank">
                                                    here.</a>
                                            </small>
                                        </div>

                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Dark Logo') }}</label>
                                            <input type="file" name="dark_logo" class="form-control-file "
                                                accept="image/svg">
                                            <small class="form-text text-muted">
                                                Only .svg formate image are supported, covert <a
                                                    href="https://image.online-convert.com/convert-to-svg"
                                                    target="_blank">
                                                    here.</a>
                                            </small>
                                        </div>

                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Footer Logo') }}</label>
                                            <input type="file" name="footer_logo" class="form-control-file "
                                                accept="image/svg">
                                            <small class="form-text text-muted">
                                                Only .svg formate image are supported, covert <a
                                                    href="https://image.online-convert.com/convert-to-svg"
                                                    target="_blank">
                                                    here.</a>
                                            </small>
                                        </div>

                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Favicon') }}</label>
                                            <input type="file" name="favicon" class="form-control-file "
                                                accept="image/png">
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">{{__('Submit')}}</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</section>

@endsection