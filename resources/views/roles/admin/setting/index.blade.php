@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <x-notify::notify />
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <section class="my-0 dark:my-5">
            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 dark:rounded-md">
                    <div class="col-span-full xl:col-auto">
                        <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                            <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                                <div>
                                    <h3 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">Application Logo</h3>
                                    @if ($setting['app_logo'])
                                        <img src="{{ asset($setting['app_logo']) }}" alt="Application Logo"
                                            class="mb-4 border-slate-300 border-[2px] p-2 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0">
                                    @endif
                                    <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                                        JPG, SVG or PNG. Format Image
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <x-form.file-input name="app_logo" label="Image File" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                            <h3 class="mb-4 text-xl font-semibold dark:text-white">Application Name</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-form.input name="app_title" label="Application Name" value="{{ $setting['app_title'] }}" required />
                                </div>
                                <div class="col-span-6 sm:col-full">
                                    <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        Save Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
