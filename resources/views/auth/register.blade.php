<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen items-center justify-center bg-gray-50 dark:bg-gray-800 dark:text-white">

    <div
        class="w-full max-w-md rounded-lg bg-white p-8 shadow-md dark:bg-gray-800 dark:text-white dark:shadow-sm dark:shadow-white">
        <h2 class="mb-6 text-center text-2xl font-bold text-gray-900 dark:text-white">Create Account</h2>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4">
                <p class="text-sm text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 p-4">
                <p class="text-sm text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        <form method="POST" action="/register" class="space-y-6">
            @csrf
            <!-- Name Field -->
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-white">First
                    Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                    class="mt-1 block w-full rounded-md border border-gray-300 py-1 pl-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
                @error('first_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-white">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                    class="mt-1 block w-full rounded-md border border-gray-300 py-1 pl-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
                @error('last_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">Email
                    Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border border-gray-300 py-1 pl-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-white">Password</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full rounded-md border border-gray-300 py-1 pl-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="password_confirmation"
                    class="block text-sm font-medium text-gray-700 dark:text-white">Confirm
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="mt-1 block w-full rounded-md border border-gray-300 py-1 pl-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
            </div>

            <!-- Privacy Policy Checkbox -->
            <div class="flex items-start">
                <input type="checkbox" id="privacy_policy_accepted" name="privacy_policy_accepted" value="1"
                    required class="mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="privacy_policy_accepted" class="ml-2 block text-sm text-gray-700 dark:text-white">
                    I agree to the
                    <button type="button" onclick="openTermsModal()"
                        class="cursor-pointer text-blue-600 underline hover:text-blue-500">Terms of Service</button>
                    and
                    <button type="button" onclick="openPrivacyModal()"
                        class="cursor-pointer text-blue-600 underline hover:text-blue-500">Privacy Policy</button>
                </label>
            </div>
            @error('privacy_policy_accepted')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror

            <!-- Register Button -->
            <div>
                <button type="submit"
                    class="flex w-full cursor-pointer justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Register
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-white">
                    Already have an account?
                    <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">Log in here</a>
                </p>
            </div>

        </form>
    </div>

    <!-- Terms of Service Modal -->
    <div id="termsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-red-200/10 transition-opacity" onclick="closeTermsModal()"></div>

            <!-- Modal Content -->
            <div class="relative max-h-screen w-full max-w-2xl overflow-y-auto rounded-lg bg-white shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b p-6">
                    <h3 class="text-xl font-semibold text-gray-900">Terms of Service</h3>
                    <button type="button" onclick="closeTermsModal()"
                        class="cursor-pointer text-gray-400 hover:text-gray-600">
                        <x-heroicon-o-x-mark class="h-5 w-5" />
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="space-y-4 p-6 text-sm text-gray-700">
                    <p class="text-xs text-gray-500"><strong>Last Updated:</strong> {{ date('F j, Y') }}</p>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">1. Acceptance of Terms</h4>
                        <p>By accessing and using {{ config('app.name') }}, you accept and agree to be bound by the
                            terms and provision of this agreement.</p>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">2. Service Description</h4>
                        <p>{{ config('app.name') }} is an event booking platform that allows organizers to create
                            events and users to discover and register for events.</p>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">3. User Responsibilities</h4>
                        <ul class="list-inside list-disc space-y-1">
                            <li>Provide accurate and complete information during registration</li>
                            <li>Maintain the security of your account credentials</li>
                            <li>Use the service in compliance with applicable laws</li>
                            <li>Respect the rights and privacy of other users</li>
                            <li>Attend events you have booked or cancel in advance</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">4. Account Security</h4>
                        <p>You are responsible for maintaining the confidentiality of your account and password. You
                            agree to notify us immediately of any unauthorized use of your account.</p>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">5. Privacy Protection</h4>
                        <p>Your privacy is important to us. Please review our Privacy Policy to understand how we
                            collect, use, and protect your information.</p>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">6. Contact Information</h4>
                        <p>For questions about these Terms of Service, please contact us at:
                            support@{{ strtolower(str_replace(' ', '', config('app.name'))) }}.com</p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 border-t p-6">
                    <button type="button" onclick="closeTermsModal()"
                        class="cursor-pointer rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-red-200/10 transition-opacity" onclick="closePrivacyModal()"></div>

            <!-- Modal Content -->
            <div class="relative max-h-screen w-full max-w-3xl overflow-y-auto rounded-lg bg-white shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b p-6">
                    <h3 class="text-xl font-semibold text-gray-900">Privacy Policy</h3>
                    <button type="button" onclick="closePrivacyModal()"
                        class="cursor-pointer text-gray-400 hover:text-gray-600">
                        <x-heroicon-o-x-mark class="h-5 w-5" />
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="space-y-4 p-6 text-sm text-gray-700">
                    <p class="text-xs text-gray-500"><strong>Last Updated:</strong> {{ date('F j, Y') }}</p>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">1. Introduction</h4>
                        <p>Welcome to {{ config('app.name') }}. This Privacy Policy explains how we collect, use,
                            disclose, and safeguard your information when you use our event booking system.</p>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">2. What Data We Collect</h4>
                        <p class="mb-2"><strong>Personal Information:</strong></p>
                        <ul class="mb-3 list-inside list-disc space-y-1">
                            <li><strong>Name:</strong> Your full name for account identification and event registration
                            </li>
                            <li><strong>Email Address:</strong> For account creation, login, and communication</li>
                            <li><strong>Password:</strong> Securely hashed for account access (we never store plain text
                                passwords)</li>
                            <li><strong>User Role:</strong> Whether you're a regular user or event organizer</li>
                        </ul>

                        <p class="mb-2"><strong>Activity Data:</strong></p>
                        <ul class="list-inside list-disc space-y-1">
                            <li><strong>Event Bookings:</strong> Records of events you've registered for</li>
                            <li><strong>Event Creation:</strong> Events you've organized (for organizers)</li>
                            <li><strong>Login Activity:</strong> Session data for security purposes</li>
                            <li><strong>Timestamps:</strong> When you register, book events, or perform actions</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">3. Why We Collect This Data</h4>
                        <ul class="list-inside list-disc space-y-1">
                            <li><strong>Authentication:</strong> To verify your identity and secure your account</li>
                            <li><strong>Event Participation:</strong> To manage your event bookings and attendance</li>
                            <li><strong>Communication:</strong> To send booking confirmations and important updates</li>
                            <li><strong>Service Improvement:</strong> To enhance our platform and user experience</li>
                            <li><strong>Security:</strong> To protect against unauthorized access and fraud</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">4. How We Store and Protect Your Data</h4>
                        <p class="mb-2"><strong>Security Measures:</strong></p>
                        <ul class="list-inside list-disc space-y-1">
                            <li><strong>Password Protection:</strong> All passwords are hashed using bcrypt encryption
                            </li>
                            <li><strong>Database Security:</strong> Encrypted storage with access controls</li>
                            <li><strong>Session Management:</strong> Secure session handling to prevent hijacking</li>
                            <li><strong>Access Control:</strong> Role-based permissions (users can only access their own
                                data)</li>
                            <li><strong>HTTPS:</strong> All data transmission is encrypted in transit</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">5. Your Rights</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded bg-blue-50 p-3">
                                <p class="text-xs font-medium text-blue-900">📋 Right to Access</p>
                                <p class="text-xs text-blue-800">View all your personal data through your account
                                    dashboard.</p>
                            </div>
                            <div class="rounded bg-green-50 p-3">
                                <p class="text-xs font-medium text-green-900">✏️ Right to Update</p>
                                <p class="text-xs text-green-800">Modify your profile information at any time.</p>
                            </div>
                            <div class="rounded bg-yellow-50 p-3">
                                <p class="text-xs font-medium text-yellow-900">🗑️ Right to Delete</p>
                                <p class="text-xs text-yellow-800">Request deletion of your account and data.</p>
                            </div>
                            <div class="rounded bg-purple-50 p-3">
                                <p class="text-xs font-medium text-purple-900">📤 Data Portability</p>
                                <p class="text-xs text-purple-800">Export your data upon request.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold text-gray-900">6. Contact Us</h4>
                        <p>If you have any questions about this Privacy Policy, please contact us at:
                            griffithuni@gmai.com</p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 border-t p-6">
                    <button type="button" onclick="closePrivacyModal()"
                        class="cursor-pointer rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modals -->
    <script>
        // Terms Modal Functions
        function openTermsModal() {
            document.getElementById('termsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeTermsModal() {
            document.getElementById('termsModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore background scrolling
        }

        // Privacy Modal Functions
        function openPrivacyModal() {
            document.getElementById('privacyModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closePrivacyModal() {
            document.getElementById('privacyModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore background scrolling
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.matches('#termsModal')) {
                closeTermsModal();
            }
            if (event.target.matches('#privacyModal')) {
                closePrivacyModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeTermsModal();
                closePrivacyModal();
            }
        });
    </script>

</body>

</html>
