@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalOrders }}</h3>
        </div>
        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">₹{{ number_format($totalRevenue, 2) }}</h3>
        </div>
        <div class="p-3 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalUsers }}</h3>
        </div>
        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 text-purple-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Products Sold</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalProductsSold }}</h3>
        </div>
        <div class="p-3 bg-orange-100 dark:bg-orange-900/30 text-orange-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Sales Chart -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Sales Analytics</h4>
        <canvas id="salesChart"></canvas>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Recent Orders</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                        <th class="pb-3 px-2">Order ID</th>
                        <th class="pb-3 px-2">User</th>
                        <th class="pb-3 px-2">Amount</th>
                        <th class="pb-3 px-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($recentOrders as $order)
                        <tr class="text-sm text-gray-700 dark:text-gray-300">
                            <td class="py-4 px-2">{{ $order->order_number }}</td>
                            <td class="py-4 px-2">{{ $order->user->name }}</td>
                            <td class="py-4 px-2">₹{{ number_format($order->total, 2) }}</td>
                            <td class="py-4 px-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($order->status === 'delivered') bg-green-100 text-green-700
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-blue-100 text-blue-700 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesData->pluck('date')) !!},
            datasets: [{
                label: 'Sales (₹)',
                data: {!! json_encode($salesData->pluck('total')) !!},
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
