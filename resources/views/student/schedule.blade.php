@extends('student.app')
@section('content')

<div class="schedule-container">

    <div class="schedule-title">
        <h2>
            Weekly Schedule
        </h2>
    </div>

    <div class="schedule-grid">
        <div class="grid-header"></div>
        @foreach($weekDays as $day)
            <div class="grid-header">{{ $day->format('l') }}</div>
        @endforeach
        @foreach($timeSlots as $time)
            <div class="grid-header time-label">{{ \Carbon\Carbon::parse($time)->format('h:i A') }}</div>

            @foreach($weekDays as $day)
                <div class="grid-cell">
                    @php
                        $dayName = $day->format('l');
                        $events = $schedules->where('day_name', $dayName)
                                            ->where('start_time', $time);
                    @endphp

                    @foreach($events as $event)
                        @php
                            $classCss = strtolower(str_replace(' ', '-', $event->classModel->name ?? 'class'));
                        @endphp
                        <div class="course-event {{ $classCss }}">
                            <span class="event-title">{{ $event->subject->name ?? 'N/A' }}</span>
                            <span class="event-time">
                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - 
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                            </span>
                            <span class="event-location">{{ $event->location }}</span>
                            <span class="event-instructor">{{ $event->teacher_name ?? 'TBA' }}</span>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endforeach
    </div>
</div>


@endsection

@push('styles')

<style>

    .schedule-title {
        text-align: center;
        padding: 20px 0;
        background-color: #f9f9f9;
        border-bottom: 2px solid #ddd;
        margin-bottom: 10px;
    }

    .schedule-title h2 {
        margin: 0;
        font-size: 1.5rem;
        color: #333;
    }

    :root {
        --primary-color: #0056b3;
        --border-color: #ddd;
        --bg-light: #f9f9f9;
        --common-event-color-border: #4682b4; 
        --common-event-color-bg: #eef5fb;     

        --text-color: #333;
        --secondary-text-color: #555;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: var(--bg-light);
        color: var(--text-color);
    }

    .schedule-container {
        max-width: 1200px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .controls-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    .view-options button {
        padding: 10px 15px;
        border: 1px solid var(--border-color);
        background-color: white;
        cursor: pointer;
        transition: background-color 0.3s;
        border-radius: 4px;
        margin-left: -1px; 
    }

    .view-options button:hover {
        background-color: var(--bg-light);
    }

    .view-options button.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    .view-options button:first-child { border-top-left-radius: 4px; border-bottom-left-radius: 4px; margin-left: 0; }
    .view-options button:last-child { border-top-right-radius: 4px; border-bottom-right-radius: 4px; }


    .navigation {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav-arrow {
        padding: 8px 12px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .current-period {
        font-size: 1.2em;
        font-weight: bold;
    }
    .schedule-grid {
        display: grid;
        grid-template-columns: 100px repeat(7, 1fr); 
        border: 1px solid var(--border-color);
        border-radius: 5px;
        overflow: hidden;
    }

    .grid-header, .grid-cell {
        padding: 10px 5px;
        border-right: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        text-align: center;
        min-height: 100px;
    }

    .grid-header {
        background-color: var(--bg-light);
        font-weight: bold;
        text-align: center;
    }
    
    .time-label {
        background-color: var(--bg-light);
        font-size: 0.9em;
        text-align: right;
        padding-right: 10px;
    }
    .grid-header:last-child, .grid-cell:last-child {
        border-right: none;
    }
    .schedule-grid > div:nth-last-child(-n+7) { 
            border-bottom: none;
    }

    .course-event {
        background-color: var(--common-event-color-bg);
        border-left: 5px solid var(--common-event-color-border);
        
        border-radius: 5px;
        padding: 8px;
        margin: 5px;
        text-align: left;
        font-size: 0.8em;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .course-event:hover {
        transform: translateY(-2px);
    }
    .event-title { font-weight: bold; display: block; margin-bottom: 5px; color: var(--text-color); }
    .event-time, .event-location, .event-instructor { display: block; color: var(--secondary-text-color); line-height: 1.2; }
    .day-view-active .schedule-grid { grid-template-columns: 80px 1fr; }
</style>

@endpush