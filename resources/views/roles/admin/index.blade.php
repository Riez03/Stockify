@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div>
                <h3 class="font-bold my-3">User Activity</h3>
                @if (is_array($activities) && count($activities) > 0)
                    @foreach ($activities as $activity)
                        <div>
                            <p><strong>User:</strong> {{ $activity['user_id'] }}</p>
                            <p><strong>Action:</strong> {{ $activity['action'] }}</p>
                            <p><strong>Entity:</strong> {{ $activity['entity'] }}</p>
                            <p><strong>Entity Name:</strong> {{ $activity['entity_name'] }}</p>
                            <p><strong>Message:</strong> {{ $activity['message'] }}</p>
                            <p><strong>Timestamp:</strong>
                                {{ \Carbon\Carbon::parse($activity['timestamp'])->translatedFormat('H:i, l, F Y') }}
                            </p>
                        </div>
                    @endforeach
                @elseif (is_array($activities) && count($activities) === 0)
                    <p>Tidak ada aktivitas yang tercatat.</p>
                @else
                    <div>
                        <p><strong>User:</strong> {{ $activities['user_id'] }}</p>
                        <p><strong>Action:</strong> {{ $activities['action'] }}</p>
                        <p><strong>Entity:</strong> {{ $activities['entity'] }}</p>
                        <p><strong>Entity Name:</strong> {{ $activities['entity_name'] }}</p>
                        <p><strong>Message:</strong> {{ $activities['message'] }}</p>
                        <p><strong>Timestamp:</strong>
                            {{ \Carbon\Carbon::parse($activities['timestamp'])->translatedFormat('H:i, l, F Y') }}
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
