@extends('layouts.auth')
@section('content')

<div class="container-xxl">
	<div class="authentication-wrapper authentication-basic container-p-y">
		<div class="py-4 authentication-inner">
			<!-- Login -->
			<div class="card">
				<div class="card-body">
					<!-- Logo -->
					<div class="mt-2 mb-4 app-brand justify-content-center">
						<a href="{{ route('login') }}" class="gap-2 app-brand-link">
							<img src="{{ asset('assets/img/favicon/logo.png') }}" class="w-100" />
						</a>
					</div>
					<!-- /Logo -->

					<form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
						@csrf
						<div class="mb-3">
							<label for="email" class="form-label">メール</label>
							<input type="text" class="form-control" id="email" name="email" placeholder="メールアドレス入力" autofocus>
							@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="mb-3 form-password-toggle">
							<div class="d-flex justify-content-between">
								<label class="form-label" for="password">パスワード</label>
								<a href="{{ route('password.request') }}">
									<small>パスワードをお忘れですか？</small>
								</a>
							</div>
							<div class="input-group input-group-merge">
								<input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
								<span class="cursor-pointer input-group-text"><i class="ti ti-eye-off"></i></span>
							</div>
							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="mb-3">
							<button class="btn btn-primary d-grid w-100" type="submit">ログイン</button>
						</div>
					</form>
				</div>
			</div>
			<!-- /Register -->
		</div>
	</div>
</div>

@endsection