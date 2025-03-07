<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $survey->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS for styling -->
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">{{ $survey->title }}</h1>
    <p class="mb-6">{{ $survey->description }}</p>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('survey.store', $survey->id) }}">
        @csrf

        @foreach($survey->questions as $question)
            <div class="mb-6">
                <label class="block font-semibold mb-2">{{ $question->question }}</label>

                @if($question->type === 'open-ended')
                    <!-- Open-ended: Textarea -->
                    <textarea name="answers[{{ $question->id }}]" class="border p-2 w-full rounded" rows="3" required></textarea>

                @elseif($question->type === 'scale')
                    <!-- Scale (1-10) -->
                    <div class="flex space-x-2">
                        @for($i = 1; $i <= 10; $i++)
                            <label class="inline-flex items-center">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $i }}" required class="mr-1">
                                {{ $i }}
                            </label>
                        @endfor
                    </div>



                @elseif($question->type === "multiple-choice" )
                    <!-- Multiple Choice Options -->
                        @foreach($question->answerOptions as $option)
                            <div>
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option['option_text'] }}" required>
                                <label>{{ $option['option_text'] }}</label>
                            </div>
                        @endforeach


                @endif
            </div>
        @endforeach

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>

</body>
</html>
