
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Toggle sidebar
document.addEventListener('DOMContentLoaded', function() {
    const toggleSidebar = document.getElementById('toggle-sidebar');
    
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function() {
            const sidebar = this.closest('.h-screen');
            
            if (sidebar.classList.contains('w-64')) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-16');
                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m9 18 6-6-6-6"></path></svg>';
            } else {
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-64');
                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m15 18-6-6 6-6"></path></svg>';
            }
        });
    }
});
