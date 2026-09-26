@extends('Layout.admin')
@section('title', 'Add Testimonial')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.testimonials.index') }}" style="width:36px;height:36px;border:1px solid var(--border-color);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
        <i class="fa-solid fa-arrow-left" style="font-size:13px;"></i>
    </a>
    <h4 class="mb-0" style="font-weight:700;">Add New Testimonial</h4>
</div>

@if($errors->any())
<div style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);border-radius:8px;padding:14px 18px;margin-bottom:20px;">
    <ul class="mb-0" style="color:#f87171;font-size:13px;padding-left:18px;">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">

        {{-- Left: main fields --}}
        <div class="col-lg-8">
            <div class="admin_card mb-4">
                <div class="admin_card_header">
                    <i class="fa-solid fa-comment-dots me-2" style="color:var(--accent)"></i> Customer &amp; Review Info
                </div>
                <div class="admin_card_body">
                    
                    {{-- Customer Name --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Customer Name *</label>
                        <input type="text" name="name" class="form-control admin_form_control" value="{{ old('name') }}" placeholder="e.g. Ann Peterson" required>
                    </div>

                    {{-- Customer Role / Designation --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Role / Designation</label>
                        <input type="text" name="role" class="form-control admin_form_control" value="{{ old('role') }}" placeholder="e.g. Senior Director, Interior Designer, Verified Buyer">
                    </div>

                    {{-- Review Paragraph --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Review / Feedback *</label>
                        <textarea name="review" rows="5" class="form-control admin_form_control" placeholder="Write what the customer said about your products or service..." required>{{ old('review') }}</textarea>
                    </div>

                    <div class="row g-3">
                        {{-- Star Rating --}}
                        <div class="col-sm-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Rating (1 to 5) *</label>
                            <select name="rating" class="form-control admin_form_control" required>
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Good</option>
                                <option value="3">3 - Average</option>
                                <option value="2">2 - Poor</option>
                                <option value="1">1 - Very Poor</option>
                            </select>
                        </div>



                        {{-- Active Status Checkbox --}}
                        <div class="col-sm-6 d-flex align-items-center" style="padding-top:24px;">
                            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                                <input type="checkbox" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}
                                    style="width:18px;height:18px;accent-color:var(--accent);">
                                <span style="font-size:14px;font-weight:600;">Active / Visible on Website</span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Right: customer avatar/photo --}}
        <div class="col-lg-4">
            <div class="admin_card mb-4">
                <div class="admin_card_header">
                    <i class="fa-solid fa-user me-2" style="color:var(--accent)"></i> Customer Photo
                </div>
                <div class="admin_card_body">
                    <div style="background:rgba(255,255,255,0.03);border:1px dashed var(--border-color);border-radius:10px;padding:24px;text-align:center;margin-bottom:14px;" id="imgPlaceholder">
                        <i class="fa-solid fa-circle-user" style="font-size:38px;color:var(--text-muted);margin-bottom:8px;display:block;"></i>
                        <p style="color:var(--text-muted);font-size:13px;margin:0;">Upload customer avatar / photo</p>
                    </div>
                    <div id="imgPreviewWrap" style="display:none;margin-bottom:14px;border-radius:10px;overflow:hidden;border:1px solid var(--accent);text-align:center;">
                        <img id="imgPreview" src="" style="width:120px;height:120px;border-radius:50%;object-fit:cover;margin:15px auto;display:block;">
                    </div>
                    <input type="file" name="image" accept="image/*" class="form-control admin_form_control" onchange="previewImg(this)">
                    <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">Saved to storage. Max 2MB. JPG, PNG, WebP.</small>
                </div>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="admin_btn_primary" style="font-size:15px;padding:14px;border-radius:10px;">
                    <i class="fa-solid fa-plus me-2"></i> Save Testimonial
                </button>
            </div>
        </div>

    </div>
</form>

@endsection

@section('extra_styles')
<script>
function previewImg(input) {
    const wrap = document.getElementById('imgPreviewWrap');
    const ph   = document.getElementById('imgPlaceholder');
    const img  = document.getElementById('imgPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            wrap.style.display = 'block';
            ph.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
