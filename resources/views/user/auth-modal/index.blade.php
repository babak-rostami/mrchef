@guest
    <x-modal id="user-login" bg="{{ asset('files/images/login.jpg') }}">
        @include('user.auth-modal.check-email')
        @include('user.auth-modal.register')
        @include('user.auth-modal.login')
        @include('user.auth-modal.forgot')
    </x-modal>
@endguest
