@extends('Layout.admin')
@section('title', 'Edit Category')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.categories.index') }}" style="width:36px;height:36px;border:1px solid var(--border-color);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
        <i class="fa-solid fa-arrow-left" style="font-size:13px;"></i>
    </a>
    <div>
        <h4 class="mb-0" style="font-weight:700;">Edit Category</h4>
        <p class="text-secondary mb-0" style="font-size:13px;">Editing: {{ $category->name }}</p>
    </div>
</div>

@if($errors->any())
<div style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);border-radius:8px;padding:14px 18px;margin-bottom:20px;">
    <ul class="mb-0" style="color:#f87171;font-size:13px;padding-left:18px;">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.categories.update', $category) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-6">
            <div class="admin_card mb-4">
                <div class="admin_card_header">
                    <i class="fa-solid fa-pen-to-square me-2" style="color:var(--accent)"></i> Category Details
                </div>
                <div class="admin_card_body">
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Category Name *</label>
                        <input type="text" name="name" class="form-control admin_form_control" value="{{ old('name', $category->name) }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Current Slug</label>
                        <div>
                            <code style="background:rgba(255,255,255,0.05);padding:6px 12px;border-radius:6px;color:#cbd5e1;font-size:13px;display:inline-block;">{{ $category->slug }}</code>
                        </div>
                        <p class="text-secondary mt-1 mb-0" style="font-size:12px;">The slug will automatically update if you change the category name.</p>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="admin_btn_primary" style="border:none;cursor:pointer;">
                            <i class="fa-solid fa-check me-1"></i> Update Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;font-size:14px;padding:9px 18px;">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
