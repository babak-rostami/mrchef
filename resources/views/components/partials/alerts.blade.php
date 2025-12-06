@if ($errors->any())
    <div class="bg-red-100 border border-red-300 text-red-700 rounded-xl p-4 mb-4 relative">
        <ul class="list-disc pr-5">
            @foreach ($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>

        <button type="button" class="absolute left-3 top-3 text-red-600" onclick="this.parentElement.remove()">
            ✕
        </button>
    </div>
@endif

@if (session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 rounded-xl p-4 mb-4 relative">
        <i class="fa fa-check-circle ml-1"></i>
        {{ session('success') }}

        <button type="button" class="absolute left-3 top-3 text-green-700" onclick="this.parentElement.remove()">
            ✕
        </button>
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 rounded-xl p-4 mb-4 relative">
        <i class="fa fa-exclamation-triangle ml-1"></i>
        {{ session('error') }}

        <button type="button" class="absolute left-3 top-3 text-red-700" onclick="this.parentElement.remove()">
            ✕
        </button>
    </div>
@endif

@if (session('warning'))
    <div class="bg-yellow-100 border border-yellow-300 text-yellow-700 rounded-xl p-4 mb-4 relative">
        <i class="fa fa-info-circle ml-1"></i>
        {{ session('warning') }}

        <button type="button" class="absolute left-3 top-3 text-yellow-700" onclick="this.parentElement.remove()">
            ✕
        </button>
    </div>
@endif

@if (session('info'))
    <div class="bg-blue-100 border border-blue-300 text-blue-700 rounded-xl p-4 mb-4 relative">
        <i class="fa fa-info-circle ml-1"></i>
        {{ session('info') }}

        <button type="button" class="absolute left-3 top-3 text-blue-700" onclick="this.parentElement.remove()">
            ✕
        </button>
    </div>
@endif
