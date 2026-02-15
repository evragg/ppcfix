@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Order Details</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $order->order_number }}</p>
        </div>
        <div>
            <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold leading-5 {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Order Type</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($order->type) }} Order</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->created_at->format('F d, Y H:i') }}</dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Details</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if(is_array($order->details))
                        <pre>{{ json_encode($order->details, JSON_PRETTY_PRINT) }}</pre>
                    @else
                        {{ $order->details }}
                    @endif
                </dd>
            </div>
        </dl>
    </div>
    @if(Auth::user()->role === 'admin')
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <a href="{{ route('orders.edit', $order) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update Status</a>
    </div>
    @endif
</div>
@endsection
