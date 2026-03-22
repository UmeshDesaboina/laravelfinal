@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Product List</h4>
        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition-colors">
            Add New Product
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                    <th class="py-4 px-6">Image</th>
                    <th class="py-4 px-6">Name</th>
                    <th class="py-4 px-6">Category</th>
                    <th class="py-4 px-6">Price</th>
                    <th class="py-4 px-6">Stock</th>
                    <th class="py-4 px-6">Featured</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($products as $product)
                    <tr class="text-sm text-gray-700 dark:text-gray-300">
                        <td class="py-4 px-6">
                            @if($product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image) }}" class="w-12 h-12 rounded-lg object-cover" alt="">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-medium text-gray-800 dark:text-white">{{ $product->name }}</td>
                        <td class="py-4 px-6">{{ $product->category->name }}</td>
                        <td class="py-4 px-6">₹{{ number_format($product->price, 2) }}</td>
                        <td class="py-4 px-6">{{ $product->stock }}</td>
                        <td class="py-4 px-6">
                            <button onclick="toggleFeatured({{ $product->id }})" id="featured-btn-{{ $product->id }}" 
                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $product->is_featured ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $product->is_featured ? 'Featured' : 'Standard' }}
                            </button>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
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
        {{ $products->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleFeatured(id) {
        fetch(`{{ url('admin/products/featured-toggle') }}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const btn = document.getElementById(`featured-btn-${id}`);
                if (data.is_featured) {
                    btn.classList.remove('bg-gray-100', 'text-gray-700');
                    btn.classList.add('bg-yellow-100', 'text-yellow-700');
                    btn.innerText = 'Featured';
                } else {
                    btn.classList.remove('bg-yellow-100', 'text-yellow-700');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                    btn.innerText = 'Standard';
                }
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Featured status updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>
@endpush
