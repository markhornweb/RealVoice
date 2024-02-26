@extends('layouts.app')
@section('title', 'ユーザー管理')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">ユーザー情報 /</span> 詳細を見る
    </h4>
    <!-- Header -->
    <div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-4 mx-sm-0 mx-auto">
                    <img src="{{ asset($user->avatar) }}" alt="user image" class="d-block ms-0 ms-sm-4 rounded user-profile-img" style="width: 120px; height: 120px;">
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                    <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4>{{ $user->name }}</h4>
                            <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item d-flex gap-1">
                                    <i class='ti ti-color-swatch'></i> {{ $user->nick_name }}
                                </li>
                                <li class="list-inline-item d-flex gap-1">
                                    <i class='ti ti-calendar'></i> 登録日： {{ $user->created_at->format("Y-m-d") }}
                                </li>
                                <li class="list-inline-item d-flex gap-1">
                                    <i class='ti ti-clock'></i> 最終ログイン時間： {{ $user->last_logined_at }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--/ Header -->

    <!-- User Profile Content -->
    <div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
        <!-- About User -->
        <div class="card mb-4">
            <div class="card-body">
                <ul class="list-unstyled mb-4 mt-3">
                    <li class="d-flex align-items-center mb-3"><i class="ti ti-user text-heading"></i><span class="fw-medium mx-2 text-heading">氏名：</span> <span>{{ $user->name }}</span></li>
                    <li class="d-flex align-items-center mb-3"><i class="ti ti-gender-bigender"></i><span class="fw-medium mx-2 text-heading">性別：</span> <span>{{ $user->gender }}</span></li>
                    <li class="d-flex align-items-center mb-3"><i class="ti ti-calendar"></i><span class="fw-medium mx-2 text-heading">生年月日：</span> <span>{{ $user->birthday }}</span></li>
                    <li class="d-flex align-items-center mb-3"><i class="ti ti-phone-call"></i><span class="fw-medium mx-2 text-heading">電話番号：</span> <span>{{ $user->phone_number }}</span></li>
                    <li class="d-flex align-items-center mb-3"><i class="ti ti-mail"></i><span class="fw-medium mx-2 text-heading">メール：</span> <span>{{ $user->email }}</span></li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-accessible text-heading"></i>
                        <span class="fw-medium mx-2 text-heading">活動状況：</span>
                            @if($user->is_active)
                            <span class="text-success">活動中</span>
                            @else
                            <span class="text-warning">非活動</span>
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <!--/ About User -->
        <!-- Profile Overview -->
        <div class="card mb-4">
            <div class="card-body">
                <p class="card-text text-uppercase">自己PR</p>
                <ul class="list-unstyled mb-0">
                    {{ $user->description }}
                </ul>
            </div>
        </div>
        <!--/ Profile Overview -->
    </div>
    <div class="col-xl-8 col-lg-7 col-md-7">
        <!-- Activity Timeline -->
        <div class="card card-action mb-4">
            <div class="card-header align-items-center">
                <h5 class="card-action-title mb-0">最近投稿した記事</h5>
            </div>
            <div class="card-body pb-0">
                <ul class="list-group mb-3">
                    @foreach($posts as $post)
                    <li class="list-group-item p-4">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0 d-flex align-items-center">
                                <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-px-100">
                            </div>
                            <div class="flex-grow-1">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="me-3"><a href="javascript:void(0)" class="text-body">{{ $post->title }}</a></p>
                                        <div class="text-muted mb-2 d-flex flex-wrap"><span class="me-1">カテゴリー：</span><span class="badge bg-label-success">{{ $post->category->title }}</span></div>
                                        <div class="read-only-ratings mb-3" data-rateyo-read-only="true"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-md-end">
                                            <div class="my-2 my-md-4 mb-md-5"><span class="text-muted">{{ $post->created_at }}</span></div>
                                            <button type="button" class="btn btn-sm btn-label-info mt-md-3">詳細を見る</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!--/ Activity Timeline -->
    </div>
    </div>
    <!--/ User Profile Content -->
</div>
@endsection