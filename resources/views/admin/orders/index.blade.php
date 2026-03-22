@extends('layouts.admin')

@section('title', 'Order Management')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Order List</h4>
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-2">
            <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-semibold">Filter</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                    <th class="py-4 px-6">Order ID</th>
                    <th class="py-4 px-6">Customer</th>
                    <th class="py-4 px-6">Amount</th>
                    <th class="py-4 px-6">Payment</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($orders as $order)
                    <tr class="text-sm text-gray-700 dark:text-gray-300">
                        <td class="py-4 px-6 font-medium text-gray-800 dark:text-white">{{ $order->order_number }}</td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <span>{{ $order->user->name }}</span>
                                <span class="text-xs text-gray-500">{{ $order->user->email }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">₹{{ number_format($order->total, 2) }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <select onchange="updateOrderStatus({{ $order->id }}, this.value)" 
                                class="text-xs rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-500 hover:text-blue-700 font-semibold">View</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateOrderStatus(id, status) {
        let data = { status: status };
        
        if (status === 'shipped') {
            const courierName = prompt('Enter Courier Name (required for shipped):');
            const trackingId = prompt('Enter Tracking ID (required for shipped):');
            if (!courierName || !trackingId) {
                location.reload();
                return;
            }
            data.courier_name = courierName;
            data.tracking_id = trackingId;
        }
        
        fetch(`{{ url('admin/orders/update-status') }}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Order status updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>
@endpush
