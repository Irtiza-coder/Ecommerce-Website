@extends('Layout.admin')
@section('title', 'Edit: ' . $label)

@section('content')

    @php
        $sectionsWithImage = ['hero', 'brand_banner', 'catalogue', 'feature1', 'feature2'];
        $hasImage = in_array($section, $sectionsWithImage);
    @endphp

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.homepage.index') }}"
            style="width:36px;height:36px;border:1px solid var(--border-color);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
            <i class="fa-solid fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h4 class="mb-0" style="font-weight:700;">Edit: {{ $label }}</h4>
            <p class="text-secondary mb-0" style="font-size:12px;">Section key: <code
                    style="color:var(--accent);">{{ $section }}</code></p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.homepage.update', $section) }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4 justify-content-start">

            <div class="{{ $hasImage ? 'col-lg-7' : 'col-lg-8' }}">
                <div class="admin_card">
                    <div class="admin_card_header">
                        <i class="fa-solid fa-pen-to-square me-2" style="color:var(--accent)"></i> Content Fields
                    </div>
                    <div class="admin_card_body">

                        @if($section === 'top_bar')
                            <p style="font-size:13px;color:var(--text-muted);margin-bottom:20px;">
                                Customize the top announcement bar displayed at the very top of your website header.
                            </p>

                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="fa-solid fa-bullhorn me-2" style="color:var(--accent)"></i> Center Announcement Text
                                </label>
                                <textarea name="title" rows="2" class="form-control admin_form_control"
                                    placeholder="FREE SHIPPING IN 🇺🇸 FOR THE LOWER 48 ON ORDERS OVER $200.00">{{ old('title', $content->title ?? 'FREE SHIPPING IN 🇺🇸 FOR THE LOWER 48 ON ORDERS OVER $200.00') }}</textarea>
                                <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">
                                    Promotional announcement or banner text displayed in the center.
                                </small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="fa-solid fa-phone me-2" style="color:var(--accent)"></i> Phone Number
                                </label>
                                <input type="text" name="subtitle" class="form-control admin_form_control"
                                    value="{{ old('subtitle', $content->subtitle ?? '123 456 7890') }}"
                                    placeholder="e.g. 123 456 7890 or +1 (555) 123-4567">
                                <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">
                                    Phone number shown on the left side of the top bar.
                                </small>
                            </div>


                        @elseif($section === 'hero')
                            <p style="color:var(--text-muted);font-size:14px;">The hero banner is a full-width image with no
                                text overlay. Upload a new image on the right panel.</p>

                        @elseif($section === 'footer_social')
                            @php
                                $links = explode('|', $content->description ?? '#|#|#|#');
                                $fb = $links[0] ?? '#';
                                $tw = $links[1] ?? '#';
                                $ig = $links[2] ?? '#';
                                $li = $links[3] ?? '#';
                            @endphp
                            <p style="font-size:13px;color:var(--text-muted);margin-bottom:20px;">Enter the full URL for each
                                social profile. Use <code style="color:var(--accent);">#</code> to hide a link.</p>

                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="fa-brands fa-facebook-f me-2" style="color:#1877F2"></i> Facebook URL
                                </label>
                                <input type="text" name="fb_url" class="form-control admin_form_control"
                                    value="{{ old('fb_url', $fb) }}" placeholder="https://facebook.com/yourpage">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="fa-brands fa-x-twitter me-2" style="color:#aaa"></i> Twitter / X URL
                                </label>
                                <input type="text" name="tw_url" class="form-control admin_form_control"
                                    value="{{ old('tw_url', $tw) }}" placeholder="https://twitter.com/yourhandle">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="fa-brands fa-instagram me-2" style="color:#E1306C"></i> Instagram URL
                                </label>
                                <input type="text" name="ig_url" class="form-control admin_form_control"
                                    value="{{ old('ig_url', $ig) }}" placeholder="https://instagram.com/yourprofile">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="fa-brands fa-linkedin-in me-2" style="color:#0A66C2"></i> LinkedIn URL
                                </label>
                                <input type="text" name="li_url" class="form-control admin_form_control"
                                    value="{{ old('li_url', $li) }}" placeholder="https://linkedin.com/in/yourprofile">
                            </div>

                        @elseif($section === 'footer_contact')
                            @php
                                $parts = explode('|', $content->description ?? '|');
                                $contactEmail = $parts[0] ?? '';
                                $contactPhone = $parts[1] ?? '';
                            @endphp
                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="fa-solid fa-location-dot me-2" style="color:var(--accent)"></i> Address
                                </label>
                                <input type="text" name="subtitle" class="form-control admin_form_control"
                                    value="{{ old('subtitle', $content->subtitle) }}"
                                    placeholder="123 Main Street, City, Country">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="fa-solid fa-envelope me-2" style="color:var(--accent)"></i> Email
                                </label>
                                <input type="text" name="contact_email" class="form-control admin_form_control"
                                    value="{{ old('contact_email', $contactEmail) }}" placeholder="info@crestclove.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    <i class="fa-solid fa-phone me-2" style="color:var(--accent)"></i> Phone
                                </label>
                                <input type="text" name="contact_phone" class="form-control admin_form_control"
                                    value="{{ old('contact_phone', $contactPhone) }}" placeholder="(123)-456-7890">
                            </div>

                            {{-- ══ FOOTER COPYRIGHT ═════════════════════════════════ --}}
                        @elseif($section === 'footer_copyright')
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Copyright
                                    Text</label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title) }}" placeholder="© 2026, All Rights Reserved">
                                <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">Appears at
                                    the bottom of every page.</small>
                            </div>


                        @else

                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    @if($section === 'welcome') Small Label (above main title)
                                    @elseif($section === 'footer_subscribe') Subscribe Sub-heading
                                    @else Subtitle
                                    @endif
                                </label>
                                <input type="text" name="subtitle" class="form-control admin_form_control"
                                    value="{{ old('subtitle', $content->subtitle) }}" placeholder="e.g. Welcome To">
                            </div>


                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">
                                    @if($section === 'welcome') Main Heading / Brand Name
                                    @elseif($section === 'footer_subscribe') Section Title
                                    @else Title / Heading
                                    @endif
                                </label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title) }}" placeholder="e.g. CREST&CLOVE">
                            </div>
                            @if(in_array($section, ['welcome', 'feature1', 'feature2', 'catalogue', 'shop_section', 'testimonials']))
                                <div class="mb-4">
                                    <label class="form-label"
                                        style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Description
                                        / Body Text</label>
                                    <textarea name="description" rows="5" class="form-control admin_form_control"
                                        placeholder="Enter paragraph text here...">{{ old('description', $content->description) }}</textarea>
                                    <small style="color:var(--text-muted);font-size:12px;">Paragraph text shown in this
                                        section.</small>
                                </div>
                            @endif

                        @endif


                        @if(!$hasImage)
                            <div class="mt-4 pt-3" style="border-top:1px solid var(--border-color);">
                                <button type="submit" class="admin_btn_primary"
                                    style="font-size:15px;padding:12px 28px;border-radius:10px;">
                                    <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                                </button>
                                <a href="{{ route('admin.homepage.index') }}" class="ms-3"
                                    style="color:var(--text-muted);font-size:13px;text-decoration:none;">
                                    &larr; Back to all sections
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            @if($hasImage)
                <div class="col-lg-5">
                    <div class="admin_card">
                        <div class="admin_card_header">
                            <i class="fa-solid fa-image me-2" style="color:var(--accent)"></i>
                            @if($section === 'hero') Hero Banner Image
                            @elseif($section === 'brand_banner') Brand Banner Image
                            @elseif(str_starts_with($section, 'feature')) Feature Image
                            @elseif($section === 'catalogue') Catalogue Image
                            @else Section Image
                            @endif
                        </div>
                        <div class="admin_card_body">

                            @if($content->image)
                                <div class="mb-3">
                                    <label
                                        style="font-size:12px;color:var(--text-muted);text-transform:uppercase;font-weight:600;letter-spacing:.5px;">Current
                                        Image</label>
                                    <div
                                        style="margin-top:8px;border-radius:10px;overflow:hidden;border:1px solid var(--border-color);">
                                        <img src="{{ asset('storage/' . $content->image) }}" alt=""
                                            style="width:100%;max-height:180px;object-fit:cover;display:block;">
                                    </div>
                                </div>
                            @else
                                <div
                                    style="background:rgba(255,255,255,0.03);border:1px dashed var(--border-color);border-radius:10px;padding:28px;text-align:center;margin-bottom:16px;">
                                    <i class="fa-solid fa-image"
                                        style="font-size:28px;color:var(--text-muted);margin-bottom:8px;display:block;"></i>
                                    <p style="color:var(--text-muted);font-size:13px;margin:0;">No image uploaded yet.<br>Default
                                        site image will be used.</p>
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
                                            style="width:100%;max-height:180px;object-fit:cover;display:block;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Save button on the right --}}
                    <div class="d-grid">
                        <button type="submit" class="admin_btn_primary" style="font-size:15px;padding:14px;border-radius:10px;">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                        </button>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="{{ route('admin.homepage.index') }}"
                            style="color:var(--text-muted);font-size:13px;text-decoration:none;">
                            &larr; Back to all sections
                        </a>
                    </div>
                </div>
            @endif

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