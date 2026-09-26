@extends('Layout.admin')
@section('title', 'Edit Product')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.products.index') }}" style="width:36px;height:36px;border:1px solid var(--border-color);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
        <i class="fa-solid fa-arrow-left" style="font-size:13px;"></i>
    </a>
    <div>
        <h4 class="mb-0" style="font-weight:700;">Edit Product: {{ $product->name }}</h4>
        <small style="color:var(--text-muted);">Slug: {{ $product->slug }}</small>
    </div>
</div>

@if($errors->any())
<div style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);border-radius:8px;padding:14px 18px;margin-bottom:20px;">
    <ul class="mb-0" style="color:#f87171;font-size:13px;padding-left:18px;">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">

        {{-- Left: main fields --}}
        <div class="col-lg-8">
            <div class="admin_card mb-4">
                <div class="admin_card_header"><i class="fa-solid fa-box me-2" style="color:var(--accent)"></i> Product Info</div>
                <div class="admin_card_body">
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Product Name *</label>
                        <input type="text" name="name" id="nameInput" class="form-control admin_form_control" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Short Description</label>
                        <input type="text" name="short_description" class="form-control admin_form_control" value="{{ old('short_description', $product->short_description) }}" placeholder="One-line summary shown in product cards">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Full Description</label>
                        <textarea name="description" rows="5" class="form-control admin_form_control" placeholder="Detailed product description...">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="admin_card">
                <div class="admin_card_header"><i class="fa-solid fa-tag me-2" style="color:var(--accent)"></i> Pricing & Details</div>
                <div class="admin_card_body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Price ($) *</label>
                            <input type="number" name="price" step="0.01" min="0" class="form-control admin_form_control" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Old Price ($) <span style="opacity:.5">optional</span></label>
                            <input type="number" name="old_price" step="0.01" min="0" class="form-control admin_form_control" value="{{ old('old_price', $product->old_price) }}" placeholder="Shows strikethrough">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Category *</label>
                            <select name="category_id" class="form-control admin_form_control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Brand</label>
                            <input type="text" name="brand" class="form-control admin_form_control" value="{{ old('brand', $product->brand ?? 'Crest & Clove') }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Stock Quantity *</label>
                            <input type="number" name="stock_quantity" min="0" class="form-control admin_form_control" value="{{ old('stock_quantity', $product->stock_quantity ?? 50) }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Stock Status *</label>
                            <select name="stock_status" class="form-control admin_form_control" required>
                                <option value="In Stock" {{ old('stock_status', $product->stock_status) == 'In Stock' ? 'selected' : '' }}>In Stock</option>
                                <option value="Out of Stock" {{ old('stock_status', $product->stock_status) == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                        <div class="col-sm-6 d-flex align-items-center" style="padding-top:24px;">
                            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                    style="width:18px;height:18px;accent-color:var(--accent);">
                                <span style="font-size:14px;font-weight:600;">Mark as Featured</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: image --}}
        <div class="col-lg-4">
            <div class="admin_card mb-4">
                <div class="admin_card_header"><i class="fa-solid fa-image me-2" style="color:var(--accent)"></i> Product Image</div>
                <div class="admin_card_body">
                    <div style="margin-bottom:14px;border-radius:10px;overflow:hidden;border:1px solid var(--border-color);background:#1a1c23;" id="currentImgWrap">
                        <img id="imgPreview" src="{{ $product->image_url }}" style="width:100%;max-height:220px;object-fit:cover;display:block;">
                    </div>
                    <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Change Image</label>
                    <input type="file" name="image" accept="image/*" class="form-control admin_form_control" onchange="previewImg(this)">
                    <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block;">Leave empty to keep current image. Max 4MB. JPG, PNG, WebP.</small>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="admin_btn_primary" style="font-size:15px;padding:14px;border-radius:10px;">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;padding:12px;color:var(--text-muted);border-color:var(--border-color);">Cancel</a>
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
