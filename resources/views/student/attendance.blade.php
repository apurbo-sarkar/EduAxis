@extends('student.app')
@section('content')

<div class="container">

    <header>
        <h1>Attendance Summary</h1>

        @php
            $minAttendance = 75;
        @endphp
        <p>Total Days Recorded: {{ $attendance->days_total }}</p>
        <p>
            Minimum Attendance Required: {{ $minAttendance }}% |
            Current: {{ $percentage }}%
            @if($percentage >= $minAttendance)
                <span class="eligible">✅ Eligible</span>
            @else
                <span class="not-eligible">❌ Not Eligible</span>
            @endif
        </p>
    </header>

    <main>
        <div class="stats-card-container">
            <div class="stat-card">
                <span>Present (Days)</span>
                <span class="count present">{{ $daysPresent }}</span>
            </div>
            <div class="stat-card">
                <span>Late (Days)</span>
                <span class="count late">{{ $daysLate }}</span>
            </div>
            <div class="stat-card">
                <span>Absent (Days)</span>
                <span class="count absent">{{ $daysAbsent }}</span>
            </div>
            <div class="stat-card">
                <span>Excused (Days)</span>
                <span class="count excused">{{ $daysExcused }}</span>
            </div>
        </div>

        <h2>Attendance Distribution</h2>
        <canvas id="attendanceChart" height="150"></canvas>
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');

    const data = {
        labels: ['Present', 'Late', 'Absent', 'Excused'],
        datasets: [{
            label: 'Attendance (Days)',
            data: [
                {{ $daysPresent }},
                {{ $daysLate }},
                {{ $daysAbsent }},
                {{ $daysExcused }}
            ],
            backgroundColor: [
                'rgba(75, 192, 192, 0.6)', 
                'rgba(255, 206, 86, 0.6)', 
                'rgba(255, 99, 132, 0.6)', 
                'rgba(54, 162, 235, 0.6)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        }]
    };

    new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false, 
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw} day(s)`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Days'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Status'
                    }
                }
            }
        }
    });
</script>

@endsection
@push('styles')

<style>

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    header h1 {
        color: #2c3e50;
        border-bottom: 2px solid #ecf0f1;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    header p {
        color: #7f8c8d;
        margin-bottom: 20px;
    }

    h2 {
        margin-top: 40px;
        color: #2c3e50;
    }

    .stats-card-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        text-align: center;
        border: 1px solid #ddd;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card span:first-child {
        display: block;
        font-size: 14px;
        color: #7f8c8d;
        margin-bottom: 5px;
    }

    .count {
        font-size: 36px;
        font-weight: bold;
    }

    .present { color: #2ecc71; }
    .absent { color: #e74c3c; }
    .late { color: #f39c12; }
    .excused { color: #3498db; }
    .percentage { color: #3498db; font-weight:bold; }
    .eligible { color: #2ecc71; font-weight:bold; }
    .not-eligible { color: #e74c3c; font-weight:bold; }
    
</style>

@endpush