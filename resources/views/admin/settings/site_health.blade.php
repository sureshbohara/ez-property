@extends('layouts.app')

@section('title', 'Site Health')

@section('content')
<main class="page-content">
   <x-breadcrumb :title="'Site Health'" :subTitle="'Status Overview'" :breadcrumbItems="['Dashboard', 'Site Health']" />
   <div class="card mb-3">
      <div class="card-header bg-custom text-light d-flex align-items-center justify-content-between py-2">
        <h6 class="mb-0 text-light">Site Health Dashboard</h6>
      </div>
      <div class="card-body bg-light p-2">
        <div class="row">
        <!-- Server Information -->
        <div class="col-12 col-lg-6">
          <div class="card shadow-none border h-100">
            <div class="card-body">
              <table class="table align-middle table-striped">
                <thead>
                  <tr>
                    <th>Server Parameter</th>
                    <th>Value</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($serverInfo as $key => $value)
                  <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $value }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Directories and Sizes -->
        <div class="col-12 col-lg-6">
          <div class="card shadow-none border h-100">
            <div class="card-body">
              <table class="table align-middle table-striped">
                <thead>
                  <tr>
                    <th>Directory</th>
                    <th>Size</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($directories as $dir => $size)
                  <tr>
                    <td>{{ ucfirst(str_replace('_', ' ', $dir)) }}</td>
                    <td>{{ $size }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <br><hr>
              <table class="table align-middle table-striped">
                <thead>
                  <tr>
                    <th>Health Parameter</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($siteHealthStatus as $key => $value)
                  <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $value }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Disk Space Chart -->
        <div class="col-12 mt-4">
          <div class="card shadow-none border h-100">
            <div class="card-body">
              <h5>Disk Space Usage (Last 7 Days)</h5>
              <canvas id="diskSpaceChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      </div>
  </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('diskSpaceChart').getContext('2d');

  @if(!empty($diskChartData['data']))
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($diskChartData['labels']) !!}, 
            datasets: [{
                label: 'Disk Usage (Bytes)',
                data: {!! json_encode($diskChartData['data']) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                title: { display: true, text: 'Disk Space Usage Over Time' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                           // Convert to GB for display
                           return (value / 1024 / 1024 / 1024).toFixed(2) + ' GB';
                        }
                    }
                }
            }
        }
    });
  @else
    document.getElementById('diskSpaceChart').innerHTML = '<div class="alert alert-info">Run <code>php artisan health:check</code> to generate data.</div>';
  @endif
</script>
@endpush