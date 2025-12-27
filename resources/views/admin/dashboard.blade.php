<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Total Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-2">Total Students</h3>
                        <p class="text-4xl font-bold text-indigo-600">{{ $totalStudents }}</p>
                    </div>
                </div>

                <!-- Latest Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-4">Latest Registered Students</h3>
                        @if($latestStudents->isEmpty())
                            <p class="text-gray-500">No students found.</p>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach($latestStudents as $student)
                                    <li class="py-2 flex items-center justify-between">
                                        <div class="flex items-center">
                                            @if($student->photo)
                                                <img src="{{ Storage::url($student->photo) }}" alt="{{ $student->full_name }}" class="h-8 w-8 rounded-full mr-3 object-cover">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-gray-200 mr-3 flex items-center justify-center">
                                                    <span class="text-xs text-gray-500">{{ substr($student->full_name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <span>{{ $student->full_name }}</span>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $student->created_at->diffForHumans() }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('admin.students.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View All Students &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
