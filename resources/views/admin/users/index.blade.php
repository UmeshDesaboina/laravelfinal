@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Customer List</h4>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                    <th class="py-4 px-6">User</th>
                    <th class="py-4 px-6">Email</th>
                    <th class="py-4 px-6">Joined Date</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($users as $user)
                    <tr class="text-sm text-gray-700 dark:text-gray-300">
                        <td class="py-4 px-6 font-medium text-gray-800 dark:text-white">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ $user->name }}" class="w-10 h-10 rounded-full" alt="">
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">{{ $user->email }}</td>
                        <td class="py-4 px-6">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="py-4 px-6">
                            <button onclick="toggleBlock({{ $user->id }})" id="block-btn-{{ $user->id }}" 
                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_blocked ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ $user->is_blocked ? 'Blocked' : 'Active' }}
                            </button>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
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
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleBlock(id) {
        fetch(`{{ url('admin/users/toggle-block') }}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const btn = document.getElementById(`block-btn-${id}`);
                if (data.is_blocked) {
                    btn.classList.remove('bg-green-100', 'text-green-700');
                    btn.classList.add('bg-red-100', 'text-red-700');
                    btn.innerText = 'Blocked';
                } else {
                    btn.classList.remove('bg-red-100', 'text-red-700');
                    btn.classList.add('bg-green-100', 'text-green-700');
                    btn.innerText = 'Active';
                }
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: `User ${data.is_blocked ? 'blocked' : 'unblocked'} successfully`,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>
@endpush
