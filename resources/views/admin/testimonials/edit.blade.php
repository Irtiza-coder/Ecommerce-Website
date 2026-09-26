@extends('Layout.admin')
@section('title', 'Edit Testimonial')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.testimonials.index') }}" style="width:36px;height:36px;border:1px solid var(--border-color);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
        <i class="fa-solid fa-arrow-left" style="font-size:13px;"></i>
    </a>
    <div>
        <h4 class="mb-0" style="font-weight:700;">Edit Testimonial: {{ $testimonial->name }}</h4>
        <small style="color:var(--text-muted);">Manage review details and status</small>
    </div>
</div>

@if($errors->any())
<div style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);border-radius:8px;padding:14px 18px;margin-bottom:20px;">
    <ul class="mb-0" style="color:#f87171;font-size:13px;padding-left:18px;">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
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
                        <input type="text" name="name" class="form-control admin_form_control" value="{{ old('name', $testimonial->name) }}" required>
                    </div>

                    {{-- Customer Role / Designation --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Role / Designation</label>
                        <input type="text" name="role" class="form-control admin_form_control" value="{{ old('role', $testimonial->role) }}" placeholder="e.g. Senior Director, Interior Designer, Verified Buyer">
                    </div>

                    {{-- Review Paragraph --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Review / Feedback *</label>
                        <textarea name="review" rows="5" class="form-control admin_form_control" required>{{ old('review', $testimonial->review) }}</textarea>
                    </div>

                    <div class="row g-3">
                        {{-- Rating --}}
                        <div class="col-sm-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Rating (1 to 5) *</label>
                            <select name="rating" class="form-control admin_form_control" required>
                                <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>5 - Excellent</option>
                                <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>4 - Good</option>
                                <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>3 - Average</option>
                                <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>2 - Poor</option>
                                <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>1 - Very Poor</option>
                            </select>
                        </div>

                        {{-- Active Status Checkbox --}}
                        <div class="col-sm-6 d-flex align-items-center" style="padding-top:24px;">
                            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                                <input type="checkbox" name="status" value="1" {{ old('status', $testimonial->status) ? 'checked' : '' }}
                                    style="width:18px;height:18px;accent-color:var(--accent);">
                                <span style="font-size:14px;font-weight:600;">Active / Visible on Website</span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Right: customer photo --}}
        <div class="col-lg-4">
            <div class="admin_card mb-4">
                <div class="admin_card_header">
                    <i class="fa-solid fa-user me-2" style="color:var(--accent)"></i> Customer Photo
                </div>
                <div class="admin_card_body text-center">
                    <div style="margin-bottom:14px;border-radius:10px;overflow:hidden;border:1px solid var(--border-color);background:#1a1c23;padding:15px;" id="currentImgWrap">
                        <img id="imgPreview" 
                             src="{{ $testimonial->image ? asset('storage/' . $testimonial->image) : asset('images/Layer_23_copy_5.png') }}" 
                             style="width:110px;height:110px;border-radius:50%;object-fit:cover;margin:0 auto;display:block;border:2px solid var(--accent);">
                    </div>
                    <label class="form-label text-start d-block" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Change Photo</label>
                    <input type="file" name="image" accept="image/*" class="form-control admin_form_control" onchange="previewImg(this)">
                    <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">Leave empty to keep current photo. Max 2MB. JPG, PNG, WebP.</small>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="admin_btn_primary" style="font-size:15px;padding:14px;border-radius:10px;">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Update Testimonial
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;padding:12px;color:var(--text-muted);border-color:var(--border-color);">Cancel</a>
            </div>
        </div>

    </div>
</form>

@endsection

@section('extra_styles')
<script>
function previewImg(input) {
    const img = document.getElementById('imgPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
