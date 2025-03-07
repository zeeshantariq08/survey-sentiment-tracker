<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Surveys</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">

<div class="max-w-4xl text-center space-y-6">
    <h1 class="text-5xl font-extrabold text-gray-800">
        AI-Powered Smart Survey & Feedback Analysis
    </h1>
    <p class="text-lg text-gray-600">
        Enhance decision-making with intelligent surveys, sentiment analysis, and real-time feedback.
    </p>

    <div class="mt-6 space-x-4">
        <a href="{{ route('member.login.form') }}"
           class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md
                      hover:bg-blue-700 transition duration-300">
            Login as Member
        </a>
{{--        <a href="{{ route('dashboard') }}"--}}
{{--           class="bg-gray-700 text-white px-6 py-3 rounded-lg shadow-md--}}
{{--                      hover:bg-gray-800 transition duration-300">--}}
{{--            Go to Dashboard--}}
{{--        </a>--}}
    </div>
</div>

</body>
</html>
