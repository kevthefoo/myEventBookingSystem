<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">

    <!-- Header -->
    <div class="bg-white shadow-sm border-b p-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-900">Terms of Service</h1>
            <a href="/register" class="text-blue-600 hover:text-blue-800">← Back to Registration</a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-8">

            <h1 class="text-3xl font-bold text-gray-900 mb-6">Terms of Service</h1>
            
            <p class="text-sm text-gray-600 mb-8">
                <strong>Last Updated:</strong> {{ date('F j, Y') }}<br>
                <strong>Effective Date:</strong> {{ date('F j, Y') }}
            </p>

            <div class="prose max-w-none space-y-6">

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">1. Acceptance of Terms</h2>
                    <p class="text-gray-700 leading-relaxed">
                        By accessing and using {{ config('app.name') }}, you accept and agree to be bound by the terms 
                        and provision of this agreement. If you do not agree to these terms, you should not use this service.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">2. Service Description</h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ config('app.name') }} is an event booking platform that allows organizers to create events 
                        and users to discover and register for events. Our service includes account management, event 
                        creation, booking management, and related features.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">3. User Responsibilities</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Provide accurate and complete information during registration</li>
                        <li>Maintain the security of your account credentials</li>
                        <li>Use the service in compliance with applicable laws</li>
                        <li>Respect the rights and privacy of other users</li>
                        <li>Attend events you have booked or cancel in advance</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">4. Account Management</h2>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        You are responsible for maintaining the confidentiality of your account and password. 
                        You agree to notify us immediately of any unauthorized use of your account.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">5. Privacy and Data Protection</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Your privacy is important to us. Please review our 
                        <a href="/privacy-policy" class="text-blue-600 hover:text-blue-800">Privacy Policy</a> 
                        to understand how we collect, use, and protect your information.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">6. Contact Information</h2>
                    <p class="text-gray-700 leading-relaxed">
                        For questions about these Terms of Service, please contact us at: 
                        support@{{ strtolower(str_replace(' ', '', config('app.name'))) }}.com
                    </p>
                </section>

            </div>

        </div>
    </div>

</body>
</html>