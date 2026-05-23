{{-- Variables: $id (string for unique element IDs), $existing (string|null, current image URL) --}}
<div class="upload-wrap">
    <div class="upload-current" id="preview-{{ $id }}"@if(!$existing) style="display:none"@endif>
        <img src="{{ $existing ?? '' }}" alt="Preview foto">
    </div>

    <label class="upload-label">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span class="upload-label-text">{{ $existing ? 'Ganti foto' : 'Pilih foto' }}</span>
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
               class="sr-only"
               onchange="previewUpload(this, 'preview-{{ $id }}')">
    </label>

    <p class="upload-hint">JPG, PNG, WebP &middot; Maks. 2 MB</p>

    <input type="hidden" name="image_url_fallback" value="{{ $existing ?? '' }}">
</div>
