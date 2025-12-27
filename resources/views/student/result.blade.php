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

    @if($academicStatus)
    <div class="status-section">
        <div class="status-header">
            <i class="fas fa-award"></i>
            <h3>Academic Status</h3>
        </div>
        <div class="status-content">
            <div class="status-badge status-{{ strtolower(str_replace(' ', '-', $academicStatus)) }}">
                {{ $academicStatus }}
            </div>
            @if($statusRemarks)
                <div class="status-remarks">
                    <strong><i class="fas fa-comment"></i> Remarks from Administration:</strong>
                    <p>{{ $statusRemarks }}</p>
                </div>
            @endif
        </div>
    </div>
    @endif

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

    /* Status Section Styles */
    .status-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-left: 5px solid #007bff;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .status-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .status-header i {
        color: #007bff;
        font-size: 24px;
    }

    .status-header h3 {
        margin: 0;
        color: #2d3748;
        font-size: 20px;
    }

    .status-content {
        padding: 15px;
        background: white;
        border-radius: 8px;
    }

    .status-badge {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-excellent {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border: 2px solid #b1dfbb;
    }

    .status-good {
        background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        color: #0c5460;
        border: 2px solid #abdde5;
    }

    .status-satisfactory {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        color: #856404;
        border: 2px solid #ffe69c;
    }

    .status-needs-improvement {
        background: linear-gradient(135deg, #ffe5d0, #fdd1b5);
        color: #974c00;
        border: 2px solid #ffc7a3;
    }

    .status-poor {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #842029;
        border: 2px solid #f1b0b7;
    }

    .status-remarks {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .status-remarks strong {
        display: block;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .status-remarks strong i {
        color: #007bff;
        margin-right: 5px;
    }

    .status-remarks p {
        margin: 0;
        color: #4a5568;
        line-height: 1.6;
        font-size: 15px;
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
        .status-section {
            padding: 15px;
        }
    }

</style>

@endpush