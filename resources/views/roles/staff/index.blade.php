@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">
          {{ $title }}
        </h1>
        
        <section>
           
        </section>
    </div>
@endsection
