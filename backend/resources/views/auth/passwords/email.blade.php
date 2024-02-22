@extends('layouts.auth')
@section('content')

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="py-4 authentication-inner">
            <!-- Forgot Password -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="mt-2 mb-4 app-brand justify-content-center">
                        <a href="{{ route('home') }}" class="gap-2 app-brand-link">
                            <img src="{{ asset('assets/img/favicon/logo.png') }}" class="w-100" />
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="pt-2 mb-1">パスワードをお忘れですか？ 🔒</h4>
                    <p class="mb-4">パスワードをリセットするためのリンクをお送りします。</p>
                    <form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">メール</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    <button class="btn btn-primary d-grid w-100">リセットリンクの送信</button>
                    </form>
                    <div class="text-center">
                        <a href="auth-login-basic.html" class="d-flex align-items-center justify-content-center">
                            <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                            ログインに戻る
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Forgot Password -->
        </div>
    </div>
</div>

@endsection