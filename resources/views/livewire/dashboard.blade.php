<div>
    <x-info />
    <x-alert />
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Dashboard
        </h2>
    </div>
    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-6 intro-y">
            <div class="input-group mt-2 width-full">
                <div class="input-group-text">
                    Left Referral
                </div>
                <input type="text" class="form-control" placeholder="Price" disabled
                    value="{{ url('/registration/' . auth()->user()->username . '/l') }}">
                <button onclick="copyUrl('{{ url('/registration/' . auth()->user()->username . '/l') }}')"
                    class="btn input-group-text">
                    Copy
                </button>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-6 intro-y">
            <div class="input-group mt-2 width-full">
                <div class="input-group-text">
                    Right Referral
                </div>
                <input type="text" class="form-control" placeholder="Price" disabled
                    value="{{ url('/registration/' . auth()->user()->username . '/r') }}">
                <button onclick="copyUrl('{{ url('/registration/' . auth()->user()->username . '/r') }}')"
                    class="btn input-group-text">
                    Copy
                </button>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function copyUrl(text) {
                navigator.clipboard.writeText(text);
                alert("Copied the text: " + text);
            }
        </script>
    @endpush
</div>
