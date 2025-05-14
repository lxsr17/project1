<header class="admin-header">
    <div class="container">
        <div class="header-left">
            <h1>لوحة تحكم المشرف</h1>
        </div>
        <div class="header-right">
            <span class="admin-name">مرحبًا، {{ Auth::guard('admin')->user()->admin_name ?? 'مشرف' }}</span>

            <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-button">تسجيل الخروج</button>
            </form>

            <!-- Dark Mode Toggle Button -->
            <button id="dark-mode-toggle" class="dark-mode-btn">
                <span id="dark-mode-icon" class="icon">🌙</span> <!-- Icon for Dark Mode -->
            </button>
        </div>
    </div>
</header>

<!-- Add this JavaScript to handle dark mode toggle -->
<script>
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const darkModeIcon = document.getElementById('dark-mode-icon');
    const body = document.body;

    // Check if dark mode is already enabled from localStorage
    if(localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark-mode');
        darkModeIcon.textContent = '🌞';  // Change the icon to Sun (Day mode)
    }

    // Toggle dark mode on button click
    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');

        // Change the icon based on mode
        if (body.classList.contains('dark-mode')) {
            darkModeIcon.textContent = '🌞';  // Change to Sun icon (Day mode)
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            darkModeIcon.textContent = '🌙';  // Change to Moon icon (Night mode)
            localStorage.setItem('dark-mode', 'disabled');
        }
    });
</script>
