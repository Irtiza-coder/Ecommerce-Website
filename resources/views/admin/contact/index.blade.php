@extends('Layout.admin')
@section('title', 'Contact Us Content')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="font-weight:700;">Contact Us Content</h4>
            <p class="text-secondary mb-0" style="font-size:13px;">Manage top banner, store addresses, phone numbers, emails, and intro text for the Contact Us page.</p>
        </div>
        <a href="{{ url('/contact-us') }}" target="_blank" class="admin_btn_primary text-decoration-none"
            style="display:inline-flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> View Contact Page
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
            <i class="fa-solid fa-address-book me-2" style="color:var(--accent)"></i> Contact Us Page Sections
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
                            Current Title / Heading</th>
                        <th
                            style="padding:14px 22px; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); font-weight:600;">
                            Current Value / Description</th>
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
                                        style="width:36px;height:36px;background:rgba(212,175,122,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                        @if($key === 'contact_banner')
                                            <i class="fa-solid fa-image" style="color:var(--accent);font-size:14px;"></i>
                                        @elseif($key === 'contact_location')
                                            <i class="fa-solid fa-location-dot" style="color:var(--accent);font-size:14px;"></i>
                                        @elseif($key === 'contact_phone')
                                            <i class="fa-solid fa-phone" style="color:var(--accent);font-size:14px;"></i>
                                        @elseif($key === 'contact_email')
                                            <i class="fa-solid fa-at" style="color:var(--accent);font-size:14px;"></i>
                                        @else
                                            <i class="fa-solid fa-heading" style="color:var(--accent);font-size:14px;"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-weight:600;font-size:14px;">{{ $label }}</div>
                                        <div style="font-size:12px;color:var(--text-muted);">{{ $key }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:16px 22px; color:#1a1a1a; font-size:14px;">
                                {{ $row && $row->title ? \Illuminate\Support\Str::limit($row->title, 35) : '—' }}
                            </td>
                            <td style="padding:16px 22px; color:#94a3b8; font-size:13px;">
                                @if($key === 'contact_banner')
                                    @if($row && $row->image)
                                        <img src="{{ asset('storage/' . $row->image) }}" alt="Banner"
                                            style="width:50px;height:30px;object-fit:cover;border-radius:6px;border:1px solid var(--border-color);">
                                    @else
                                        <span style="font-size:12px;color:var(--text-muted);background:rgba(255,255,255,0.05);padding:3px 8px;border-radius:5px;">Default Banner</span>
                                    @endif
                                @else
                                    {{ $row && ($row->description || $row->subtitle) ? \Illuminate\Support\Str::limit($row->description ?: $row->subtitle, 45) : '—' }}
                                @endif
                            </td>
                            <td style="padding:16px 22px; text-align:right;">
                                <a href="{{ route('admin.contact-cms.edit', $key) }}"
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
