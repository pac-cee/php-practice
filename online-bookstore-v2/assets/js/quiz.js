class QuizManager {
    constructor() {
        this.currentQuestion = 0;
        this.answers = [];
        this.questions = [];
        this.timeLeft = 0;
        this.timer = null;
        
        this.initializeQuiz();
    }

    initializeQuiz() {
        this.loadQuestions();
        this.setupEventListeners();
        this.updateProgress();
        this.startTimer();
    }

    loadQuestions() {
        const quizContainer = document.querySelector('.quiz-container');
        if (!quizContainer) return;

        // Get quiz data from data attribute or fetch from server
        const quizData = quizContainer.dataset.quiz;
        if (quizData) {
            this.questions = JSON.parse(quizData);
            this.renderQuestion();
        }
    }

    setupEventListeners() {
        document.addEventListener('DOMContentLoaded', () => {
            const nextButton = document.querySelector('.quiz-button.next');
            const prevButton = document.querySelector('.quiz-button.prev');
            const submitButton = document.querySelector('.quiz-button.submit');

            if (nextButton) {
                nextButton.addEventListener('click', () => this.nextQuestion());
            }
            if (prevButton) {
                prevButton.addEventListener('click', () => this.previousQuestion());
            }
            if (submitButton) {
                submitButton.addEventListener('click', () => this.submitQuiz());
            }

            // Setup option selection
            document.querySelectorAll('.option-button').forEach(button => {
                button.addEventListener('click', (e) => this.selectOption(e));
            });
        });
    }

    renderQuestion() {
        const question = this.questions[this.currentQuestion];
        if (!question) return;

