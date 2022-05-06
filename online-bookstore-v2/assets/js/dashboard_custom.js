// Dashboard JS for Features & Theme
// Theme toggle
const themeBtn = document.getElementById('theme-btn');
const themeIcon = document.getElementById('theme-icon');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
function setTheme(theme) {
    document.documentElement.classList.toggle('dark', theme === 'dark');
    localStorage.setItem('theme', theme);
    themeIcon.textContent = theme === 'dark' ? '🌙' : (theme === 'light' ? '🌞' : '🌗');
}
function getTheme() {
    return localStorage.getItem('theme') || 'system';
}
function applyTheme() {
    const theme = getTheme();
    if (theme === 'dark') setTheme('dark');
    else if (theme === 'light') setTheme('light');
    else setTheme(prefersDark ? 'dark' : 'light');
}
