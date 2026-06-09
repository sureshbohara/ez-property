<div class="card radius-10">
    <div class="card-header bg-transparent">
        <div class="row g-3 align-items-center">
            <div class="col">
                <h5 class="mb-0">Analytics Dashboard</h5>
            </div>
            <div class="col">
                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                    <div class="dropdown">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'Today']) }}">Today</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'Yesterday']) }}">Yesterday</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'This Week']) }}">This Week</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'Last 7 Days']) }}">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'This Month']) }}">This Month</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'Last 30 Days']) }}">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'This Year']) }}">This Year</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['filter' => 'All']) }}">All</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <canvas id="viewsChart"></canvas>
    </div>
</div>
<br>


<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
    <!-- Total Sessions -->
    <div class="col mb-2">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Sessions</p>
                        <h4 class="my-1">{{ $totalSessions }}</h4>
                    </div>
                    <div class="widget-icon-large bg-gradient-purple text-white ms-auto">
                        <i class="bi bi-house-door"></i> <!-- House icon for sessions -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-2">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Visitors</p>
                        <h4 class="my-1">{{ $visitors }}</h4>
                    </div>
                    <div class="widget-icon-large bg-gradient-success text-white ms-auto">
                        <i class="bi bi-person-fill"></i> <!-- Person icon for visitors -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-2">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Page views</p>
                        <h4 class="my-1">{{ $pageviews }}</h4>
                    </div>
                    <div class="widget-icon-large bg-gradient-danger text-white ms-auto">
                        <i class="bi bi-file-earmark-text"></i> <!-- File icon for pageviews -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-2">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Bounce Rate</p>
                        <h4 class="my-1">{{ $bounceRate }}%</h4>
                    </div>
                    <div class="widget-icon-large bg-gradient-info text-white ms-auto">
                        <i class="bi bi-pie-chart-fill"></i> <!-- Pie chart icon for bounce rate -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="card radius-10">
    <div class="card-header bg-transparent">
        <h5 class="mb-0">Most Visited Pages</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Page URL</th>
                    <th>Page Views</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mostVisitedPages as $page)
                    <tr>
                        <td>{{ $page->page_url }}</td>
                        <td>{{ $page->pageviews }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>

<div class="card radius-10">
    <div class="card-header bg-transparent">
        <h5 class="mb-0">Top Browsers</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Browser</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topBrowsers as $browser)
                    <tr>
                        <td>{{ $browser->browser }}</td>
                        <td>{{ $browser->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('viewsChart').getContext('2d');
    var viewsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Total Pageviews',
                    data: @json($hourlyViews),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false },
            },
            scales: {
                x: { grid: { display: false } },
                y: { 
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 }
                }
            }
        }
    });
</script>

