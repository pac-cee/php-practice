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
themeBtn.onclick = function() {
    const current = getTheme();
    if (current === 'light') setTheme('dark');
    else if (current === 'dark') setTheme('system');
    else setTheme('light');
};
applyTheme();
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applyTheme);

// Profile dropdown functionality
const profileBtn = document.getElementById('profileBtn');
const profileMenu = document.getElementById('profileMenu');

if (profileBtn && profileMenu) {
    // Toggle menu on button click
    profileBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = this.closest('.profile-dropdown');
        dropdown.classList.toggle('open');
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
            profileBtn.closest('.profile-dropdown').classList.remove('open');
        }
    });

    // Handle keyboard navigation
    profileBtn.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.click();
        }
    });

    // Close menu on Escape key
    document.addEventListener('keydown', function(e) {
