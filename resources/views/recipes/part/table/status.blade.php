@if ($row->status == 0)
    @include('components.helper.badge', [
        'title' => 'تایید نشده',
        'class' => 'danger',
    ])
@elseif($row->status == 1)
    @include('components.helper.badge', [
        'title' => 'تایید شده',
        'class' => 'success',
    ])
@elseif($row->status == 2)
    @include('components.helper.badge', [
        'title' => 'در انتظار',
        'class' => 'warning',
    ])
@endif
