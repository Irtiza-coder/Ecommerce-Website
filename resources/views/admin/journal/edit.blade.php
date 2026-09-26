@extends('Layout.admin')
@section('title', 'Edit: ' . $label)

@section('content')

    {{-- Back button + title --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.journal.index') }}"
            style="width:36px;height:36px;border:1px solid var(--border-color);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
            <i class="fa-solid fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h4 class="mb-0" style="font-weight:700;">Edit: {{ $label }}</h4>
            <p class="text-secondary mb-0" style="font-size:12px;">Section key: <code
                    style="color:var(--accent);">{{ $section }}</code></p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.journal.update', $section) }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- LEFT: text fields --}}
            <div class="col-lg-7">
                <div class="admin_card">
                    <div class="admin_card_header">
                        <i class="fa-solid fa-pen-to-square me-2" style="color:var(--accent)"></i> Content Fields
                    </div>
                    <div class="admin_card_body">

                        {{-- ══ TOP BANNER & HEADING ═══════════════════════════ --}}
                        @if($section === 'journal_banner')
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Page
                                    Title / Heading</label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title ?? 'journal') }}" placeholder="journal">
                                <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">Displays as
                                    the main title below the top banner image.</small>
                            </div>
                            <p style="color:var(--text-muted);font-size:13px;">Upload the top banner image on the right panel.</p>

                        {{-- ══ JOURNAL ARTICLE POSTS ══════════════════════════ --}}
                        @else
                            @php
                                $defaultTitle = match($section) {
                                    'journal_post1' => 'Cooking & Techniques',
                                    'journal_post2' => 'Recipes & Bakery',
                                    'journal_post3' => 'Product Care & Use',
                                    default => 'Article Title',
                                };
                            @endphp
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Article
                                    Title</label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title ?? $defaultTitle) }}"
                                    placeholder="Article Title">
                            </div>

                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Article
                                    Description / Content</label>
                                <textarea name="description" rows="6" class="form-control admin_form_control"
                                    placeholder="Enter article text here...">{{ old('description', $content->description ?? 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.') }}</textarea>
                                <small style="color:var(--text-muted);font-size:12px;">Paragraph text displayed for this journal article.</small>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- RIGHT: image upload --}}
            <div class="col-lg-5">
                <div class="admin_card">
                    <div class="admin_card_header">
                        <i class="fa-solid fa-image me-2" style="color:var(--accent)"></i>
                        @if($section === 'journal_banner') Banner Image
                        @else Article Image
                        @endif
                    </div>
                    <div class="admin_card_body">

                        @if($content->image)
                            <div class="mb-3">
                                <label
                                    style="font-size:12px;color:var(--text-muted);text-transform:uppercase;font-weight:600;letter-spacing:.5px;">Current
                                    Custom Image</label>
                                <div
                                    style="margin-top:8px;border-radius:10px;overflow:hidden;border:1px solid var(--border-color);">
                                    <img src="{{ asset('storage/' . $content->image) }}" alt=""
                                        style="width:100%;max-height:200px;object-fit:cover;display:block;">
                                </div>
                            </div>
                        @else
                            <div
                                style="background:rgba(255,255,255,0.03);border:1px dashed var(--border-color);border-radius:10px;padding:24px;text-align:center;margin-bottom:16px;">
                                <i class="fa-solid fa-image"
                                    style="font-size:26px;color:var(--text-muted);margin-bottom:8px;display:block;"></i>
                                <p style="color:var(--text-muted);font-size:12px;margin:0;">No custom image uploaded
                                    yet.<br>Default site image is currently active.</p>
                            </div>
                        @endif

                        <div>
                            <label class="form-label"
                                style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Upload
                                New Image</label>
                            <input type="file" name="image" accept="image/*" class="form-control admin_form_control"
                                onchange="previewImg(this)">
                            <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">Max 4MB.
                                JPG, PNG, WebP. Leave blank to keep current.</small>
                            <div id="imgPreviewWrap" style="display:none;margin-top:14px;">
                                <label
                                    style="font-size:12px;color:var(--text-muted);text-transform:uppercase;font-weight:600;letter-spacing:.5px;">Preview</label>
                                <div
                                    style="margin-top:8px;border-radius:10px;overflow:hidden;border:1px solid var(--accent);">
                                    <img id="imgPreview" src="" alt=""
                                        style="width:100%;max-height:200px;object-fit:cover;display:block;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Save button --}}
                <div class="d-grid mt-3">
                    <button type="submit" class="admin_btn_primary" style="font-size:15px;padding:14px;border-radius:10px;">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                    </button>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('admin.journal.index') }}"
                        style="color:var(--text-muted);font-size:13px;text-decoration:none;">
                        ← Back to Journal sections
                    </a>
                </div>
            </div>

        </div>
    </form>

@endsection

@section('extra_styles')
    <script>
        function previewImg(input) {
            const wrap = document.getElementById('imgPreviewWrap');
            const img = document.getElementById('imgPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { img.src = e.target.result; wrap.style.display = 'block'; };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
