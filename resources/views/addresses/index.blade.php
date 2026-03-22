@extends('layouts.app')

@section('content')
<div class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
            <h1 class="text-4xl font-black">My Addresses</h1>
            <button onclick="openAddressModal()" class="bg-green-500 text-white px-8 py-4 rounded-full font-bold hover:bg-green-600 transition-all shadow-xl shadow-green-500/20">
                + Add New Address
            </button>
        </div>

        @if($addresses->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-[3rem] p-20 text-center shadow-sm">
                <svg class="w-20 h-20 mx-auto text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <h2 class="text-2xl font-bold mb-4">No addresses saved</h2>
                <p class="text-gray-500 mb-8">Add a shipping address to make checkout faster.</p>
                <button onclick="openAddressModal()" class="inline-block bg-green-500 text-white px-8 py-4 rounded-full font-bold hover:bg-green-600 transition-all shadow-xl">Add Your First Address</button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($addresses as $address)
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 relative group hover:shadow-xl transition-all">
                        @if($address->is_default)
                            <span class="absolute top-4 right-4 text-[10px] font-black uppercase tracking-widest text-green-500 bg-green-50 px-3 py-1 rounded-full">Default</span>
                        @endif
                        <div class="flex flex-col h-full">
                            <span class="font-bold text-xl mb-1">{{ $address->name }}</span>
                            <span class="text-sm text-gray-500 mb-4">{{ $address->phone }}</span>
                            <p class="text-sm text-gray-400 leading-relaxed flex-1">
                                {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                            </p>
                        </div>
                        <div class="flex items-center gap-4 mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                            @if(!$address->is_default)
                                <form action="{{ route('addresses.set-default', $address) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm font-bold text-green-500 hover:text-green-600">Set as Default</button>
                                </form>
                            @endif
                            <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="ml-auto">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-600" onclick="return confirm('Delete this address?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Address Modal -->
    <div id="address-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] w-full max-w-xl p-10 shadow-2xl relative">
            <button onclick="closeAddressModal()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-3xl font-black mb-8">Add New Address</h3>
            <form action="{{ route('addresses.store') }}" method="POST" id="address-form">
                @csrf
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Full Name</label>
                        <input type="text" name="name" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Phone Number</label>
                        <input type="text" name="phone" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Full Address</label>
                        <textarea name="address" rows="3" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">City</label>
                        <input type="text" name="city" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">State</label>
                        <input type="text" name="state" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Pincode</label>
                        <input type="text" name="pincode" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                    </div>
                </div>
                <div class="flex justify-end gap-4 mt-10">
                    <button type="button" onclick="closeAddressModal()" class="px-8 py-4 text-gray-500 font-bold hover:bg-gray-50 rounded-xl">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white px-10 py-4 rounded-xl font-black hover:bg-green-600 transition-all shadow-xl shadow-green-500/20">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openAddressModal() {
        document.getElementById('address-modal').classList.remove('hidden');
    }
    
    function closeAddressModal() {
        document.getElementById('address-modal').classList.add('hidden');
    }
</script>
@endpush
