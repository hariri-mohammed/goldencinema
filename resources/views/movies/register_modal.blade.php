<!-- Register Modal -->
<div id="registerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-2xl font-bold text-gray-900">Create Your Account</h3>
            <button onclick="closeRegisterModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('client.register') }}" method="post" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label for="register_first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" id="register_first_name" name="first_name" value="{{ old('first_name') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="register_last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" id="register_last_name" name="last_name" value="{{ old('last_name') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="register_username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="register_username" name="username" value="{{ old('username') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="register_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="register_email" name="email" value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="register_password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="register_password" name="password"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="register_date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" id="register_date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') ? \Carbon\Carbon::parse(old('date_of_birth'))->format('Y-m-d') : '' }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="register_gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="register_gender" name="gender"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="register_phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="register_phone_number" name="phone_number" value="{{ old('phone_number') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-second-color focus:ring-second-color">
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="mt-6">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 rounded border-gray-300 text-second-color focus:ring-second-color">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-700">I agree to the</label>
                        <a href="#" class="text-second-color hover:text-darker-color">Terms of Service</a>
                        <span class="text-gray-700">and</span>
                        <a href="#" class="text-second-color hover:text-darker-color">Privacy Policy</a>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-second-color hover:bg-darker-color focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-second-color">
                    Create Account
                </button>
            </div>
        </form>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <button onclick="closeRegisterModal(); document.getElementById('loginModal').classList.remove('hidden');"
                    class="font-medium text-second-color hover:text-darker-color">
                    Sign in here
                </button>
            </p>
        </div>
    </div>
</div>

<script>
function showRegisterModal() {
    document.getElementById('registerModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRegisterModal() {
    document.getElementById('registerModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('registerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRegisterModal();
    }
});
</script> 