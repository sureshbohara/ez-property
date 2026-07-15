@extends('layouts.app')
@section('title', 'Package Equipment')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Package Management" subTitle="Equipment" :breadcrumbItems="['Dashboard', 'Packages', 'Equipment']" />
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">Equipment For: {{ $data->name }}</h6>
            <a href="{{ route('admin.package.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card-body bg-light p-3">
            <x-alert type="success" />
            <form action="{{ route('admin.trip.equipment', $data->id) }}" method="POST">
                @csrf
                @php
                    $fields = [
                        ['label' => 'General', 'input' => 'equipment1', 'data' => $data->general ?? []],
                        ['label' => 'Lower Body', 'input' => 'equipment2', 'data' => $data->lower_body ?? []],
                        ['label' => 'Upper Body', 'input' => 'equipment3', 'data' => $data->upper_body ?? []],
                        ['label' => 'Footwear', 'input' => 'equipment4', 'data' => $data->footwear ?? []],
                        ['label' => 'Accessories', 'input' => 'equipment5', 'data' => $data->accessories ?? []],
                    ];
                @endphp
                <div class="row g-3">
                    @foreach($fields as $field)
                        <div class="col-md-6">
                            <div class="card h-100 shadow-none border">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">{{ $field['label'] }}</h6>
                                    <div class="display-{{ $field['input'] }}">
                                        @foreach($field['data'] as $item)
                                            <div class="row mb-2 equipment-step">
                                                <div class="col-10"><input type="text" class="form-control form-control-sm" name="{{ $field['input'] }}[content][]" value="{{ $item['content'] ?? '' }}"></div>
                                                <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeEquipmentStep"><i class="bi bi-trash"></i></button></div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 addEquipment" data-input="{{ $field['input'] }}"><i class="bi bi-plus-circle"></i> Add</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update Equipment</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.addEquipment').click(function() {
            let input = $(this).data('input');
            $(`.display-${input}`).append(`<div class="row mb-2 equipment-step"><div class="col-10"><input type="text" class="form-control form-control-sm" name="${input}[content][]"></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm removeEquipmentStep"><i class="bi bi-trash"></i></button></div></div>`);
        });
        $(document).on('click', '.removeEquipmentStep', function() { $(this).closest('.equipment-step').remove(); });
    });
</script>
@endpush