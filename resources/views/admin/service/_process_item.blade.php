<div class="card card-body mb-3 border processItem bg-light">
    <div class="d-flex justify-content-between mb-2">
        <span class="fw-bold">Step #{{ $index + 1 }}</span>
        <button type="button" class="btn btn-sm btn-danger removeProcessItem">Remove</button>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Title</label>
            <input type="text" name="process_item[{{ $index }}][title]" class="form-control"
                   value="{{ old("process_item.$index.title", $item['title'] ?? '') }}" placeholder="Step title">
        </div>
        <div class="col-md-6">
            <label class="form-label">Image</label>
            <input type="file" name="process_item[{{ $index }}][image]" class="form-control" accept="image/*">

            @if(isset($item['image']) && is_string($item['image']) && !empty($item['image']))
                <small class="text-muted d-block mt-1">Current: {{ basename($item['image']) }}</small>
            @elseif(isset($item['image']) && is_array($item['image']) && !empty($item['image']['name']))
                <small class="text-muted d-block mt-1">New file: {{ $item['image']['name'] }}</small>
            @endif
        </div>
        <div class="col-12">
            <label class="form-label">Content</label>
            <textarea name="process_item[{{ $index }}][content]" class="form-control" rows="2" placeholder="Brief description">{{ old("process_item.$index.content", $item['content'] ?? '') }}</textarea>
        </div>
    </div>
</div>