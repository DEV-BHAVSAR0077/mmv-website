@extends('layouts.app')
@section('title', 'Order Confirmed!')

@push('styles')
<style>
    .confirmation-page {
        max-width: 750px;
        margin: 0 auto;
        padding: 3rem 1.5rem 5rem;
    }

    /* ── Success Banner ── */
    .success-banner {
        background: linear-gradient(135deg, #1A0A00, #3D1A00);
        border-radius: 24px;
        padding: 3rem 2rem;
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .success-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255,107,0,0.15), transparent 70%);
    }
    .checkmark {
        width: 80px; height: 80px;
        background: rgba(255,107,0,0.15);
        border: 3px solid var(--saffron);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto 1.2rem;
        position: relative;
        z-index: 1;
        animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    @keyframes popIn {
        from { transform: scale(0); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }
    .success-banner h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 900;
        color: #fff;
        position: relative;
        z-index: 1;
        margin-bottom: 0.5rem;
    }
    .success-banner h1 span { color: var(--saffron); }
    .success-banner p {
        color: #ccc;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    /* ── Order ID pill ── */
    .order-id-pill {
        display: inline-block;
        background: rgba(255,107,0,0.2);
        border: 1px solid rgba(255,107,0,0.4);
        color: var(--saffron);
        font-weight: 800;
        font-size: 1rem;
        padding: 0.4rem 1.4rem;
        border-radius: 50px;
        margin-top: 1rem;
        position: relative;
        z-index: 1;
        letter-spacing: 1px;
    }

    /* ── Cards ── */
    .info-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 3px 20px rgba(0,0,0,0.07);
        margin-bottom: 1.2rem;
        overflow: hidden;
    }
    .info-card-header {
        background: #fff8ef;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0ebe3;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .info-card-header h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }
    .info-card-body { padding: 1.5rem; }

    /* ── Order summary rows ── */
    .order-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.7rem 0;
        border-bottom: 1px solid #f9f5f0;
        font-size: 0.92rem;
    }
    .order-item-row:last-child { border-bottom: none; }
    .item-name { font-weight: 600; color: var(--dark); }
    .item-qty  { color: #888; font-size: 0.85rem; margin-left: 0.4rem; }
    .item-price { font-weight: 700; color: var(--saffron); }

    .totals-section { margin-top: 0.8rem; border-top: 2px dashed #f0ebe3; padding-top: 0.8rem; }
    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.4rem;
    }
    .total-row.grand {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dark);
        border-top: 1px solid #e0d8cf;
        padding-top: 0.6rem;
        margin-top: 0.4rem;
    }
    .total-row.grand span:last-child { color: var(--saffron); }

    /* ── Info grid ── */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .detail-item label {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #aaa;
        margin-bottom: 0.25rem;
    }
    .detail-item p {
        font-size: 0.92rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    /* ── Status badge ── */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 1rem;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 700;
    }
    .status-pending    { background: #fff3cd; color: #856404; }
    .status-processing { background: #cfe2ff; color: #084298; }
    .status-ready      { background: #d1e7dd; color: #0a3622; }
    .status-completed  { background: #d1e7dd; color: #0a3622; }
    .status-cancelled  { background: #f8d7da; color: #842029; }

    /* ── Action buttons ── */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    .btn-primary-cta {
        flex: 1;
        background: var(--saffron);
        color: #fff;
        border: none;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        display: block;
    }
    .btn-primary-cta:hover { background: var(--deep-red); transform: translateY(-2px); }
    .btn-outline-cta {
        flex: 1;
        background: transparent;
        color: var(--dark);
        border: 2px solid #e0d8cf;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s;
        display: block;
    }
    .btn-outline-cta:hover { border-color: var(--saffron); color: var(--saffron); }

    /* ── Timeline ── */
    .timeline-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 0.5rem 0;
    }
    .timeline-steps::before {
        content: '';
        position: absolute;
        top: 18px;
        left: 10%;
        right: 10%;
        height: 2px;
        background: #f0ebe3;
        z-index: 0;
    }
    .t-step { text-align: center; position: relative; z-index: 1; flex: 1; }
    .t-dot {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-size: 1rem;
        border: 2px solid #f0ebe3;
        background: #fff;
    }
    .t-dot.active { background: var(--saffron); border-color: var(--saffron); }
    .t-label { font-size: 0.72rem; font-weight: 600; color: #aaa; }
    .t-label.active { color: var(--saffron); }

    @media (max-width: 580px) {
        .detail-grid { grid-template-columns: 1fr; }
        .action-buttons { flex-direction: column; }
    }
</style>
@endpush

@section('content')

<div class="confirmation-page">

    {{-- ── Success Banner ── --}}
    <div class="success-banner">
        <div class="checkmark">🎉</div>
        <h1>Order <span>Confirmed!</span></h1>
        <p>Thank you! Your order has been received and is being prepared.</p>
        <div class="order-id-pill">
            ORDER #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
        </div>
    </div>

    {{-- ── Order Progress ── --}}
    <div class="info-card" style="margin-bottom:1.2rem;">
        <div class="info-card-header">
            <span>🔄</span>
            <h3>Order Status</h3>
        </div>
        <div class="info-card-body">
            <div class="timeline-steps">
                <div class="t-step">
                    <div class="t-dot active">✅</div>
                    <div class="t-label active">Placed</div>
                </div>
                <div class="t-step">
                    <div class="t-dot {{ in_array($order->status, ['processing','ready','completed']) ? 'active' : '' }}">🔥</div>
                    <div class="t-label {{ in_array($order->status, ['processing','ready','completed']) ? 'active' : '' }}">Preparing</div>
                </div>
                <div class="t-step">
                    <div class="t-dot {{ in_array($order->status, ['ready','completed']) ? 'active' : '' }}">📦</div>
                    <div class="t-label {{ in_array($order->status, ['ready','completed']) ? 'active' : '' }}">Ready</div>
                </div>
                <div class="t-step">
                    <div class="t-dot {{ $order->status === 'completed' ? 'active' : '' }}">🎉</div>
                    <div class="t-label {{ $order->status === 'completed' ? 'active' : '' }}">Done</div>
                </div>
            </div>
            <div style="text-align:center; margin-top:1rem;">
                <span class="status-pill status-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── Order Items ── --}}
    <div class="info-card">
        <div class="info-card-header">
            <span>🍽️</span>
            <h3>Your Items</h3>
        </div>
        <div class="info-card-body">
            @foreach($order->orderItems as $item)
            <div class="order-item-row">
                <div>
                    <span class="item-name">{{ $item->menuItem->name ?? 'Item' }}</span>
                    <span class="item-qty">× {{ $item->quantity }}</span>
                </div>
                <span class="item-price">₹{{ number_format($item->subtotal, 2) }}</span>
            </div>
            @endforeach

            <div class="totals-section">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->total_amount - $order->tax_amount, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Tax (5% GST)</span>
                    <span>₹{{ number_format($order->tax_amount, 2) }}</span>
                </div>
                <div class="total-row grand">
                    <span>Total Paid</span>
                    <span>₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Order Details ── --}}
    <div class="info-card">
        <div class="info-card-header">
            <span>📋</span>
            <h3>Order Details</h3>
        </div>
        <div class="info-card-body">
            <div class="detail-grid">
                <div class="detail-item">
                    <label>Customer</label>
                    <p>{{ $order->user->name ?? $order->guest_name ?? 'Guest' }}</p>
                </div>
                <div class="detail-item">
                    <label>Order Type</label>
                    <p>
                        @if($order->order_type === 'delivery') 🚚 Delivery
                        @elseif($order->order_type === 'pickup') 🏪 Pickup
                        @else 🪑 Dine-In
                        @endif
                    </p>
                </div>
                <div class="detail-item">
                    <label>Payment Method</label>
                    <p style="text-transform:capitalize;">
                        @if($order->payment_method === 'cash') 💵 Cash
                        @elseif($order->payment_method === 'upi') 📱 UPI
                        @elseif($order->payment_method === 'card') 💳 Card
                        @else 🌐 Online
                        @endif
                    </p>
                </div>
                <div class="detail-item">
                    <label>Payment Status</label>
                    <p style="text-transform:capitalize;">
                        @if($order->payment_status === 'paid')
                            <span style="color:#2E7D32;">✅ Paid</span>
                        @else
                            <span style="color:#F57F17;">⏳ Pending</span>
                        @endif
                    </p>
                </div>
                <div class="detail-item">
                    <label>Order Time</label>
                    <p>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</p>
                </div>
                <div class="detail-item">
                    <label>Order ID</label>
                    <p>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
                @if($order->delivery_address)
                <div class="detail-item" style="grid-column:1/-1;">
                    <label>Delivery Address</label>
                    <p>📍 {{ $order->delivery_address }}</p>
                </div>
                @endif
                @if($order->notes)
                <div class="detail-item" style="grid-column:1/-1;">
                    <label>Special Instructions</label>
                    <p>💬 {{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Action Buttons ── --}}
    <div class="action-buttons">
        <a href="{{ url('/menu') }}" class="btn-primary-cta">🍽️ Order More</a>
        <a href="{{ url('/') }}" class="btn-outline-cta">🏠 Back to Home</a>
    </div>

    {{-- ── Note ── --}}
    <div style="text-align:center; margin-top:2rem; padding:1.2rem; background:#fff8ef; border-radius:12px; font-size:0.88rem; color:#888; border:1px solid #f0ebe3;">
        🌶️ <strong style="color:var(--dark);">Need help with your order?</strong>
        Contact us at <a href="mailto:canada@mmvmumbaiya.com" style="color:var(--saffron); font-weight:600;">canada@mmvmumbaiya.com</a>
        or call us directly. We're happy to help!
    </div>

</div>

@endsection
