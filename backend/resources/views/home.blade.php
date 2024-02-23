@extends('layouts.app')
@section('title', 'ユーザーページ')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />

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
                        <div class="d-sm-flex col-1 align-items-center">
                            <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default" onchange="changeChartType(this.value)">
                                <option value="daily">日別</option>
                                <option value="weekly">週別</option>
                                <option value="monthly">月別</option>
                                <option value="yearly">年別</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="lineChart"></div>
                    </div>
                </div>
            </div>
            <!-- /Line Chart -->
            
            <div class="col-lg-3 col-sm-12" id="userCount"></div>
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

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>

@endsection