# 🚀 Survey Sentiment Tracker

A **Laravel-based** survey sentiment analysis system using **FilamentPHP** and **Gemini AI**. This project enables survey creation, question generation with answer options using the Gemini API, sentiment analysis, and survey assignment to members. Users can log in via the frontend to complete assigned surveys.

---

## 🎯 Features

✅ **Survey Management**: Create and assign surveys effortlessly.\
✅ **Sentiment Analysis**: Analyze responses using **Gemini AI**.\
✅ **AI-Powered Question Generation**: Generate relevant questions and answer options dynamically.\
✅ **Interactive Question Generation**: Click the **"Generate Questions"** button to fetch AI-powered questions instead of auto-generation.\
✅ **FilamentPHP Dashboard**: Visualize sentiment trends with interactive charts.\
✅ **Survey Filtering**: Filter dashboard insights based on selected surveys.

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

Update `.env` with your database credentials and **Google Gemini API key**:

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

🔵 **Pie Chart** → Sentiment Distribution\
🟠 **Bar Chart** → Sentiment Trend Over Time\
🟢 **Line Chart** → Sentiment Score Changes\
🔺 **Radar Chart** → Sentiment Category Analysis

---

## 🎯 Usage Guide

### 📝 Creating a Survey

1️⃣ **Navigate** to the survey creation page.\
2️⃣ **Enter Details**: Fill in the survey **Title** and **Description**.\
3️⃣ **Assign Members**: Select members to receive the survey.\
4️⃣ **Generate AI-Based Questions**: Click the **"Generate Questions"** button to fetch AI-powered questions.\
5️⃣ **Review & Edit**: Modify questions and answer options as needed.\
6️⃣ **Save & Publish**: Finalize and distribute your survey.

---

## 🤖 API Integration (Gemini AI)

🔹 **Add the API key in ".env"**:

```ini
GEMINI_API_KEY=your_actual_api_key_here
```

🔹 **Fetch API key in Laravel**:

```php
$apiKey = env('GEMINI_API_KEY');
```

🤝 Contributing

We welcome contributions! Feel free to submit **issues** or **pull requests**.

---

## 📜 License

This project is **open-source** and available under the **MIT License**.

---

🚀 Happy Surveying! 🎉

