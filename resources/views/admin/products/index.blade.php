@extends('Layout.admin')
@section('title', 'Products')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1" style="font-weight:700;">Products</h4>
        <p class="text-secondary mb-0" style="font-size:13px;">Manage all products shown in the shop ({{ $products->count() }} total products).</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="admin_btn_primary text-decoration-none" style="display:inline-flex;align-items:center;gap:8px;">
        <i class="fa-solid fa-plus"></i> Add Product
    </a>
</div>

@if(session('message'))
<div style="background:rgba(74,222,128,0.12);border:1px solid rgba(74,222,128,0.3);border-radius:8px;padding:12px 18px;margin-bottom:20px;color:#4ade80;font-size:14px;">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('message') }}
</div>
@endif

<div class="admin_card">
    <div class="admin_card_body p-0">
        <div class="table-responsive">
            <table class="admin_table mb-0" style="width:100%;border-collapse:collapse;min-width:650px;">
                <thead>
                    <tr style="border-bottom:1px solid var(--border-color);background:rgba(255,255,255,0.02);">
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">Product</th>
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">Category</th>
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">Price</th>
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">Stock</th>
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">Featured</th>
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr style="border-bottom:1px solid var(--border-color);">
                        <td style="padding:14px 20px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:48px;height:48px;border-radius:8px;overflow:hidden;flex-shrink:0;border:1px solid var(--border-color);background:#1a1c23;">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:14px;color:#1a1a1a;">{{ $product->name }}</div>
                                    <div style="font-size:12px;color:var(--text-muted);">{{ $product->brand ?? 'Crest & Clove' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding:14px 20px;font-size:13px;color:var(--text-secondary);">{{ $product->category->name ?? '—' }}</td>
                        <td style="padding:14px 20px;">
                            <span style="font-weight:700;color:var(--accent-gold);">${{ number_format($product->price, 2) }}</span>
                            @if($product->old_price)
                                <span style="font-size:12px;color:var(--text-muted);text-decoration:line-through;margin-left:4px;">${{ number_format($product->old_price, 2) }}</span>
                            @endif
                        </td>
                        <td style="padding:14px 20px;">
                            @if($product->stock_status === 'In Stock' && $product->stock_quantity > 0)
                                <span class="badge_status instock">
                                    <i class="fa-solid fa-boxes-stacked me-1"></i> {{ $product->stock_quantity }} in stock
                                </span>
                            @else
                                <span class="badge_status outofstock">
                                    <i class="fa-solid fa-circle-xmark me-1"></i> Out of Stock
                                </span>
                            @endif
                        </td>
                        <td style="padding:14px 20px;">
                            @if($product->is_featured)
                                <i class="fa-solid fa-star" style="color:var(--accent-gold);font-size:16px;" title="Featured"></i>
                            @else
                                <i class="fa-regular fa-star" style="color:var(--text-muted);font-size:16px;" title="Not Featured"></i>
                            @endif
                        </td>
                        <td style="padding:14px 20px;text-align:right;">
                            <div style="display:flex;gap:8px;justify-content:flex-end;">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn_admin_edit">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to delete this product?')">
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
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">No products yet. <a href="{{ route('admin.products.create') }}" style="color:var(--accent);">Add your first product</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
