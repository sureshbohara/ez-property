<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4 mt-4">
 

    <div class="col mb-2">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Services</p>
                        <h4 class="my-1">{{ $stats['services_count'] }}</h4>
                        <p class="mb-0 font-13 text-success">
                            <i class="bi bi-check-circle"></i> {{ $stats['services_active'] }} Active
                        </p>
                    </div>
                    <div class="widget-icon-large bg-gradient-primary text-white ms-auto"><i class="bi bi-hdd-network"></i></div>
                </div>
            </div>
        </div>
    </div>

   

    <div class="col mb-2">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Fleet</p>
                        <h4 class="my-1">{{ $stats['fleets_count'] }}</h4>
                        <p class="mb-0 font-13 text-info">
                            <i class="bi bi-diagram-3"></i> {{ $stats['fleets_active'] }} Active
                        </p>
                    </div>
                    <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi bi-car-front-fill"></i></div>
                </div>
            </div>
        </div>
    </div>


    <div class="col mb-2">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Reviews</p>
                        <h4 class="my-1">{{ $stats['reviews_count'] }}</h4>
                        <p class="mb-0 font-13 text-warning">
                            <i class="bi bi-star"></i> Feedback
                        </p>
                    </div>
                    <div class="widget-icon-large bg-gradient-warning text-white ms-auto"><i class="bi bi-chat-square-text"></i></div>
                </div>
            </div>
        </div>
    </div>

  
    <div class="col mb-2">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Disk Usage</p>
                        <h4 class="my-1">{{ $stats['server']['used_percent'] }}%</h4>
                        <p class="mb-0 font-13 text-danger">
                            <i class="bi bi-hdd-rack"></i> {{ $stats['server']['used_gb'] }} / {{ $stats['server']['total_gb'] }} GB
                        </p>
                    </div>
                    <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="bi bi-server"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>