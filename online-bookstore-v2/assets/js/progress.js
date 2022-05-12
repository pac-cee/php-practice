class ProgressTracker {
    constructor() {
        this.charts = {};
        this.initializeProgress();
    }

    initializeProgress() {
        this.initializeCharts();
        this.initializeAchievements();
        this.animateStats();
    }

    initializeCharts() {
        // Reading Progress Chart
        this.createProgressChart('readingProgress', {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            data: [10, 15, 12, 25, 18, 30],
            title: 'Reading Progress'
        });

        // Quiz Performance Chart
        this.createProgressChart('quizProgress', {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            data: [75, 82, 88, 95],
            title: 'Quiz Performance'
        });
    }

    createProgressChart(elementId, config) {
        const chartElement = document.getElementById(elementId);
        if (!chartElement) return;

        const ctx = chartElement.getContext('2d');
        this.charts[elementId] = new Chart(ctx, {
            type: 'line',
            data: {
                labels: config.labels,
                datasets: [{
                    label: config.title,
                    data: config.data,
                    borderColor: getComputedStyle(document.documentElement)
                        .getPropertyValue('--primary').trim(),
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(108, 99, 255, 0.1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: config.title
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    animateStats() {
        const stats = document.querySelectorAll('.stat-value');
        stats.forEach(stat => {
            const target = parseInt(stat.dataset.value);
            this.animateNumber(stat, target);
        });
    }

    animateNumber(element, target) {
        let current = 0;
        const increment = target / 50; // Adjust for animation speed
        const interval = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(interval);
            }
            element.textContent = Math.round(current);
        }, 20);
    }

    initializeAchievements() {
        const achievements = document.querySelectorAll('.achievement-card');
        achievements.forEach(achievement => {
            if (!achievement.classList.contains('locked')) {
                achievement.addEventListener('click', () => {
                    this.showAchievementDetails(achievement);
