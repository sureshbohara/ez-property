<li class="ui-sortable-handle" 
    data-title="{{ $item->title }}" 
    data-url="{{ $item->url }}" 
    data-type="{{ $item->type }}" 
    id="item_{{ $item->id ?? uniqid() }}">
    
    <div class="menu-item-box d-flex justify-content-between align-items-center p-2 bg-white border rounded">
        <div class="d-flex align-items-center">
            <i class="bi bi-grip-vertical text-muted me-2" style="cursor: move; font-size: 1.2rem;"></i>
            <div>
                <strong>{{ $item->title }}</strong> 
                <span class="badge bg-secondary ms-1">{{ $item->type }}</span>
                <div class="text-muted small">{{ $item->url }}</div>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger remove-btn">
            <i class="bi bi-x"></i>
        </button>
    </div>
    
    @if($item->children && $item->children->isNotEmpty())
        <ul class="sub-menu list-unstyled">
            @foreach($item->children as $child)
                @include('admin.menu.partials.menu-item', ['item' => $child])
            @endforeach
        </ul>
    @else
        <ul class="sub-menu list-unstyled"></ul>
    @endif
</li>