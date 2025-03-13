# 🚀 Survey Sentiment Tracker

A **Laravel-based** survey sentiment analysis system using **FilamentPHP** and **Gemini AI**. This project enables survey creation, question generation with answer options using the Gemini API, sentiment analysis, and survey assignment to members. Users can log in via the frontend to complete assigned surveys.

---

## 🎯 Features

- ✅ **Survey Management**: Create, assign, and manage surveys effortlessly.
- ✅ **Sentiment Analysis**: Analyze responses using **Gemini AI** for deeper insights.
- ✅ **AI-Powered Question Generation**: Dynamically generate relevant questions and answer options.
- ✅ **Interactive Question Generation**: Click the **"Generate Questions"** button for AI-powered suggestions.
- ✅ **FilamentPHP Dashboard**: Gain insights with interactive charts and real-time data.
- ✅ **Survey Filtering**: Apply filters to analyze sentiment trends for specific surveys.
- ✅ **Sentiment-Based Charts**: Visualize sentiment trends via **bar, stacked bar, line, pie, radar, and polar area charts**.

---

## 🛠️ Installation Guide

### 1️⃣ Clone the repository:

```bash
git clone https://github.com/your-repo/survey-management.git
cd survey-management
```

### 2️⃣ Install dependencies:

```bash
composer install
npm install && npm run dev
```

### 3️⃣ Configure environment variables:

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your **database credentials** and **Google Gemini API key**:

```ini
GEMINI_API_KEY=your_api_key_here
```

### 4️⃣ Set up the database:

```bash
php artisan migrate --seed
```

### 5️⃣ Start the application:

```bash
php artisan serve
```

---

## 📊 Dashboard Insights

- 🔵 **Pie Chart**: Sentiment Distribution across responses.
- 🟠 **Bar Chart**: Sentiment Count by Survey.
- 🟢 **Stacked Bar Chart**: Sentiment Breakdown by Category.
- 🔴 **Polar Area Chart**: Comparative Sentiment Proportions.
- 🟣 **Line Chart**: Sentiment Score Changes over time.
- 🔺 **Radar Chart**: Comparative Sentiment Analysis.

---

## 🎯 Usage Guide

### 📝 Creating a Survey

1. **Navigate** to the survey creation page in the admin panel.
2. **Enter Details**: Provide a **Title** and **Description** for the survey.
3. **Assign Members**: Select members who will receive the survey.
4. **Generate AI-Based Questions**: Click the **"Generate Questions"** button to auto-generate questions.
5. **Review & Edit**: Modify questions and answer options as needed.
6. **Save & Publish**: Finalize and distribute the survey.

---

## 🤖 API Integration (Gemini AI)

- **Set up the API key in `.env`**:

```ini
GEMINI_API_KEY=your_actual_api_key_here
```

- **Fetch the API key in Laravel**:

```php
$apiKey = env('GEMINI_API_KEY');
```

---

## 🤝 Contributing

We welcome contributions! Feel free to submit **issues** or **pull requests**.

---

## 📜 License

This project is **open-source** and available under the **MIT License**.

---

🚀 Happy Surveying! 🎉
