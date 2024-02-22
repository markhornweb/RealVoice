@extends('layouts.app')
@section('title', 'ユーザーページ')
@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            @if (session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="mb-4 row">
            <!-- Line Chart -->
            <div class="mb-4 mb-lg-0 col-lg-9 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0 card-title">全体会員数</h5>
                            <small class="text-muted">日別、週別、月別、年別の全体会員数の統計をグラフ化したものです。</small>
                        </div>
                        <div class="d-sm-flex d-none align-items-center">
                            <div class="btn-group d-none d-sm-flex" role="group" aria-label="radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="dailyRadio" checked="">
                                <label class="btn btn-outline-secondary waves-effect" for="dailyRadio">日別</label>

                                <input type="radio" class="btn-check" name="btnradio" id="weeklyRadio" checked="">
                                <label class="btn btn-outline-secondary waves-effect" for="weeklyRadio">週別</label>

                                <input type="radio" class="btn-check" name="btnradio" id="monthlyRadio">
                                <label class="btn btn-outline-secondary waves-effect" for="monthlyRadio">月別</label>

                                <input type="radio" class="btn-check" name="btnradio" id="yearlyRadio">
                                <label class="btn btn-outline-secondary waves-effect" for="yearlyRadio">年別</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="lineChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Line Chart -->
            
            <div class="col-lg-3 col-sm-12">
                <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                    <small class="mb-1 d-block text-muted">現在のユーザー数</small>
                    <p class="card-text text-success">+18.2%</p>
                    </div>
                    <h4 class="mb-1 card-title">42.5k</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-5">
                        <div class="gap-2 mb-2 d-flex align-items-center">
                        <span class="p-1 rounded badge bg-label-info"><i class="ti ti-shopping-cart ti-xs"></i></span>
                        <p class="mb-0">活動</p>
                        </div>
                        <h5 class="pt-1 mb-0 text-nowrap">60.2%</h5>
                        <small class="text-muted">602</small>
                    </div>
                    <div class="col-2">
                        <div class="divider divider-vertical">
                        <div class="divider-text">
                            <span class="badge-divider-bg bg-label-secondary">VS</span>
                        </div>
                        </div>
                    </div>
                    <div class="col-5 text-end">
                        <div class="gap-2 mb-2 d-flex justify-content-end align-items-center">
                        <p class="mb-0">非活動</p>
                        <span class="p-1 rounded badge bg-label-primary"><i class="ti ti-link ti-xs"></i></span>
                        </div>
                        <h5 class="pt-1 mb-0 text-nowrap ms-lg-n3 ms-xl-0">39.8%</h5>
                        <small class="text-muted">398</small>
                    </div>
                    </div>
                    <div class="mt-4 d-flex align-items-center">
                    <div class="progress w-100" style="height: 8px;">
                        <div class="progress-bar bg-info" style="width: 60.2%" role="progressbar" aria-valuenow="60.2" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 39.8%" aria-valuenow="39.8" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Footer -->
    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl">
            <div class="py-2 footer-container d-flex align-items-center justify-content-between flex-md-row flex-column">
                <div>
                    © 
                    <script>
                        document.write(new Date().getFullYear())
                    </script> All Rights Reserved.
                </div>
                <div class="d-none d-lg-inline-block">
                    <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank">License</a>
                    <a href="https://1.envato.market/pixinvent_portfolio" target="_blank" class="footer-link me-4">More Themes</a>
                    <a href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>
                    <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>            
                </div>
            </div>
        </div>
    </footer>
    <!-- / Footer -->
    <div class="content-backdrop fade"></div>
</div>

@endsection