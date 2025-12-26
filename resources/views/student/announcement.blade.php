@extends('student.app')
@section('content')

    <div class="schedule-title">
        <h2>
            Campus News & Announcements
        </h2>
    </div>
    <main class="announcement-container">
        @if($announcements->count())
            <article class="announcement-card featured">
                <span class="badge featured-badge">Featured</span>
                <span class="date">
                    {{ $announcements[0]->publish_at->format('F d, Y') }}
                </span>
                <h2>{{ $announcements[0]->title }}</h2>
                <p>{{ $announcements[0]->content }}</p>
            </article>
        @endif
        @foreach($announcements->skip(1) as $announcement)
            <article class="announcement-card">
                <span class="badge news-badge">School News</span>
                <span class="date">
                    {{ $announcement->publish_at->format('F d, Y') }}
                </span>
                <h2>{{ $announcement->title }}</h2>
                <p>{{ $announcement->content }}</p>
            </article>
        @endforeach
    </main>
    
@endsection

@push('styles')
<style>
 
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f7f6;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .schedule-title {
        text-align: center;
        padding: 20px 0;
        margin-bottom: 10px;
    }

    .schedule-title h2 {
        margin: 0;
        font-size: 2.5rem;
        color: #333;
    }
    
    .announcement-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 0 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .announcement-card {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
        border-left: 5px solid #1a5276;
    }

    .announcement-card:hover {
        transform: translateY(-5px);
    }

    .announcement-card.featured {
        border-left: 5px solid #e67e22; 
        background-color: #fff9f4;
    }

    .date {
        font-size: 0.85rem;
        color: #777;
        display: block;
        margin-bottom: 10px;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
        float: right;
    }

    .featured-badge { background: #e67e22; color: white; }
    .news-badge { background: #3498db; color: white; }
    .alert-badge { background: #e74c3c; color: white; }

</style>
@endpush