@extends('Layout.admin')
@section('title', 'Add Testimonials')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1" style="font-weight:700;">Testimonials</h4>
        <p class="text-secondary mb-0" style="font-size:13px;">Manage all Testimonials.</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="admin_btn_primary text-decoration-none" style="display:inline-flex;align-items:center;gap:8px;">
        <i class="fa-solid fa-plus"></i> Add Testimonials
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
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">Testimonials</th>
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">Review</th>
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">Rating</th>
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">Status </th>
                        <th style="padding:13px 20px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                     @forelse($testimonials as $item)
                    <tr style="border-bottom:1px solid var(--border-color);">
                        {{-- Customer Photo, Name & Role --}}
                        <td style="padding:14px 20px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:44px;height:44px;border-radius:50%;overflow:hidden;flex-shrink:0;border:1px solid var(--border-color);background:#1a1c23;">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <img src="{{ asset('images/Layer_23_copy_5.png') }}" alt="{{ $item->name }}" style="width:100%;height:100%;object-fit:cover;">
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:14px;color:#1a1a1a;">{{ $item->name }}</div>
                                    <div style="font-size:12px;color:var(--text-muted);">{{ $item->role ?? 'Customer' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Review Text (Shortened) --}}
                        <td style="padding:14px 20px;font-size:13px;color:var(--text-secondary);max-width:320px;">
                            <span title="{{ $item->review }}">{{ Str::limit($item->review, 85) }}</span>
                        </td>

                        {{-- Star Rating --}}
                        <td style="padding:14px 20px;">
                            <div style="display:flex;gap:3px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star" style="font-size:13px;{{ $i <= $item->rating ? 'color:var(--accent-gold);' : 'color:var(--text-muted);opacity:0.3;' }}"></i>
                                @endfor
                            </div>
                        </td>

                        {{-- Status Badge --}}
                        <td style="padding:14px 20px;">
                            @if($item->status)
                                <span class="badge_status active">Active</span>
                            @else
                                <span class="badge_status cancelled">Inactive</span>
                            @endif
                        </td>

                        {{-- Edit & Delete Actions --}}
                        <td style="padding:14px 20px;text-align:right;">
                            <div style="display:flex;gap:8px;justify-content:flex-end;">
                                <a href="{{ route('admin.testimonials.edit', $item) }}" class="btn_admin_edit">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.testimonials.destroy', $item) }}" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
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
                        <td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);">
                            No testimonials yet. <a href="{{ route('admin.testimonials.create') }}" style="color:var(--accent);">Add your first testimonial</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection





