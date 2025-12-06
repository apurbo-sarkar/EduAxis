@extends('student.app')
@section('content')

<div class="report-container">
    <header>
        <h1>Academic Progress Report</h1>
        <p>Current Academic Year Summary</p>
    </header>

    <div class="overall-average">
        <span>Overall Average:</span>
        <span class="average-score">{{ $overallAverage }}% ({{ $overallGrade }})</span>
    </div>

    <main>
        @foreach($subjects as $subjectName => $subject)
            @if($subject)
            <div class="subject-card">
                <div class="subject-header">
                    <h2>{{ $subjectName }}</h2>
                    <span class="overall-mark">{{ $subject->marks_obtained }}%</span>
                </div>
                <ul class="activity-list">
                    <li class="activity-item">
                        <span>Quiz</span>
                        <span>{{ $subject->quiz }}/20</span>
                    </li>
                    <li class="activity-item">
                        <span>Assignment</span>
                        <span>{{ $subject->assignment }}/20</span>
                    </li>
                    <li class="activity-item">
                        <span>Mid Exam</span>
                        <span>{{ $subject->mid_exam }}/30</span>
                    </li>
                    <li class="activity-item">
                        <span>Final Exam</span>
                        <span>{{ $subject->final_exam }}/30</span>
                    </li>
                </ul>

            </div>
            @endif
        @endforeach
    </main>
</div>

@endsection

@push('styles')

<style>

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f8;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    .report-container {
        max-width: 800px;
        margin: auto;
        background: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    header h1 {
        color: #444;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
    }

    header p {
        color: #666;
        margin-bottom: 20px;
    }

    .overall-average {
        background-color: #007bff;
        color: white;
        padding: 15px;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        font-size: 1.2em;
        font-weight: bold;
    }

    .subject-card {
        background: #fafafa;
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .subject-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .subject-header h2 {
        margin: 0;
        color: #0056b3;
    }

    .overall-mark {
        font-size: 1.1em;
        font-weight: bold;
        color: #28a745; 
    }

    .activity-list {
        list-style-type: none;
        padding: 0;
        margin-top: 10px;
    }

    .activity-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f1f1f1;
        font-size: 0.9em;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item span:first-child {
        font-weight: bold;
    }

    .activity-item span:last-child { 
        text-align: right;
        font-weight: bold; 
        color: #333;
    }

    @media (max-width: 600px) {
        .report-container {
            padding: 10px;
        }
        .overall-average, .subject-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .overall-average span.average-score, .subject-header span.overall-mark {
            margin-top: 5px;
        }
        .activity-item {
            flex-wrap: wrap;
        }
        .activity-item span:last-child {
            margin-left: 10px;
        }

    }

</style>

@endpush