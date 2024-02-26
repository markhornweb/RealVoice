@extends('layouts.app')
@section('title', 'ダッシュボード')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />

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

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('js/home.js') }}"></script>

@endsection