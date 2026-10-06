@if ($row->content)
    @include('components.helper.badge', [
        'title' => 'ویرایش‌شده',
        'class' => 'success',
    ])
@else
    @include('components.helper.badge', [
        'title' => 'ویرایش‌نشده',
        'class' => 'warning',
    ])
@endif