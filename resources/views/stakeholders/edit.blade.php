@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Stakeholder</h3>
                <p class="mt-1 text-sm text-gray-600">Update stakeholder information.</p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('stakeholders.update', $stakeholder) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="{{ $stakeholder->name }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="role" class="block text-sm font-medium text-gray-700">Role / Title</label>
                                <input type="text" name="role" id="role" value="{{ $stakeholder->role }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="matrix_position" class="block text-sm font-medium text-gray-700">Power/Interest Matrix Position</label>
                                <select id="matrix_position" name="matrix_position" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select Position...</option>
                                    @foreach(\App\Models\Stakeholder::getMatrixPositions() as $key => $label)
                                        <option value="{{ $key }}" {{ $stakeholder->matrix_position == $key ? 'selected' : '' }}>{{ $key }} ({{ $label }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
