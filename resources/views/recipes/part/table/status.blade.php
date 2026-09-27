@if ($row->is_read)
    @include('components.helper.badge', [
        'title' => 'خوانده‌شده',
        'class' => 'success',
    ])
@else
    @include('components.helper.badge', [
        'title' => 'جدید',
        'class' => 'danger',
    ])
@endif