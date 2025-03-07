<div class="bg-white p-4 rounded-lg shadow">
    <h2 class="text-lg font-bold mb-3">Survey Sentiment Analysis</h2>
    <canvas id="sentimentChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('sentimentChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Sentiment Distribution',
                data: @json($values),
                backgroundColor: ['#4CAF50', '#FFEB3B', '#F44336'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
