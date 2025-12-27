<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
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
                    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="flex items-start">
                            <div class="mr-6">
                                @if($student->photo)
                                    <img src="{{ Storage::url($student->photo) }}" alt="Profile Photo" class="h-32 w-32 rounded-full object-cover border-4 border-indigo-50">
                                @else
                                    <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center text-4xl text-gray-500 border-4 border-indigo-50">
                                        {{ substr($student->full_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" :value="__('Full Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $student->full_name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email (Read Only) -->
                                <div class="mt-4">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full bg-gray-100 cursor-not-allowed" type="email" name="email" :value="$user->email" readonly />
                                    <p class="text-xs text-gray-500 mt-1">Email cannot be changed.</p>
                                </div>

                                <!-- Phone -->
                                <div class="mt-4">
                                    <x-input-label for="phone" :value="__('Phone Number')" />
                                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $student->phone)" required />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <!-- Photo Upload -->
                                <div class="mt-4">
                                    <x-input-label for="photo" :value="__('Change Photo')" />
                                    <input id="photo" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="photo">
                                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button>
                                        {{ __('Save Changes') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
