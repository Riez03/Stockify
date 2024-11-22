@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div class="activity-feed">
                <h3>User Activity</h3>
                @foreach ($activities as $activity)
                <div>
                    <p><strong>User:</strong> {{ $activity['user_id'] }}</p>
                    <p><strong>Action:</strong> {{ $activity['action'] }}</p>
                    <p><strong>Entity:</strong> {{ $activity['entity'] }}</p>
                    <p><strong>Entity Name:</strong> {{ $activity['entity_name'] }}</p>
                    <p><strong>Message:</strong> {{ $activity['message'] }}</p>
                    <p><strong>Timestamp:</strong> {{ \Carbon\Carbon::parse($activity['timestamp'])->translatedFormat('H:i, l, F Y') }}</td>
                    </p>
                </div>
            @endforeach
            </div>
        </section>
    </div>
@endsection
