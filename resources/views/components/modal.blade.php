<div>
    <div id="modal-{{ strtolower(str_replace(' ', '', $title)) }}" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">{{ $title }}</h1>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
