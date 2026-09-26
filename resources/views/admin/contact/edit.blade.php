@extends('Layout.admin')
@section('title', 'Edit: ' . $label)

@section('content')

    {{-- Back button + title --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.contact-cms.index') }}"
            style="width:36px;height:36px;border:1px solid var(--border-color);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
            <i class="fa-solid fa-arrow-left" style="font-size:13px;"></i>
        </a>
        <div>
            <h4 class="mb-0" style="font-weight:700;">Edit: {{ $label }}</h4>
            <p class="text-secondary mb-0" style="font-size:12px;">Section key: <code
                    style="color:var(--accent);">{{ $section }}</code></p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.contact-cms.update', $section) }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- LEFT: text fields --}}
            <div class="{{ $section === 'contact_banner' ? 'col-lg-7' : 'col-lg-8' }}">
                <div class="admin_card">
                    <div class="admin_card_header">
                        <i class="fa-solid fa-pen-to-square me-2" style="color:var(--accent)"></i> Content Fields
                    </div>
                    <div class="admin_card_body">

                        {{-- ══ TOP BANNER & HEADING ═══════════════════════════ --}}
                        @if($section === 'contact_banner')
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Page
                                    Title / Heading</label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title ?? 'contact us') }}" placeholder="contact us">
                                <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">Displays as
                                    the main title below the top banner image.</small>
                            </div>
                            <p style="color:var(--text-muted);font-size:13px;">Upload the top banner image on the right panel.</p>

                        {{-- ══ CONTACT DETAILS HEADER ═════════════════════════ --}}
                        @elseif($section === 'contact_header')
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Section
                                    Title</label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title ?? 'Contact Details') }}" placeholder="Contact Details">
                            </div>
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Intro
                                    Paragraph / Subtitle</label>
                                <textarea name="subtitle" rows="4" class="form-control admin_form_control"
                                    placeholder="Dolor sit amet, consectetur adipisicing elit...">{{ old('subtitle', $content->subtitle ?? 'Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempori lorum ncididunt ut labore et laboris nisi ut aliquip ex ea commodo consequat.') }}</textarea>
                            </div>

                        {{-- ══ LOCATION ADDRESS CARD ══════════════════════════ --}}
                        @elseif($section === 'contact_location')
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Card
                                    Title</label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title ?? 'Location Address') }}" placeholder="Location Address">
                            </div>
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Address
                                    / Location Details</label>
                                <textarea name="description" rows="4" class="form-control admin_form_control"
                                    placeholder="Enter physical address...">{{ old('description', $content->description ?? 'Ipsum dolor sit amet, consectetur adipisicing elit, sed do') }}</textarea>
                            </div>

                        {{-- ══ PHONE CONTACT CARD ═════════════════════════════ --}}
                        @elseif($section === 'contact_phone')
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Card
                                    Title</label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title ?? 'Phone Contact') }}" placeholder="Phone Contact">
                            </div>
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Phone
                                    Numbers (HTML/line breaks supported)</label>
                                <textarea name="description" rows="4" class="form-control admin_form_control"
                                    placeholder="Tel: (00) 123 456 7890&#10;Fax: (00) 123 456 7891">{{ old('description', $content->description ?? "Tel: (00) 123 456 7890\nFax: (00) 123 456 7891") }}</textarea>
                                <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">You can put multiple numbers on separate lines.</small>
                            </div>

                        {{-- ══ EMAIL CONTACT CARD ═════════════════════════════ --}}
                        @elseif($section === 'contact_email')
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Card
                                    Title</label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title ?? 'Email Contact') }}" placeholder="Email Contact">
                            </div>
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Email
                                    Addresses</label>
                                <textarea name="description" rows="4" class="form-control admin_form_control"
                                    placeholder="info@example.com&#10;support@example.com">{{ old('description', $content->description ?? "Example.@gmail.com\nExample.@gmail.com") }}</textarea>
                                <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">You can put multiple email addresses on separate lines.</small>
                            </div>

                        {{-- ══ HAVE A QUESTION FORM HEADER ════════════════════ --}}
                        @elseif($section === 'contact_form_intro')
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Section
                                    Title</label>
                                <input type="text" name="title" class="form-control admin_form_control"
                                    value="{{ old('title', $content->title ?? 'Have A Question For Us') }}" placeholder="Have A Question For Us">
                            </div>
                            <div class="mb-4">
                                <label class="form-label"
                                    style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Subtitle
                                    / Description</label>
                                <textarea name="subtitle" rows="4" class="form-control admin_form_control"
                                    placeholder="Dolor sit amet, consectetur adipisicing elit...">{{ old('subtitle', $content->subtitle ?? 'Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempori lorum ncididunt ut labore et laboris nisi ut aliquip ex ea commodo consequat.') }}</textarea>
                            </div>
                        @endif

                        @if($section !== 'contact_banner')
                            <div class="mt-4">
                                <button type="submit" class="admin_btn_primary" style="padding:12px 28px;font-size:15px;">
                                    <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                                </button>
                                <a href="{{ route('admin.contact-cms.index') }}" class="ms-3"
                                    style="color:var(--text-muted);font-size:13px;text-decoration:none;">Cancel</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- RIGHT: image upload only for contact_banner --}}
            @if($section === 'contact_banner')
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
                        <a href="{{ route('admin.contact-cms.index') }}" style="color:var(--text-muted);font-size:13px;text-decoration:none;">
                            &larr; Back to Contact sections
                        </a>
                    </div>

                </div>
            @endif

        </div>

    </form>

@endsection
