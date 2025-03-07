<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 font-sans">

<!-- Navbar -->
<header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">📋 Member Dashboard</h1>
    <form action="{{ route('member.logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-900 transition duration-300">
            🚪 Logout
        </button>
    </form>
</header>

<!-- Dashboard Content -->
<main class="p-6">
    <h3 class="text-3xl font-bold text-center mb-8 text-gray-900">Your Assigned Surveys</h3>

    <!-- Search Bar -->
    <div class="flex justify-center mb-6">
        <input id="search" type="text" placeholder="🔍 Search surveys..."
               class="px-4 py-2 w-1/2 border border-gray-400 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-700">
    </div>

    <!-- Surveys Grid -->
    <div id="surveyContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($surveys as $assignment)
            <div class="survey-card bg-white p-6 shadow-md rounded-lg transform transition duration-300 hover:scale-105 hover:shadow-xl relative">
                <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $assignment->survey->title }}</h4>
                <p class="text-gray-600 mb-4">{{ Str::limit($assignment->survey->description, 80) }}</p>

                @if($assignment->status === 'completed')
                    <!-- Completed Badge -->
                    <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">✅ Completed</span>
                    <button class="block w-full text-center bg-gray-400 text-white py-2 rounded-lg cursor-not-allowed" disabled>
                        🎉 Completed
                    </button>
                @else
                    <!-- Take Survey Button -->
                    <a href="{{ route('survey.show', $assignment->survey->id) }}"
                       class="block text-center bg-gray-700 text-white py-2 rounded-lg hover:bg-gray-900 transition duration-300">
                        📝 Take Survey
                    </a>
                @endif
            </div>
        @endforeach

    </div>
</main>

<script>
    // Search filter functionality
    document.getElementById("search").addEventListener("input", function () {
        let filter = this.value.toLowerCase();
        let surveys = document.querySelectorAll(".survey-card");

        surveys.forEach(card => {
            let title = card.querySelector("h4").textContent.toLowerCase();
            card.style.display = title.includes(filter) ? "block" : "none";
        });
    });
</script>

</body>
</html>
