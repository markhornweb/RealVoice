@extends('layouts.app')
@section('title', 'ユーザー管理')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header">ユーザー情報</h5>
        <div class="card-datatable text-nowrap px-4">
            <table class="dt-scrollableTable table">
                <thead>
                    <tr>
                        <th style="width: 50px;">番号</th>
                        <th style="width: 100px;">アバター</th>
                        <th style="width: 150px;">ユーザー名</th>
                        <th style="width: 150px;">ニックネーム</th>
                        <th style="width: 100px;">性別</th>
                        <th style="width: 150px;">生年月日</th>
                        <th style="width: 200px;">メール</th>
                        <th style="width: 150px;">電話番号</th>
                        <th style="width: 200px;">最終ログイン時間</th>
                        <th style="width: 100px;">詳細を見る</th>
                        <th style="width: 100px;">操作</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script type="text/javascript">
    $(function () {
        var table = $('.dt-scrollableTable').DataTable({
            sScrollX: "100%",
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('users.index') }}",
                type: 'GET',
                data: function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.limit = d.length;
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'avatar', name: 'avatar', orderable: false, searchable: false,
                    render: function (data, type, full, meta) {
                        return '<img src="'+ data +'" width="50" height="50" style="border-radius: 25px;" />';
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'nick_name', name: 'nick_name'},
                {data: 'gender', name: 'gender'},
                {data: 'birthday', name: 'birthday'},
                {data: 'email', name: 'email'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'last_logined_at', name: 'last_logined_at'},
                {data: 'detail_link', name: 'detail_link', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Japanese.json"
            },
            lengthMenu: [5, 10, 25, 50, 100],
            pageLength: 5,
        });
    });
</script>

@endsection