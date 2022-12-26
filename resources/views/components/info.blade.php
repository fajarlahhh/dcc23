<div>
    @if (session()->has('message'))
        @php
            $alert = explode('|', session('message'));
        @endphp
        <div class="alert alert-{{ $alert[0] }} alert-dismissible show flex items-center mb-2 mt-4" role="alert">
            <i data-feather="alert-circle" class="w-6 h-6 mr-2"></i>
            {{ $alert[1] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i data-feather="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif
</div>
