@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section>
            <div>
                <h3 class="font-bold my-3">User Activity</h3>
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

            <div class="container my-5">
                <h1 class="font-bold">Kelola Stok Minimum</h1>
            
                <!-- Tampilkan Minimum Stock Saat Ini -->
                <p>Minimum Stock Saat Ini: <strong>{{ $minimumStock }}</strong></p>
            
                <!-- Form untuk Mengatur Minimum Stock -->
                <form action="{{ route('stock.update-minimum') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="minimum_stock">Atur Minimum Stock</label>
                        <input type="number" name="minimum_stock" id="minimum_stock" class="form-control" value="{{ $minimumStock }}" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Perbarui Minimum Stock</button>
                </form>
            
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            
            </div>
        </section>
    </div>
@endsection
