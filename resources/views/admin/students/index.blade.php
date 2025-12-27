<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Students') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Student List</h3>
                        
                        <div class="flex items-center">
                            <form action="{{ route('admin.students.index') }}" method="GET" class="mr-4">
                                <div class="flex items-center">
                                    <input type="text" name="search" placeholder="Search students..." class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" value="{{ request('search') }}">
                                    <button type="submit" class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded text-sm">
                                        Search
                                    </button>
                                </div>
                            </form>
                            <a href="{{ route('admin.students.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Add New Student
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto" x-data="{ deleteUrl: '' }">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($students as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($student->photo)
                                                <img src="{{ Storage::url($student->photo) }}" alt="" class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                    {{ substr($student->full_name, 0, 1) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $student->full_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $student->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $student->phone }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.students.edit', $student->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <button
                                                x-on:click.prevent="deleteUrl = '{{ route('admin.students.destroy', $student->id) }}'; $dispatch('open-modal', 'delete-student-modal')"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No students found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <x-modal name="delete-student-modal" focusable>
                            <form method="POST" :action="deleteUrl" class="p-6">
                                @csrf
                                @method('DELETE')
            
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Are you sure you want to delete this student?') }}
                                </h2>
            
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __('Once the student is deleted, all of their data will be permanently deleted.') }}
                                </p>
            
                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>
            
                                    <x-danger-button class="ml-3">
                                        {{ __('Delete Student') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                    
                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
