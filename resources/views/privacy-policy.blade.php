<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">

    <!-- Header -->
    <div class="bg-white shadow-sm border-b p-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-900">Privacy Policy</h1>
            <a href="/register" class="text-blue-600 hover:text-blue-800">← Back to Registration</a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-8">

            <h1 class="text-3xl font-bold text-gray-900 mb-6">Privacy Policy</h1>
            
            <p class="text-sm text-gray-600 mb-8">
                <strong>Last Updated:</strong> {{ date('F j, Y') }}<br>
                <strong>Effective Date:</strong> {{ date('F j, Y') }}
            </p>

            <div class="prose max-w-none space-y-6">

                <!-- Introduction -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">1. Introduction</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Welcome to {{ config('app.name') }} ("we," "our," or "us"). This Privacy Policy explains how we collect, 
                        use, disclose, and safeguard your information when you use our event booking system. We are committed 
                        to protecting your privacy and ensuring the security of your personal information.
                    </p>
                </section>

                <!-- Data Collection -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">2. What Data We Collect</h2>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        We collect the following types of information to provide our services:
                    </p>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Personal Information:</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 mb-4">
                        <li><strong>Name:</strong> Your full name for account identification and event registration</li>
                        <li><strong>Email Address:</strong> For account creation, login, and communication</li>
                        <li><strong>Password:</strong> Securely hashed for account access (we never store plain text passwords)</li>
                        <li><strong>User Role:</strong> Whether you're a regular user or event organizer</li>
                    </ul>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">Activity Data:</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 mb-4">
                        <li><strong>Event Bookings:</strong> Records of events you've registered for</li>
                        <li><strong>Event Creation:</strong> Events you've organized (for organizers)</li>
                        <li><strong>Login Activity:</strong> Session data for security purposes</li>
                        <li><strong>Timestamps:</strong> When you register, book events, or perform actions</li>
                    </ul>
                </section>

                <!-- Why We Collect Data -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">3. Why We Collect This Data</h2>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        We collect and process your information for the following purposes:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li><strong>Authentication:</strong> To verify your identity and secure your account</li>
                        <li><strong>Event Participation:</strong> To manage your event bookings and attendance</li>
                        <li><strong>Communication:</strong> To send booking confirmations and important updates</li>
                        <li><strong>Service Improvement:</strong> To enhance our platform and user experience</li>
                        <li><strong>Security:</strong> To protect against unauthorized access and fraud</li>
                        <li><strong>Legal Compliance:</strong> To meet our legal obligations and terms of service</li>
                    </ul>
                </section>

                <!-- Data Storage and Protection -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">4. How We Store and Protect Your Data</h2>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Security Measures:</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                        <li><strong>Password Protection:</strong> All passwords are hashed using bcrypt encryption</li>
                        <li><strong>Database Security:</strong> Encrypted storage with access controls</li>
                        <li><strong>Session Management:</strong> Secure session handling to prevent hijacking</li>
                        <li><strong>Access Control:</strong> Role-based permissions (users can only access their own data)</li>
                        <li><strong>HTTPS:</strong> All data transmission is encrypted in transit</li>
                    </ul>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">Data Retention:</h3>
                    <p class="text-gray-700 leading-relaxed">
                        We retain your personal information only as long as necessary to provide our services or as 
                        required by law. Event booking history is kept for operational purposes and can be deleted 
                        upon request.
                    </p>
                </section>

                <!-- User Rights -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">5. Your Rights</h2>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        You have the following rights regarding your personal data:
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-medium text-blue-900 mb-2">📋 Right to Access</h4>
                            <p class="text-sm text-blue-800">View all your personal data and booking history through your account dashboard.</p>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-medium text-green-900 mb-2">✏️ Right to Update</h4>
                            <p class="text-sm text-green-800">Modify your profile information and account settings at any time.</p>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h4 class="font-medium text-yellow-900 mb-2">🗑️ Right to Delete</h4>
                            <p class="text-sm text-yellow-800">Request deletion of your account and all associated data.</p>
                        </div>
                        
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="font-medium text-purple-900 mb-2">📤 Data Portability</h4>
                            <p class="text-sm text-purple-800">Export your data in a commonly used format upon request.</p>
                        </div>
                    </div>
                </section>

                <!-- Contact Information -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">6. Contact Us</h2>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        If you have any questions about this Privacy Policy or wish to exercise your rights, please contact us:
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <ul class="text-gray-700 space-y-1">
                            <li><strong>Email:</strong> privacy@{{ strtolower(str_replace(' ', '', config('app.name'))) }}.com</li>
                            <li><strong>Response Time:</strong> We will respond to your request within 7 business days</li>
                        </ul>
                    </div>
                </section>

                <!-- Updates -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">7. Policy Updates</h2>
                    <p class="text-gray-700 leading-relaxed">
                        We may update this Privacy Policy from time to time. Any changes will be posted on this page 
                        with an updated "Last Updated" date. We encourage you to review this Privacy Policy periodically 
                        for any changes.
                    </p>
                </section>

            </div>

        </div>
    </div>

</body>
</html>