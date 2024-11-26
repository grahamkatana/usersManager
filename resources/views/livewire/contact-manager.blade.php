<div class="min-h-screen bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-orange-400">Records Management</h2>
            <button wire:click="create"
                class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                Add New Record
            </button>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="bg-green-900 text-green-200 p-4 rounded-lg mb-6">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-900 text-red-200 p-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Records Table -->
        <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Phone
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach ($contacts as $data)
                        <tr class="hover:bg-gray-700 cursor-pointer" wire:click="edit({{ $data->id }})">
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $data->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $data->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $data->phone }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $contacts->links() }}
        </div>

        <!-- Modal -->
        @if ($isOpen)
            <div class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-orange-400 mb-4">
                            {{ $isEditMode ? 'Edit Record' : 'Add New Record' }}
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-200">Name</label>
                                <input wire:model="name" type="text"
                                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 focus:border-orange-500 focus:ring-orange-500">
                                @error('name')
                                    <span class="text-orange-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200">Email</label>
                                <input wire:model="email" type="email"
                                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 focus:border-orange-500 focus:ring-orange-500">
                                @error('email')
                                    <span class="text-orange-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200">Phone</label>
                                <input wire:model="phone" type="text"
                                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-200 focus:border-orange-500 focus:ring-orange-500">
                                @error('phone')
                                    <span class="text-orange-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex justify-end space-x-3 mt-6">
                                @if ($isEditMode)
                                    <button wire:click="delete"
                                        class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                                        Delete
                                    </button>
                                    <button wire:click="update"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Update
                                    </button>
                                @else
                                    <button wire:click="store"
                                        class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                                        Save
                                    </button>
                                @endif
                                <button wire:click="closeModal"
                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
