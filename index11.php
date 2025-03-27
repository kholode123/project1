<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وزارة التجارة الداخلية - منصة تنظيم السوق</title>
    <style>
        /* Reset and base styles */
        :root {
            --color-primary: #4CAF50;
            --color-primary-dark: #388E3C;
            --color-text: #1a1a1a;
            --color-text-light: #666;
            --color-background: #f5f5f5;
            --color-border: #e0e0e0;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --radius: 0.5rem;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            color: var(--color-text);
            background-color: var(--color-background);
        }
        /* Header styles */
        .header {
            background-color: white;
            box-shadow: var(--shadow-sm);
            padding: 1rem;
        }
        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            height: 48px;
            width: auto;
        }
        .header-titles h1 {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--color-text);
        }
        .header-titles p {
            font-size: 0.875rem;
            color: var(--color-text-light);
        }
        .header-right {
            display: flex;
            gap: 1.5rem;
        }
        .icon-button {
            background: none;
            border: none;
            color: var(--color-text-light);
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.2s;
        }
        .icon-button:hover {
            color: var(--color-text);
        }
        /* Main content styles */
        .main {
            max-width: 1280px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .location-selector {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
}

.select {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid var(--color-border);
    border-radius: var(--radius);
    background-color: white;
    font-size: 1rem;
    color: var(--color-text);
    cursor: pointer;
}

.select:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}
        /* Tabs styles */
        .tabs {
            display: flex;
            gap: 2rem;
            border-bottom: 1px solid var(--color-border);
            margin-bottom: 2rem;
        }
        .tab {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 0.25rem;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            color: var(--color-text-light);
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .tab:hover {
            color: var(--color-text);
        }
        .tab.active {
            color: var(--color-primary);
            border-bottom-color: var(--color-primary);
        }
        /* Grid styles */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background-color: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s;
        }
        .card:hover {
            box-shadow: var(--shadow-md);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 1rem;
        }
        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 0.25rem;
        }
        .card-description {
            font-size: 0.875rem;
            color: var(--color-text-light);
            margin-bottom: 0.5rem;
        }
        /* Hide inactive sections */
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/77/Emblem_of_Algeria.svg" alt="شعار الجزائر" class="logo">
                <div class="header-titles">
                    <h1>وزارة التجارة الداخلية</h1>
                    <p>منصة تنظيم السوق</p>
                </div>
            </div>
            <div class="header-right">
                <button class="icon-button" aria-label="بحث">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
                <button class="icon-button" aria-label="حساب المستخدم">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
    <div class="location-selector">
            <select id="wilayaSelect" class="select">
                <option value="">اختر الولاية</option>
                <option value="alger">الجزائر</option>
                <option value="oran">وهران</option>
                <option value="constantine">قسنطينة</option>
                <option value="annaba">عنابة</option>
            </select>
            <select id="communeSelect" class="select">
                <option value="">اختر البلدية</option>
                <option value="bab-el-oued">باب الوادي</option>
                <option value="kouba">القبة</option>
                <option value="hussein-dey">حسين داي</option>
                <option value="el-harrach">الحراش</option>
            </select>
        </div>

        <!-- Tabs -->
        <nav class="tabs">
            <button class="tab active" data-tab="stores">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/></svg>
                المتاجر
            </button>
            <button class="tab" data-tab="products">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                المنتجات
            </button>
            <button class="tab" data-tab="complaints">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                الشكاوى
            </button>
        </nav>
        
        <!-- Sections -->
        <div id="stores" class="section active">
            Stores Section
        </div>
        <div id="products" class="section">
            Products Section
        </div>
        <div id="complaints" class="section">
            Complaints Section
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to show a specific section
            function showSection(sectionId) {
                // Hide all sections
                document.querySelectorAll('.section').forEach(section => {
                    section.classList.remove('active');
                });

                // Remove 'active' class from all tabs
                document.querySelectorAll('.tab').forEach(tab => {
                    tab.classList.remove('active');
                });

                // Show the selected section
                const selectedSection = document.getElementById(sectionId);
                if (selectedSection) {
                    selectedSection.classList.add('active');
                }

                // Add 'active' class to the clicked tab
                const selectedTab = document.querySelector(`.tab[data-tab="${sectionId}"]`);
                if (selectedTab) {
                    selectedTab.classList.add('active');
                }
            }

            // Add click event listeners to tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.addEventListener('click', function () {
                    const sectionId = this.getAttribute('data-tab');
                    showSection(sectionId);
                });
            });

            // Initialize the default active tab
            const defaultTab = document.querySelector('.tab.active');
            if (defaultTab) {
                const defaultSectionId = defaultTab.getAttribute('data-tab');
                showSection(defaultSectionId);
            }
        });
    </script>
</body>
</html>
