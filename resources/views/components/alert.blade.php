<div>
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible show flex items-center mb-2 mt-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i data-feather="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif
</div>
