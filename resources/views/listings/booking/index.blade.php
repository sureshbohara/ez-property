@extends('layouts.app')

@section('title', 'Manage Bookings')

@section('content')
<main class="page-content">

    <x-breadcrumb title="Manage Bookings" subTitle="Booking List" :breadcrumbItems="['Dashboard', 'Bookings']"/>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2 flex-wrap gap-2">
            <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-check me-2"></i> Manage Bookings</h5>

            <div class="d-flex gap-2 flex-wrap">
           
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-calendar3 me-1"></i> Date: {{ $filter }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('listing.booking.index', array_merge(request()->query(), ['filter' => 'Today'])) }}">Today</a></li>
                        <li><a class="dropdown-item" href="{{ route('listing.booking.index', array_merge(request()->query(), ['filter' => 'This Week'])) }}">This Week</a></li>
                        <li><a class="dropdown-item" href="{{ route('listing.booking.index', array_merge(request()->query(), ['filter' => 'This Month'])) }}">This Month</a></li>
                        <li><a class="dropdown-item" href="{{ route('listing.booking.index', array_merge(request()->query(), ['filter' => 'This Year'])) }}">This Year</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('listing.booking.index', array_merge(request()->query(), ['filter' => 'Total'])) }}">Total</a></li>
                    </ul>
                </div>

                {{-- Booking Status Filter --}}
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-funnel me-1"></i> Status: {{ ucfirst($statusFilter) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('listing.booking.index', array_merge(request()->query(), ['status' => 'all'])) }}">All</a></li>
                        @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $s)
                            <li><a class="dropdown-item" href="{{ route('listing.booking.index', array_merge(request()->query(), ['status' => $s])) }}">{{ ucfirst($s) }}</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Payment Status Filter --}}
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-wallet2 me-1"></i> Payment: {{ ucfirst($paymentStatusFilter) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('listing.booking.index', array_merge(request()->query(), ['payment_status' => 'all'])) }}">All</a></li>
                        @foreach(['pending', 'paid', 'failed', 'refunded'] as $ps)
                            <li><a class="dropdown-item" href="{{ route('listing.booking.index', array_merge(request()->query(), ['payment_status' => $ps])) }}">{{ ucfirst($ps) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body bg-light p-4">

            {{-- ─── Stats Cards ─────────────────────────── --}}
            <div class="row g-3 mb-4">

                {{-- Total --}}
                <div class="col-md-6 col-xl-4">
                    <div class="card border-start border-4 border-primary shadow-sm h-100 bg-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="small text-uppercase text-secondary fw-bold mb-0">Total</p>
                                <i class="bi bi-bag-check text-primary fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">
                                {{ $stats['total_bookings'] }}
                                <span class="text-muted fs-6">- ${{ number_format($stats['total_revenue'], 2) }}</span>
                            </h4>
                            <p class="small text-muted mt-1 mb-0">Bookings & Revenue</p>
                        </div>
                    </div>
                </div>

                {{-- Pending --}}
                <div class="col-md-6 col-xl-4">
                    <div class="card border-start border-4 border-warning shadow-sm h-100 bg-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="small text-uppercase text-secondary fw-bold mb-0">Pending</p>
                                <i class="bi bi-hourglass-split text-warning fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">
                                {{ $stats['pending_count'] }}
                                <span class="text-muted fs-6">- ${{ number_format($stats['pending_amount'], 2) }}</span>
                            </h4>
                            <p class="small text-muted mt-1 mb-0">Bookings & Revenue</p>
                        </div>
                    </div>
                </div>

                {{-- Confirmed --}}
                <div class="col-md-6 col-xl-4">
                    <div class="card border-start border-4 border-info shadow-sm h-100 bg-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="small text-uppercase text-secondary fw-bold mb-0">Confirmed</p>
                                <i class="bi bi-check2-circle text-info fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">
                                {{ $stats['confirmed_count'] }}
                                <span class="text-muted fs-6">- ${{ number_format($stats['confirmed_amount'], 2) }}</span>
                            </h4>
                            <p class="small text-muted mt-1 mb-0">Bookings & Revenue</p>
                        </div>
                    </div>
                </div>

                {{-- Completed --}}
                <div class="col-md-6 col-xl-4">
                    <div class="card border-start border-4 border-success shadow-sm h-100 bg-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="small text-uppercase text-secondary fw-bold mb-0">Completed</p>
                                <i class="bi bi-house-check text-success fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">
                                {{ $stats['completed_count'] }}
                                <span class="text-muted fs-6">- ${{ number_format($stats['completed_amount'], 2) }}</span>
                            </h4>
                            <p class="small text-muted mt-1 mb-0">Bookings & Revenue</p>
                        </div>
                    </div>
                </div>

                {{-- Cancelled --}}
                <div class="col-md-6 col-xl-4">
                    <div class="card border-start border-4 border-danger shadow-sm h-100 bg-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="small text-uppercase text-secondary fw-bold mb-0">Cancelled</p>
                                <i class="bi bi-x-circle text-danger fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-0">
                                {{ $stats['cancelled_count'] }}
                                <span class="text-muted fs-6">- ${{ number_format($stats['cancelled_amount'], 2) }}</span>
                            </h4>
                            <p class="small text-muted mt-1 mb-0">Bookings & Revenue</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── Bookings Table ──────────────────────── --}}
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table align-middle table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="ps-3">Booking #</th>
                            <th>Listing</th>
                            <th>Guest</th>
                            <th>Contact</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Guests</th>
                            <th>Total</th>
                            <th>Payment Status</th>
                            <th>Booking Status</th>
                            <th>Date</th>
                            <th class="text-center pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $statusColors = [
                                'pending'   => 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25',
                                'confirmed' => 'bg-info bg-opacity-10 text-info border border-info border-opacity-25',
                                'completed' => 'bg-success bg-opacity-10 text-success border border-success border-opacity-25',
                                'cancelled' => 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25',
                            ];
                            $payStatusColors = [
                                'pending'  => 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25',
                                'paid'     => 'bg-success bg-opacity-10 text-success border border-success border-opacity-25',
                                'failed'   => 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25',
                                'refunded' => 'bg-info bg-opacity-10 text-info border border-info border-opacity-25',
                            ];
                        @endphp

                        @forelse($bookings as $booking)
                        <tr class="border-bottom">
                            <td class="ps-3">
                                <strong>#BK-{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}</strong>
                            </td>

                 
                            <td style="min-width: 200px;">
                                @if($booking->listing)
                                    <div class="d-flex align-items-center gap-2">
                                        @if($booking->listing->image)
                                            <img src="{{ $booking->listing->image_url }}" alt="{{ $booking->listing->title }}"
                                                 class="rounded" style="width: 45px; height: 45px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <strong class="d-block small">{{ \Illuminate\Support\Str::limit($booking->listing->title, 30) }}</strong>
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt"></i>
                                                {{ \Illuminate\Support\Str::limit($booking->listing->city ?? $booking->listing->address, 25) }}
                                            </small>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Listing removed</span>
                                @endif
                            </td>

                            {{-- Guest --}}
                            <td>
                                @if($booking->user)
                                    <strong>{{ $booking->user->name }}</strong><br>
                                    <small class="text-muted">{{ $booking->user->email }}</small>
                                @else
                                    <span class="text-muted">Guest</span>
                                @endif
                            </td>

                            {{-- Contact --}}
                            <td>
                                @if($booking->user)
                                    <small><i class="bi bi-envelope text-muted"></i> {{ $booking->user->email }}</small><br>
                                    <small><i class="bi bi-phone text-muted"></i> {{ $booking->user->phone ?? 'N/A' }}</small>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                            {{-- Check In --}}
                            <td>
                                <small class="d-block fw-semibold">{{ $booking->check_in->format('M d, Y') }}</small>
                                <small class="text-muted">{{ $booking->check_in->format('h:i A') }}</small>
                            </td>

                            {{-- Check Out --}}
                            <td>
                                <small class="d-block fw-semibold">{{ $booking->check_out->format('M d, Y') }}</small>
                                <small class="text-muted">{{ $booking->check_out->format('h:i A') }}</small>
                            </td>

                            {{-- Guests --}}
                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                                    <i class="bi bi-people me-1"></i>{{ $booking->guests }}
                                </span>
                            </td>

                            {{-- Total --}}
                            <td><strong class="text-dark">${{ number_format($booking->total_price ?? 0, 2) }}</strong></td>

                            {{-- Payment Status --}}
                            <td>
                                <span class="badge rounded-pill px-3 py-2 {{ $payStatusColors[$booking->payment_status] ?? 'bg-light text-dark border' }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </td>

                            {{-- Booking Status --}}
                            <td>
                                <span class="badge rounded-pill px-3 py-2 {{ $statusColors[$booking->status] ?? 'bg-light text-dark border' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td>
                                <small class="d-block">{{ $booking->created_at->format('M d, Y') }}</small>
                                <small class="text-muted">{{ $booking->created_at->format('h:i A') }}</small>
                            </td>

                            {{-- Actions --}}
                            <td class="text-center pe-3">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#statusModal{{ $booking->id }}" title="Change Status">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-outline-danger"
                                            onclick="confirmDelete(event, 'deleteForm{{ $booking->id }}')" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <form id="deleteForm{{ $booking->id }}"
                                      action="{{ route('listing.booking.destroy', $booking->id) }}"
                                      method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        {{-- ─── Status Update Modal ─────────── --}}
                        <div class="modal fade" id="statusModal{{ $booking->id }}" tabindex="-1">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('listing.booking.status', $booking->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">
                                                <i class="bi bi-pencil-square me-2"></i> Update Booking
                                            </h5>
                                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-3 text-muted">
                                                Booking: <strong class="text-dark">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong>
                                            </p>

                                            @if($booking->listing)
                                                <p class="mb-3 small text-muted">
                                                    Listing: <strong class="text-dark">{{ \Illuminate\Support\Str::limit($booking->listing->title, 30) }}</strong><br>
                                                    Check In: <strong class="text-dark">{{ $booking->check_in->format('M d, Y') }}</strong><br>
                                                    Check Out: <strong class="text-dark">{{ $booking->check_out->format('M d, Y') }}</strong>
                                                </p>
                                            @endif

                                            <div class="mb-3">
                                                <label class="form-label fw-bold small">Booking Status</label>
                                                <select name="status" class="form-select" required>
                                                    @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $s)
                                                        <option value="{{ $s }}" @if($booking->status == $s) selected @endif>
                                                            {{ ucfirst($s) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold small">Payment Status</label>
                                                <select name="payment_status" class="form-select" required>
                                                    @foreach(['pending', 'paid', 'failed', 'refunded'] as $ps)
                                                        <option value="{{ $ps }}" @if($booking->payment_status == $ps) selected @endif>
                                                            {{ ucfirst($ps) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-check-circle me-1"></i> Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted py-5">
                                <i class="bi bi-inbox d-block mb-2" style="font-size: 40px;"></i>
                                No bookings found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
            <div class="mt-4 d-flex justify-content-end">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
            @endif

        </div>
    </div>

</main>

<script>
    function confirmDelete(event, formId) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this booking? This action cannot be undone!')) {
            document.getElementById(formId).submit();
        }
    }
</script>
@endsection