@extends('student.app') 

@section('content')

<div class="container my-5">
    
    <h1 class="mb-4 text-secondary border-bottom pb-2">Academic Dashboard</h1>

    <div class="row g-4">

        <div class="col-12 col-md-6 col-lg-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white text-dark border-bottom">
                    <i class="bi bi-clock-fill me-2 text-primary"></i> 
                    <strong class="text-uppercase small">Today's Schedule</strong>
                </div>
                <ul class="list-group list-group-flush" style="max-height: 150px; overflow-y: auto;">
                    
                    @forelse($schedules as $schedule)
                        @php
                            try {
                                $startTime = \Carbon\Carbon::createFromFormat(
                                    'H:i:s',
                                    $schedule->start_time,
                                    'Asia/Dhaka'
                                )->format('h:i A');

                                $endTime = \Carbon\Carbon::createFromFormat(
                                    'H:i:s',
                                    $schedule->end_time,
                                    'Asia/Dhaka'
                                )->format('h:i A');
                            } catch (\Exception $e) {
                                $startTime = 'TBA';
                                $endTime = 'TBA';
                            }
                        @endphp

                        <li class="list-group-item {{ $schedule->is_current ? 'current-class-highlight' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="{{ $schedule->is_current ? 'text-primary' : '' }}">
                                        {{ $startTime }} - {{ $endTime }}
                                    </strong>
                                    | {{ $schedule->subject->name ?? 'N/A' }}
                                </div>

                                @if($schedule->is_current)
                                    <span class="badge bg-primary rounded-pill">Current</span>
                                @endif
                            </div>

                            <small class="text-muted">
                                {{ $schedule->location ?? 'TBA' }}
                                | {{ $schedule->teacher_name ?? 'N/A' }}
                            </small>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">
                            No classes today.
                        </li>
                    @endforelse

                </ul>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white text-dark border-bottom">
                    <i class="bi bi-pie-chart-fill me-2 text-primary"></i>
                    <strong class="text-uppercase small">Attendance Trend</strong>
                </div>

                <div class="card-body d-flex justify-content-center align-items-center" style="height:200px;">

                    <div class="d-flex align-items-center justify-content-center w-100">

                        <div style="flex: 0 0 150px; display:flex; justify-content:center; align-items:center;">
                            <canvas id="attendancePie" style="max-width:150px; max-height:150px;"></canvas>
                        </div>

                        <div style="flex: 0 0 150px; padding-left: 20px; display:flex; flex-direction:column; justify-content:center; align-items:flex-start; font-size:0.9rem;">
                            <div style="font-weight:bold; font-size:1rem; margin-bottom:5px;">Total Days: {{ array_sum($attendanceCounts) }}</div>
                            <div style="color:#198754; font-weight:bold; margin-bottom:3px;">Present: {{ $attendanceCounts['P'] }}</div>
                            <div style="color:#dc3545; font-weight:bold; margin-bottom:3px;">Absent: {{ $attendanceCounts['A'] }}</div>
                            <div style="color:#ffc107; font-weight:bold; margin-bottom:3px;">Late: {{ $attendanceCounts['L'] }}</div>
                            <div style="color:#0dcaf0; font-weight:bold;">Excused: {{ $attendanceCounts['E'] }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6">
            <div class="card h-100 shadow-sm border-0 d-flex flex-column">
                <div class="card-header bg-white text-dark border-bottom">
                    <i class="bi bi-journal-check me-2 text-success"></i>
                    <strong class="text-uppercase small">Latest Grade</strong>
                </div>
                <div class="card-body flex-grow-1 p-0">
                    <ul class="list-group list-group-flush scrolling-widget" style="max-height: 150px; overflow-y: auto;">
                        @if(empty($grades))
                            <li class="list-group-item text-center text-muted">
                                No grades available.
                            </li>
                        @endif

                        @foreach($grades as $grade)
                            @php
                                $textColor = $grade['marks'] >= 80 ? 'text-success' : 'text-warning';
                            @endphp

                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title mb-0">{{ $grade['subject'] }}</h5>
                                        <p class="card-text text-muted mb-0">Grade: {{ $grade['grade'] }}</p>
                                    </div>
                                    <span class="fs-4 fw-bold {{ $textColor }}">
                                        {{ $grade['marks'] }}<span class="text-muted">/100</span>
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-footer text-end bg-light border-top">
                    <a href="#" class="btn btn-sm btn-outline-success">
                        View All Grades <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6">
            <div class="card h-100 shadow-sm border-0 d-flex flex-column">
                <div class="card-header bg-white text-dark border-bottom">
                    <i class="bi bi-megaphone-fill me-2 text-info"></i>
                    <strong class="text-uppercase small">Latest Announcements</strong>
                </div>

                <div class="card-body flex-grow-1 p-0">
                    <ul class="list-group list-group-flush scrolling-widget" style="max-height: 150px; overflow-y: auto;">
                        @if($notifications->isEmpty())
                            <li class="list-group-item text-center text-muted">
                                No announcements available.
                            </li>
                        @else
                            @foreach($notifications as $notification)
                                <li class="list-group-item d-flex align-items-start">
                                    <i class="bi bi-dot text-primary fs-4 me-2"></i>
                                    <div>
                                        <strong>{{ $notification->title }}</strong><br>
                                        <span class="text-muted small">{{ $notification->content }}</span>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="card-footer text-end bg-light border-top">
                    <a href="#" class="btn btn-sm btn-outline-secondary">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

@endsection

@push('styles')
<style>
    .current-class-highlight {
        background-color: var(--bs-primary-bg-subtle, #e0f0ff) !important; 
        border-left: 5px solid var(--bs-primary, #0d6efd);
    }
    .highlight-danger-subtle {
        background-color: var(--bs-danger-bg-subtle, #f8d7da) !important;
    }
    .highlight-warning-subtle {
         background-color: var(--bs-warning-bg-subtle, #fff3cd) !important;
    }

    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendancePie').getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Present', 'Absent', 'Late', 'Excused'],
            datasets: [{
                data: [
                    {{ $attendanceCounts['P'] }},
                    {{ $attendanceCounts['A'] }},
                    {{ $attendanceCounts['L'] }},
                    {{ $attendanceCounts['E'] }}
                ],
                backgroundColor: ['#198754','#dc3545','#ffc107','#0dcaf0'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,

            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
