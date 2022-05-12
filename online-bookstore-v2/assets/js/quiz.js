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
