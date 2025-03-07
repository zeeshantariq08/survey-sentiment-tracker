# 🎯 Survey Sentiment Tracker

A **Laravel-based** survey sentiment analysis system using **FilamentPHP** and **Gemini AI**. This project enables survey creation, question generation with answer options using Gemini API, sentiment analysis, and survey assignment to members. Users can log in via the frontend to complete surveys.

---

## 🚀 Features

✅ **Survey Management**: Create and assign surveys effortlessly.  
✅ **Sentiment Analysis**: Analyze responses using **Gemini AI**.  
✅ **AI-Powered Question Generation**: Generate relevant questions and answer options dynamically.  
✅ **Member Portal**: Members log in to complete assigned surveys.  
✅ **FilamentPHP Dashboard**: Visualize sentiment trends with interactive charts.  
✅ **Survey Filtering**: Filter dashboard insights based on selected surveys.  

---

## 🛠️ Installation Guide

### 1️⃣ Clone the repository:
```bash
 git clone https://github.com/zeeshantariq08/survey-sentiment-tracker.git
 cd survey-sentiment-tracker
```

### 2️⃣ Install dependencies:
```bash
 composer install
 npm install && npm run build
```

### 3️⃣ Configure environment variables:
```bash
 cp .env.example .env
 php artisan key:generate
```

### 4️⃣ Set up the database:
```bash
 php artisan migrate --seed
```

### 5️⃣ Configure Gemini API key in `.env`:
```ini
 GEMINI_API_KEY=your_actual_api_key_here
```

### 6️⃣ Start the application:
```bash
 php artisan serve
```

---

## 🤖 API Integration (Gemini AI)

🔹 **Add the API key in `.env`**:
```ini
GEMINI_API_KEY=your_actual_api_key_here
```

🔹 **Fetch API key in Laravel**:
```php
$apiKey = env('GEMINI_API_KEY');
```

🔹 **Generate survey questions using Gemini AI**:
```php
$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . env('GEMINI_API_KEY'),
])->post('https://api.gemini.com/generate-questions', [
    'survey_title' => $title
]);

$questions = $response->json();
```

---

## 📊 Dashboard Insights

🔵 **Pie Chart** → Sentiment Distribution  
🟠 **Bar Chart** → Sentiment Trend Over Time  
🟢 **Line Chart** → Sentiment Score Changes  
🔺 **Radar Chart** → Sentiment Category Analysis  

---

## 🎯 Usage Guide

1️⃣ **Create Surveys**: Define surveys and assign them to members.  
2️⃣ **Generate AI-Based Questions**: Use Gemini API for auto-generating questions and answer options.  
3️⃣ **Submit Responses**: Members log in and submit their responses.  
4️⃣ **View Sentiment Trends**: Analyze survey sentiment using the dashboard charts.  

---

## 📜 License
This project is open-source and available under the [MIT License](LICENSE).

---

💡 **Contributions & Issues**
Feel free to contribute or report any issues via GitHub!

🔗 [GitHub Repository](https://github.com/zeeshantariq08/survey-sentiment-tracker)

