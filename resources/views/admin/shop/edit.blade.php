@extends('Layout.admin')
@section('title', 'Edit: ' . $label)

@section('content')

    {{-- Back button + title --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.shop.index') }}"
            style="width:36px;height:36px;border:1px solid var(--border-color);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
            <i class="fa-solid fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h4 class="mb-0" style="font-weight:700;">Edit: {{ $label }}</h4>
            <p class="text-secondary mb-0" style="font-size:12px;">Section key: <code
                    style="color:var(--accent);">{{ $section }}</code></p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.shop.update', $section) }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- LEFT: text fields --}}
            <div class="col-lg-7">
                <div class="admin_card">
                    <div class="admin_card_header">
                        <i class="fa-solid fa-pen-to-square me-2" style="color:var(--accent)"></i> Content Fields
                    </div>
                    <div class="admin_card_body">

                        <div class="mb-4">
                            <label class="form-label"
                                style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                Page Title / Heading
                            </label>
                            <input type="text" name="title" class="form-control admin_form_control"
                                value="{{ old('title', $content->title ?? 'shop') }}" placeholder="e.g. shop">
                            <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">
                                Displays as the main heading below the top banner on the Shop page.
                            </small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"
                                style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                Subtitle / Promotional Announcement (Optional)
                            </label>
                            <textarea name="subtitle" rows="3" class="form-control admin_form_control"
                                placeholder="e.g. Explore our premium kitchenware collection with handcrafted quality.">{{ old('subtitle', $content->subtitle ?? '') }}</textarea>
                            <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">
                                Optional descriptive sub-heading displayed right below the shop title.
                            </small>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT: image upload --}}
            <div class="col-lg-5">
                <div class="admin_card">
                    <div class="admin_card_header">
                        <i class="fa-solid fa-image me-2" style="color:var(--accent)"></i> Top Banner Image
                    </div>
                    <div class="admin_card_body">

                        {{-- Current Image Preview --}}
                        <div class="mb-4 text-center">
                            @if($content->image)
                                <img src="{{ asset('storage/' . $content->image) }}" alt="Current Banner"
                                    style="max-width:100%;max-height:160px;object-fit:cover;border-radius:10px;border:1px solid var(--border-color);margin-bottom:10px;">
                                <div style="font-size:12px;color:var(--text-muted);">Current active banner</div>
                            @else
                                <div
                                    style="height:120px;border:2px dashed var(--border-color);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;color:var(--text-muted);">
                                    <i class="fa-solid fa-image" style="font-size:28px;"></i>
                                    <span style="font-size:12px;">No custom banner uploaded yet.<br>Default site banner is currently shown.</span>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"
                                style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Upload
                                New Banner</label>
                            <input type="file" name="image" class="form-control admin_form_control" accept="image/*">
                            <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">Max 4MB. JPG, PNG, WebP. Leave blank to keep current image.</small>
                        </div>

                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-3">
                    <button type="submit" class="admin_btn_primary w-100" style="padding:12px;font-size:15px;justify-content:center;">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                    </button>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.shop.index') }}" style="color:var(--text-muted);font-size:13px;text-decoration:none;">
                        &larr; Back to Shop sections
                    </a>
                </div>

            </div>

        </div>

    </form>

@endsection
