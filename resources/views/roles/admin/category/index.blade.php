@extends('layouts.default.dashboard')
@section('content')
    <div class="px-4 pt-6">
        <h1 class="text-2xl font-medium dark:text-white text-slate-700">{{ $title }}</h1>

        <div>
            <x-table.table-layout :title="'List Product Categories'" :description="'All Information about the product categories'">
                @slot('additional')
                  <x-simple-modal 
                    id="crud-modal" title="Create New Category" 
                    buttonText="Add Data">
                    <form action="{{ route('categories.store') }}" method="POST">
                      @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                          @foreach ([
                              ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'placeholder' => 'Category name ...', 'required' => true],
                              ['name' => 'description', 'label' => 'Description', 'type' => 'text', 'placeholder' => 'Product description ...'],
                          ] as $field)
                              <div class="col-span-2">
                                <label for="{{ $field['name'] }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $field['label'] }}

                                    @if (isset($field['required']) && $field['required'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>  

                                @if($field['name'] == 'description')
                                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" {{ isset($field['required']) ? 'required' : '' }}></textarea>
                                @else
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" {{ isset($field['required']) ? 'required' : '' }}>
                                @endif
                              </div>
                          @endforeach
                        </div>
                      <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                          Add Product Category
                      </button>
                    </form>
                  </x-simple-modal>              
                @endslot

                @slot('header')
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">No.</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Name</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Description</th>
                    <th class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Action</th>
                @endslot

                @foreach ($category as $index => $categories)
                    <tr>
                        <td class="p-4 text-sm font-normal text-gray-900 border-b whitespace-nowrap dark:border-gray-500 dark:text-white">
                          {{ ($category->currentPage() - 1) * $category->perPage() + $loop->index + 1 }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $categories->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                            {{ $categories->description }}</td>
                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap border-b dark:border-gray-500 dark:text-white">
                          <a href="{{ route('categories.show', $categories->id) }}" class="text-white bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-yellow-300 dark:hover:bg-yellow-400 dark:focus:ring-yellow-800 hover:cursor-pointer">
                            <x-heroicon-s-pencil-square class="w-5 h-5 text-white" />
                          </a>
                          <form action="{{ route('categories.destroy', $categories->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure you want to delete this Category?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-800 dark:focus:ring-red-800">
                              <x-heroicon-s-trash class="w-5 h-5 text-white" />
                            </button>
                          </form>
                      </td>
                    </tr>
                @endforeach

                @slot('pagination')
                  {{ $category->links() }}
                @endslot
            </x-table.table-layout>
        </div>
        <x-notify::notify />
    </div>
@endsection
