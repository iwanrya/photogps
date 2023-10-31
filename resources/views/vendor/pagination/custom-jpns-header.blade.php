@if ($paginator->hasPages())
<nav class="d-flex justify-items-center justify-content-between">
    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
        <div>
            <p class="small text-muted">
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {!! __('pagination.results') !!}
            </p>
        </div>
    </div>
</nav>
@endif