<div class="input-group mb-2 highlightTitleItem">
    <input type="text" name="highlight[sections][]" class="form-control" 
           placeholder="Enter highlight title..." 
           value="{{ old("highlight.sections.$index", $title ?? '') }}">
    <button type="button" class="btn btn-outline-danger removeHighlightTitle" title="Remove">
        <i class="bi bi-trash"></i>
    </button>
</div>