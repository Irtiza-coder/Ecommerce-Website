@extends('Layout.admin')
@section('title', 'Categories')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-1" style="font-weight:700;">Categories</h4>
            <p class="text-secondary mb-0" style="font-size:13px;">Manage all product categories shown in the shop
                ({{ $categories->count() }} total categories).</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="admin_btn_primary text-decoration-none"
            style="display:inline-flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-plus"></i> Add Category
        </a>
    </div>
    <div class="admin_card">
        <div class="admin_card_body p-0">
            <div class="table-responsive">
                <table class="admin_table mb-0" style="min-width:600px;">
                    <thead>
                        <tr>
                            <th style="padding:14px 20px;">Category Name</th>
                            <th style="padding:14px 20px;">Slug</th>
                            <th style="padding:14px 20px;">Total Products</th>
                            <th style="padding:14px 20px;text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td style="padding:14px 20px;">
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <div
                                            style="width:36px;height:36px;border-radius:8px;background:var(--accent-gold-subtle);display:flex;align-items:center;justify-content:center;color:var(--accent-gold);font-size:14px;border:1px solid rgba(184,147,90,0.25);">
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                        <span style="font-weight:600;font-size:14px;color:#1a1a1a;">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td style="padding:14px 20px;font-size:13px;">
                                    <code
                                        style="background:#f3ede2;color:#6b6355;padding:3px 8px;border-radius:5px;font-size:12px;border:1px solid #e0d7c7;">{{ $category->slug }}</code>
                                </td>
                                <td style="padding:14px 20px;">
                                    <span
                                        style="background:var(--accent-gold-subtle);color:var(--accent-gold);border:1px solid rgba(184,147,90,0.25);padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:6px;">
                                        <i class="fa-solid fa-box" style="font-size:11px;"></i>
                                        {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                                    </span>
                                </td>
                                <td style="padding:14px 20px;text-align:right;">
                                    <div style="display:flex;gap:8px;justify-content:flex-end;">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn_admin_edit">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn_admin_delete">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center;padding:40px;color:var(--text-muted);">
                                    No categories found. <a href="{{ route('admin.categories.create') }}"
                                        style="color:var(--accent-gold);">Add your first category</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection