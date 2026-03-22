@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden" x-data="{ openCreateModal: false, openEditModal: false, editCategory: {} }">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Category List</h4>
        <button @click="openCreateModal = true" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition-colors">
            Add New Category
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                    <th class="py-4 px-6">Image</th>
                    <th class="py-4 px-6">Name</th>
                    <th class="py-4 px-6">Slug</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($categories as $category)
                    <tr class="text-sm text-gray-700 dark:text-gray-300">
                        <td class="py-4 px-6">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" class="w-12 h-12 rounded-lg object-cover" alt="">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-medium text-gray-800 dark:text-white">{{ $category->name }}</td>
                        <td class="py-4 px-6">{{ $category->slug }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <button @click="editCategory = {{ $category }}; openEditModal = true" class="text-blue-500 hover:text-blue-700 font-semibold">Edit</button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
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
        {{ $categories->links() }}
    </div>

    <!-- Create Modal -->
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-md p-6 shadow-xl" @click.away="openCreateModal = false">
            <h3 class="text-xl font-bold mb-4">Add New Category</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Category Name</label>
                    <input type="text" name="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Image</label>
                    <input type="file" name="image" class="w-full">
                </div>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" checked class="rounded text-green-500">
                        <span class="ml-2 text-sm">Active</span>
                    </label>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openCreateModal = false" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-md p-6 shadow-xl" @click.away="openEditModal = false">
            <h3 class="text-xl font-bold mb-4">Edit Category</h3>
            <form :action="`{{ url('admin/categories') }}/${editCategory.id}`" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Category Name</label>
                    <input type="text" name="name" x-model="editCategory.name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Image</label>
                    <input type="file" name="image" class="w-full">
                </div>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" :checked="editCategory.is_active" class="rounded text-green-500">
                        <span class="ml-2 text-sm">Active</span>
                    </label>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openEditModal = false" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
