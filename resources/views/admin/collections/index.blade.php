@extends('Layout.admin')
@section('title', 'Collections Content')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="font-weight:700;">Collections Content</h4>
        <p class="text-secondary mb-0" style="font-size:13px;">Edit static text, banners, and feature cards for the Collections page.</p>
    </div>
    <a href="{{ url('/collections') }}" target="_blank" class="admin_btn_primary text-decoration-none" style="display:inline-flex;align-items:center;gap:8px;">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> View Collections Page
    </a>
</div>

@if(session('message'))
    <div class="alert alert-success d-flex align-items-center mb-4" style="background:rgba(25,135,84,0.15);border:1px solid #198754;color:#75b798;border-radius:10px;">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('message') }}
    </div>
@endif

<div class="admin_card mb-4">
    <div class="admin_card_header">
        <i class="fa-solid fa-layer-group me-2" style="color:var(--accent)"></i> Collections Page Sections
    </div>
    <div class="admin_card_body p-0">
        <div class="table-responsive">
            <table class="admin_table mb-0" style="width:100%; border-collapse:collapse; min-width:650px;">
            <thead>
                <tr style="border-bottom:1px solid var(--border-color); background:rgba(255,255,255,0.02);">
                    <th style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600;">Section</th>
                    <th style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600;">Current Title</th>
                    <th style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600;">Image</th>
                    <th style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600; text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sections as $key => $label)
                @php $row = $contents[$key] ?? null; @endphp
                <tr style="border-bottom:1px solid var(--border-color);">
                    <td style="padding:16px 22px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:36px;height:36px;background:rgba(212,175,122,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                @if($key === 'coll_banner') <i class="fa-solid fa-image" style="color:var(--accent);font-size:14px;"></i>
                                @elseif($key === 'coll_brand_banner') <i class="fa-solid fa-flag" style="color:var(--accent);font-size:14px;"></i>
                                @else <i class="fa-solid fa-layer-group" style="color:var(--accent);font-size:14px;"></i>
                                @endif
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:14px;">{{ $label }}</div>
                                <div style="font-size:12px;color:var(--text-muted);">{{ $key }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding:16px 22px; color:#1a1a1a; font-size:14px;">
                        {{ $row && $row->title ? \Illuminate\Support\Str::limit($row->title, 40) : '—' }}
                    </td>
                    <td style="padding:16px 22px;">
                        @if($row && $row->image)
                            <img src="{{ asset('storage/' . $row->image) }}" alt="" style="width:52px;height:38px;object-fit:cover;border-radius:6px;border:1px solid var(--border-color);">
                        @else
                            <span style="font-size:12px;color:var(--text-muted);">Default image</span>
                        @endif
                    </td>
                    <td style="padding:16px 22px; text-align:right;">
                        <a href="{{ route('admin.collections.edit', $key) }}" class="btn_admin_edit text-decoration-none" style="font-size:13px;padding:7px 16px;display:inline-flex;align-items:center;gap:6px;">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="admin_card p-3 d-flex align-items-center gap-3">
            <div style="width:40px;height:40px;background:rgba(212,175,122,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa-solid fa-rotate" style="color:var(--accent);font-size:16px;"></i>
            </div>
            <div>
                <div style="font-size:13px;font-weight:600;color:#1a1a1a;">Product Slider ("Shop Our Collections")</div>
                <div style="font-size:12px;color:var(--text-muted);">Automatically loads active products from your catalog. Manage in <a href="{{ route('admin.products.index') }}" style="color:var(--accent);text-decoration:none;">Products</a>.</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin_card p-3 d-flex align-items-center gap-3">
            <div style="width:40px;height:40px;background:rgba(212,175,122,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa-solid fa-globe" style="color:var(--accent);font-size:16px;"></i>
            </div>
            <div>
                <div style="font-size:13px;font-weight:600;color:#1a1a1a;">Footer Content</div>
                <div style="font-size:12px;color:var(--text-muted);">Shared across all website pages. Manage in <a href="{{ route('admin.homepage.index') }}" style="color:var(--accent);text-decoration:none;">Homepage Content</a>.</div>
            </div>
        </div>
    </div>
</div>

@endsection
