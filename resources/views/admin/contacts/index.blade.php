@extends('Layout.admin')
@section('title', 'Contact Inquiries')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1" style="font-weight:700;">Customer Messages & Inquiries</h4>
        <p class="text-secondary mb-0" style="font-size:13px;">Read and respond to messages submitted through the website contact form.</p>
    </div>
</div>

@if(session('message'))
<div style="background:rgba(74,222,128,0.12);border:1px solid rgba(74,222,128,0.3);border-radius:8px;padding:12px 18px;margin-bottom:20px;color:#4ade80;font-size:14px;">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('message') }}
</div>
@endif

<!-- Search & Counts -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
    <div style="font-size:14px;color:var(--text-muted);">
        Total Inquiries: <strong style="color:#1a1a1a;">{{ $totalContacts }}</strong>
    </div>

    <form method="GET" action="{{ route('admin.contacts.index') }}" class="d-flex gap-2">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search name, email, or message..." 
               class="admin_form_control" style="font-size:13px;min-width:260px;">
        <button type="submit" class="admin_btn_primary" style="padding:6px 14px;font-size:13px;">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        @if(!empty($search))
            <a href="{{ route('admin.contacts.index') }}" class="admin_btn_secondary" style="font-size:13px;padding:6px 12px;">Clear</a>
        @endif
    </form>
</div>

<!-- Contacts Table -->
<div class="admin_card">
    <div class="admin_card_body p-0">
        <div class="table-responsive">
            <table class="admin_table mb-0" style="min-width:650px;">
                <thead>
                    <tr>
                        <th style="padding:14px 18px;">Sender</th>
                        <th style="padding:14px 18px;">Contact Details</th>
                        <th style="padding:14px 18px;">Message</th>
                        <th style="padding:14px 18px;">Date</th>
                        <th style="padding:14px 18px;text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr>
                        <td style="padding:14px 18px;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:36px;height:36px;border-radius:50%;background:var(--accent-gold-subtle);color:var(--accent-gold);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;border:1px solid rgba(184,147,90,0.25);flex-shrink:0;">
                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                </div>
                                <div style="font-weight:600;font-size:14px;color:#1a1a1a;">{{ $contact->name }}</div>
                            </div>
                        </td>
                        <td style="padding:14px 18px;font-size:13px;">
                            <div><a href="mailto:{{ $contact->email }}" style="color:var(--accent-gold);text-decoration:none;"><i class="fa-solid fa-envelope me-1"></i>{{ $contact->email }}</a></div>
                            <div class="mt-1"><a href="tel:{{ $contact->mobile }}" style="color:var(--text-secondary);text-decoration:none;"><i class="fa-solid fa-phone me-1"></i>{{ $contact->mobile }}</a></div>
                        </td>
                        <td style="padding:14px 18px;font-size:13px;color:var(--text-muted);max-width:320px;">
                            <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ $contact->message ?: 'No message body provided.' }}
                            </span>
                        </td>
                        <td style="padding:14px 18px;font-size:13px;color:var(--text-muted);white-space:nowrap;">
                            {{ $contact->created_at ? $contact->created_at->format('M d, Y') : 'N/A' }}
                            <div style="font-size:11px;color:var(--text-muted);">{{ $contact->created_at ? $contact->created_at->format('h:i A') : '' }}</div>
                        </td>
                        <td style="padding:14px 18px;text-align:right;white-space:nowrap;">
                            <div style="display:flex;gap:8px;justify-content:flex-end;">
                                <button type="button" class="btn_admin_edit" data-bs-toggle="modal" data-bs-target="#contactModal{{ $contact->id }}">
                                    <i class="fa-solid fa-envelope-open me-1"></i> Read
                                </button>
                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Delete message from {{ $contact->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn_admin_delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:40px 20px;text-align:center;color:var(--text-muted);">
                            <i class="fa-regular fa-envelope-open fa-2x mb-3 d-block" style="opacity:0.4;"></i>
                            No contact inquiries yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($contacts->hasPages())
        <div style="padding:16px 20px;border-top:1px solid var(--border-color);">
            {{ $contacts->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modals -->
@foreach($contacts as $contact)
<div class="modal fade" id="contactModal{{ $contact->id }}" tabindex="-1" aria-labelledby="contactModalLabel{{ $contact->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#ffffff;border:1px solid var(--border-color);color:#1a1a1a;border-radius:12px;box-shadow:var(--shadow-lg);">
            <div class="modal-header" style="border-bottom:1px solid var(--border-color);padding:18px 24px;background:#faf8f5;">
                <div>
                    <h5 class="modal-title mb-0" id="contactModalLabel{{ $contact->id }}" style="font-weight:700;color:#1a1a1a;">
                        Inquiry from <span style="color:var(--accent-gold);">{{ $contact->name }}</span>
                    </h5>
                    <small style="color:var(--text-muted);">Received on {{ $contact->created_at ? $contact->created_at->format('F d, Y \a\t h:i A') : 'N/A' }}</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:24px;">
                <div class="p-3 mb-4 rounded" style="background:#faf8f5;border:1px solid var(--border-color);font-size:13px;line-height:1.9;">
                    <div><span class="text-muted">Sender Name:</span> <strong style="color:#1a1a1a;">{{ $contact->name }}</strong></div>
                    <div><span class="text-muted">Email:</span> <a href="mailto:{{ $contact->email }}" style="color:var(--accent-gold);text-decoration:none;">{{ $contact->email }}</a></div>
                    <div><span class="text-muted">Mobile:</span> <a href="tel:{{ $contact->mobile }}" style="color:var(--text-secondary);text-decoration:none;">{{ $contact->mobile }}</a></div>
                </div>

                <h6 style="font-weight:700;font-size:13px;color:var(--accent-gold);text-transform:uppercase;margin-bottom:8px;">Message Content:</h6>
                <div class="p-3 rounded" style="background:#faf8f5;border:1px solid var(--border-color);font-size:14px;line-height:1.7;white-space:pre-wrap;color:#1a1a1a;">
                    {{ $contact->message ?: 'No message text provided.' }}
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid var(--border-color);padding:14px 24px;background:#faf8f5;">
                <a href="mailto:{{ $contact->email }}?subject=RE: Inquiry from {{ config('app.name') }}" class="admin_btn_primary text-decoration-none" style="padding:8px 18px;font-size:13px;">
                    <i class="fa-solid fa-reply me-1"></i> Reply via Email
                </a>
                <button type="button" class="admin_btn_secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
