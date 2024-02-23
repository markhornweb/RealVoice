<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <small class="mb-1 d-block text-muted">現在のユーザー数</small>
            @if($activeUserCount - ($allUsersCount - $activeUserCount) < 0)
                <p class="card-text text-primary">{{ $activeUserCount - ($allUsersCount - $activeUserCount) }}名</p>
            @else
                <p class="card-text text-success">{{ $activeUserCount - ($allUsersCount - $activeUserCount) }}名</p>
            @endif
        </div>
        <h4 class="mb-1 card-title">{{ $allUsersCount }}名</h4>
    </div>
    <div class="card-body">
        <div class="row">
        <div class="col-5">
            <div class="gap-2 mb-2 d-flex align-items-center">
            <span class="p-1 rounded badge bg-label-info"><i class="ti ti-users ti-xs"></i></span>
            <p class="mb-0">活動</p>
            </div>
            <h5 class="pt-1 mb-0 text-nowrap">{{ $activeUserCount / $allUsersCount * 100 }}%</h5>
            <small class="text-muted">{{ $activeUserCount }}名</small>
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
            <span class="p-1 rounded badge bg-label-primary"><i class="ti ti-users ti-xs"></i></span>
            </div>
            <h5 class="pt-1 mb-0 text-nowrap ms-lg-n3 ms-xl-0">{{ ($allUsersCount - $activeUserCount) / $allUsersCount * 100 }}%</h5>
            <small class="text-muted">{{ $allUsersCount - $activeUserCount }}名</small>
        </div>
        </div>
        <div class="mt-4 d-flex align-items-center">
        <div class="progress w-100" style="height: 8px;">
            <div class="progress-bar bg-info" style="width: {{ $activeUserCount / $allUsersCount * 100 }}%" role="progressbar" aria-valuenow="{{ $activeUserCount / $allUsersCount * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($allUsersCount - $activeUserCount) / $allUsersCount * 100 }}%" aria-valuenow="{{ ($allUsersCount - $activeUserCount) / $allUsersCount * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        </div>
    </div>
</div>