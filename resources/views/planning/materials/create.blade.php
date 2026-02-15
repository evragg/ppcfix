@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Add Material</h3>
                <p class="mt-1 text-sm text-gray-600">Register new raw material or part.</p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('planning.materials.store') }}" method="POST">
                @csrf
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">Material Name</label>
                                <input type="text" name="name" id="name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="code" class="block text-sm font-medium text-gray-700">Material Code</label>
                                <input type="text" name="code" id="code" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="unit" class="block text-sm font-medium text-gray-700">Unit (e.g., kg, pcs)</label>
                                <input type="text" name="unit" id="unit" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="cost_per_unit" class="block text-sm font-medium text-gray-700">Cost per Unit</label>
                                <input type="number" step="0.01" name="cost_per_unit" id="cost_per_unit" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
