@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Production System -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                Total Products
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $productCount }}
            </dd>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
                <a href="{{ route('products.index') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    View Production System <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Planning -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Active Schedules
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $activeSchedulesCount }}
            </dd>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
                <a href="{{ route('planning.schedule.index') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    View Planning <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Control -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Pending Orders
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $pendingOrdersCount }}
            </dd>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
                <a href="{{ route('orders.index') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Production Control <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Business Model -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Stakeholders
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $stakeholderCount }}
            </dd>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
                <a href="{{ route('stakeholders.index') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Business Model <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            System Overview
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Production Automatic Filling System status.
        </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">
            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Database Connection
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if(str_starts_with($dbConnectionStatus, 'Not Connected'))
                        <span class="text-red-600 font-bold">{{ $dbConnectionStatus }}</span>
                    @else
                        <span class="text-green-600 font-bold">{{ $dbConnectionStatus }}</span> ({{ $dbName }})
                    @endif
                </dd>
            </div>
             <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    System Time
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ now() }}
                </dd>
            </div>
        </dl>
    </div>
</div>
@endsection
