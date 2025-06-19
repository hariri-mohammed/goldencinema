<!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-8 border w-full max-w-4xl shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="flex justify-between items-center pb-6 border-b">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Edit Profile</h3>
                <p class="mt-1 text-sm text-gray-500">Update your personal information and password</p>
            </div>
            <button onclick="closeProfileModal()" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        @auth('client')
            <!-- Success Message -->
            @if(session('profile_success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('profile_success') }}
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('client.profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Personal Information Section -->
                <div class="space-y-6">
                    <h4 class="text-lg font-semibold text-gray-900">Personal Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div class="space-y-2">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" id="first_name" name="first_name" 
                                value="{{ old('first_name', auth()->guard('client')->user()->first_name) }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color" required>
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="space-y-2">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" id="last_name" name="last_name" 
                                value="{{ old('last_name', auth()->guard('client')->user()->last_name) }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color" required>
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" name="username" 
                                value="{{ old('username', auth()->guard('client')->user()->username) }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color" required>
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" id="email" name="email" 
                                value="{{ old('email', auth()->guard('client')->user()->email) }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="space-y-2">
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" 
                                value="{{ old('date_of_birth', auth()->guard('client')->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->guard('client')->user()->date_of_birth)->format('Y-m-d') : '') }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color" required>
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="space-y-2">
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select id="gender" name="gender"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', auth()->guard('client')->user()->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', auth()->guard('client')->user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="space-y-2">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number" 
                                value="{{ old('phone_number', auth()->guard('client')->user()->phone_number) }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color" required>
                            @error('phone_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Change Password Section -->
                <div class="space-y-6 pt-6 border-t">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-900">Change Password</h4>
                        <span class="text-sm text-gray-500">Optional</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Current Password -->
                        <div class="space-y-2 w-full">
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" id="current_password" name="current_password"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="space-y-2 w-full">
                            <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" id="new_password" name="new_password"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="space-y-2 w-full md:col-span-2">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <button type="button" onclick="closeProfileModal()"
                        class="px-6 py-2.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-second-color hover:bg-darker-color">
                        Save Changes
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-4">
                <p class="text-gray-600">Please log in to edit your profile.</p>
                <button onclick="showLoginModal()" class="mt-4 px-4 py-2 bg-second-color text-white rounded-md hover:bg-darker-color">
                    Login
                </button>
            </div>
        @endauth
    </div>
</div>

<script>
function showProfileModal() {
    document.getElementById('profileModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeProfileModal() {
    document.getElementById('profileModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('profileModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeProfileModal();
    }
});

// Auto-open modal if there are messages
document.addEventListener('DOMContentLoaded', function() {
    @if(Auth::guard('client')->check() && (session('profile_success') || $errors->any()))
        showProfileModal();
    @endif
});
</script>