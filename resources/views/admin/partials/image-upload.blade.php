{{-- Variables: $id (string), $existing (string|null current image URL) --}}
<div class="grid gap-3">
    <div id="preview-{{ $id }}" class="overflow-hidden rounded-lg {{ $existing ? '' : 'hidden' }}" style="max-height:180px">
        <img class="w-full object-cover" style="max-height:180px" src="{{ $existing ?? '' }}" alt="Preview foto">
    </div>

    <label class="flex cursor-pointer items-center gap-3 rounded-lg border-2 border-dashed border-sd-primary/30 bg-[#fff8f4] p-3 transition-colors hover:border-sd-primary hover:bg-sd-soft/40">
        <svg width="18" height="18" class="shrink-0 text-sd-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span class="upload-label-text text-sm font-extrabold text-sd-ink-soft">{{ $existing ? 'Ganti foto' : 'Pilih foto' }}</span>
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewUpload(this, 'preview-{{ $id }}')">
    </label>

    <p class="text-xs text-sd-muted">JPG, PNG, WebP &middot; Maks. 2 MB</p>
    <input type="hidden" name="image_url_fallback" value="{{ $existing ?? '' }}">
</div>
