<div class="overflow-auto">
    <table class="table table-bordered" style="min-width: 1500px;">
        <thead>
            <tr>
                <th>番号</th>
                <th style="width: 100px;">アバター</th>
                <th>ユーザー名</th>
                <th>ニックネーム</th>
                <th>性別</th>
                <th>生年月日</th>
                <th>メール</th>
                <th>電話番号</th>
                <th>最終ログイン時間</th>
                <th>詳細を見る</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @if(count($users) < 1)
                <tr>
                    <td colspan="11" class="text-center">検索されたデータがありません。</td>
                </tr>
            @else
                @foreach($users as $user)
                <tr>
                    <td>
                        {{ $loop->index + $users->firstItem() }}
                    </td>
                    <td class="avatar">
                        <img src="{{ $user->avatar }}" alt="Avatar" class="rounded-circle avatar" style="width: 35px; height: 35px;">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->nick_name }}</td>
                    <td>{{ $user->gender }}</td>
                    <td>{{ $user->birthday }}</td>
                    <td>
                        <a href="mailto:;{{ $user->email }}" class="text-secondary">{{ $user->email }}</a>
                    </td>
                    <td>
                        <a href="tel:;{{ $user->phone_number }}" class="text-secondary">{{ $user->phone_number }}</a>
                    </td>
                    <td>{{ $user->last_logined_at }}</td>
                    <td>
                        <span class="badge bg-label-info me-1">
                            <a href="{{ route('users.show', ['user' => $user->id]) }}" class="text-info">詳細</a>
                        </span>
                    </td>
                    <td>
                        <a class="text-danger" href="javascript:void(0);"><i class="ti ti-trash ms-2"></i></a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
{{ $users->links() }}