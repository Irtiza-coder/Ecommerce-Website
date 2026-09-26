@extends('Layout.admin')
@section('title', 'Homepage Content')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="font-weight:700;">Homepage Content</h4>
            <p class="text-secondary mb-0" style="font-size:13px;">Edit static text and images for each section of the
                homepage.</p>
        </div>
        <a href="{{ url('/') }}" target="_blank" class="admin_btn_primary text-decoration-none"
            style="display:inline-flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> View Homepage
        </a>
    </div>

    <div class="admin_card">
        <div class="admin_card_header">
            <i class="fa-solid fa-house me-2" style="color:var(--accent)"></i> Home Page Sections
        </div>
        <div class="admin_card_body p-0">
            <div class="table-responsive">
                <table class="admin_table mb-0" style="width:100%; border-collapse:collapse; min-width:650px;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--border-color); background:rgba(255,255,255,0.02);">
                            <th
                                style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600;">
                                Section</th>
                            <th
                                style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600;">
                                Current Title</th>
                            <th
                                style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600;">
                                Image</th>
                            <th
                                style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600; text-align:right;">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sections as $key => $label)
                            @php $row = $contents[$key] ?? null; @endphp
                            <tr style="border-bottom:1px solid var(--border-color);">
                                <td style="padding:16px 22px;">
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <div
                                            style="width:36px;height:36px;background:rgba(184,147,90,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                            @if($key === 'top_bar') <i class="fa-solid fa-bullhorn"
                                                style="color:var(--accent-gold);font-size:14px;"></i>
                                            @elseif($key === 'hero') <i class="fa-solid fa-image"
                                                style="color:var(--accent-gold);font-size:14px;"></i>
                                            @elseif($key === 'welcome') <i class="fa-solid fa-hand"
                                                style="color:var(--accent-gold);font-size:14px;"></i>
                                            @elseif(str_starts_with($key, 'feature')) <i class="fa-solid fa-layer-group"
                                                style="color:var(--accent-gold);font-size:14px;"></i>
                                            @elseif($key === 'brand_banner') <i class="fa-solid fa-flag"
                                                style="color:var(--accent-gold);font-size:14px;"></i>
                                            @elseif($key === 'shop_section') <i class="fa-solid fa-shop"
                                                style="color:var(--accent-gold);font-size:14px;"></i>
                                            @elseif($key === 'catalogue') <i class="fa-solid fa-book-open"
                                                style="color:var(--accent-gold);font-size:14px;"></i>
                                            @else <i class="fa-solid fa-star" style="color:var(--accent-gold);font-size:14px;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div style="font-weight:600;font-size:14px;color:#1a1a1a;">{{ $label }}</div>
                                            <div style="font-size:12px;color:var(--text-muted);">{{ $key }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding:16px 22px; color:#1a1a1a; font-size:14px;">
                                    {{ $row && $row->title ? \Illuminate\Support\Str::limit($row->title, 40) : '—' }}
                                </td>
                                <td style="padding:16px 22px;">
                                    @php
                                        $supportsImg = in_array($key, ['hero', 'brand_banner', 'catalogue', 'feature1', 'feature2']);
                                    @endphp
                                    @if($row && $row->image)
                                        <img src="{{ asset('storage/' . $row->image) }}" alt=""
                                            style="width:52px;height:38px;object-fit:cover;border-radius:6px;border:1px solid var(--border-color);">
                                    @elseif($supportsImg)
                                        <span
                                            style="font-size:12px;color:var(--text-muted);background:rgba(0,0,0,0.04);padding:3px 8px;border-radius:5px;">Default
                                            image</span>
                                    @else
                                        <span style="font-size:12px;color:var(--text-muted);">— (Text only)</span>
                                    @endif
                                </td>
                                <td style="padding:16px 22px; text-align:right;">
                                    <a href="{{ route('admin.homepage.edit', $key) }}"
                                        class="btn_admin_edit text-decoration-none"
                                        style="font-size:13px;padding:7px 16px;display:inline-flex;align-items:center;gap:6px;">
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

@endsection