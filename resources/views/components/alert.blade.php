@props(['type' => 'info', 'message' => null])

@php
    $classes = [
        'success' => 'alert-success',
        'danger'  => 'alert-danger',
        'error'   => 'alert-danger',
        'warning' => 'alert-warning',
        'info'    => 'alert-info',
    ][$type] ?? 'alert-info';

    $message = $message ?? session($type);
@endphp

@if ($message)
    <div {{ $attributes->merge(['class' => "alert {$classes} alert-dismissible fade show mb-3"]) }} role="alert">
        <div>{!! $message !!}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif