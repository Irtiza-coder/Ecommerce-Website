@extends('Layout.admin')
@section('title', 'Shop Page Content')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="font-weight:700;">Shop Page Content</h4>
            <p class="text-secondary mb-0" style="font-size:13px;">Edit the top banner image, page heading, and announcement text for the Shop page.</p>
        </div>
        <a href="{{ url('/shop') }}" target="_blank" class="admin_btn_primary text-decoration-none"
            style="display:inline-flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> View Shop Page
        </a>
    </div>

    @if(session('message'))
        <div class="alert alert-success d-flex align-items-center mb-4"
            style="background:rgba(25,135,84,0.15);border:1px solid #198754;color:#75b798;border-radius:10px;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('message') }}
        </div>
    @endif

    <div class="admin_card mb-4">
        <div class="admin_card_header">
            <i class="fa-solid fa-store me-2" style="color:var(--accent)"></i> Shop Page Sections
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
                                Current Heading</th>
                            <th
                                style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600;">
                                Subtitle / Promo</th>
                            <th
                                style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600;">
                                Banner Image</th>
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
                                            <i class="fa-solid fa-image" style="color:var(--accent-gold);font-size:14px;"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight:600;font-size:14px;color:#1a1a1a;">{{ $label }}</div>
                                            <div style="font-size:12px;color:var(--text-muted);">{{ $key }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding:16px 22px; color:#1a1a1a; font-size:14px;">
                                    {{ $row && $row->title ? $row->title : 'shop (Default)' }}
                                </td>
                                <td style="padding:16px 22px; color:var(--text-muted); font-size:13px;">
                                    {{ $row && $row->subtitle ? \Illuminate\Support\Str::limit($row->subtitle, 45) : '—' }}
                                </td>
                                <td style="padding:16px 22px;">
                                    @if($row && $row->image)
                                        <img src="{{ asset('storage/' . $row->image) }}" alt="Banner"
                                            style="width:50px;height:32px;object-fit:cover;border-radius:6px;border:1px solid var(--border-color);">
                                    @else
                                        <span style="font-size:12px;color:var(--text-muted);background:rgba(0,0,0,0.04);padding:3px 8px;border-radius:5px;">Default Site Banner</span>
                                    @endif
                                </td>
                                <td style="padding:16px 22px; text-align:right;">
                                    <a href="{{ route('admin.shop.edit', $key) }}"
                                        class="btn_admin_edit text-decoration-none"
                                        style="padding:6px 14px;font-size:13px;display:inline-flex;align-items:center;gap:6px;">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
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
