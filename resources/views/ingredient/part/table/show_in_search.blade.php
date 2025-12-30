@if ($row->show_in_search == 1)
    @include('components.helper.badge', [
        'title' => 'دارد',
        'class' => 'success',
    ])
@else
    @include('components.helper.badge', [
        'title' => 'ندارد',
        'class' => 'danger',
    ])
@endif
