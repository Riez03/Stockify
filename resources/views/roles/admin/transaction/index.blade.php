@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">
          {{ $title }}
        </h1>
        <x-notify::notify />
        
        <section>
           
        </section>
    </div>
@endsection
