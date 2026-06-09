@props(['title', 'subTitle', 'breadcrumbItems' => []])

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
            @foreach($breadcrumbItems as $item)
            <li class="breadcrumb-item">{{ $item }}</li>
            @endforeach
            <li class="breadcrumb-item active" aria-current="page">{{ $subTitle }}</li>
        </ol>
    </nav>
</div>