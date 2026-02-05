<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ライブラリ') - {{ config('app.name') }}</title>
    <style>
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --border-color: #dee2e6;
            --accent-color: #3498db;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --bg-primary: #1a1a1a;
            --bg-secondary: #2d2d2d;
            --text-primary: #e9ecef;
            --text-secondary: #adb5bd;
            --border-color: #495057;
            --accent-color: #5dade2;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg-secondary);
            color: var(--text-primary);
            line-height: 1.6;
            transition: background 0.3s, color 0.3s;
        }

        header {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-content h1 {
            font-size: 1.5rem;
            color: var(--accent-color);
        }

        .theme-toggle {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .theme-toggle:hover {
            background: var(--border-color);
        }

        .filters {
            background: var(--bg-primary);
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .filter-group {
            margin-bottom: 1rem;
        }

        .filter-group:last-child {
            margin-bottom: 0;
        }

        .filter-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .filter-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-size: 1rem;
        }

        .tag-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tag-filter {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            background: var(--bg-secondary);
            cursor: pointer;
            transition: all 0.2s;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .tag-filter:hover {
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }

        .tag-filter.active {
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .image-item {
            background: var(--bg-primary);
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: var(--shadow);
        }

        .image-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .image-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .image-info {
            padding: 1rem;
        }

        .image-info .name {
            font-weight: 600;
            margin-bottom: 0.5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .image-info .meta {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* ライトボックス */
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.95);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox-content {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox-image-container {
            position: relative;
            overflow: hidden;
            cursor: grab;
        }

        .lightbox-image-container:active {
            cursor: grabbing;
        }

        .lightbox-image {
            max-width: 90vw;
            max-height: 85vh;
            object-fit: contain;
            display: block;
            transition: transform 0.3s;
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 2rem;
            padding: 1rem;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .lightbox-nav:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .lightbox-nav.prev {
            left: 1rem;
        }

        .lightbox-nav.next {
            right: 1rem;
        }

        .lightbox-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 2rem;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .lightbox-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .lightbox-info {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            padding: 1rem;
            border-radius: 4px;
            color: white;
        }

        .lightbox-info .title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .lightbox-info .meta {
            font-size: 0.9rem;
            opacity: 0.9;
        }
    </style>
    @stack('styles')
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1>@yield('header-title', config('app.name'))</h1>
                <button class="theme-toggle" onclick="toggleTheme()">
                    <span class="light-icon">🌙 ダーク</span>
                    <span class="dark-icon" style="display: none;">☀️ ライト</span>
                </button>
            </div>
        </div>
    </header>

    <div class="container">
        @yield('content')
    </div>

    <!-- ライトボックス -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" onclick="closeLightbox()">✕</button>
        <button class="lightbox-nav prev" onclick="navigateLightbox(-1)">‹</button>
        <div class="lightbox-content">
            <div class="lightbox-image-container" id="imageContainer">
                <img src="" alt="" class="lightbox-image" id="lightboxImage">
            </div>
        </div>
        <button class="lightbox-nav next" onclick="navigateLightbox(1)">›</button>
        <div class="lightbox-info">
            <div class="title" id="lightboxTitle"></div>
            <div class="meta" id="lightboxMeta"></div>
        </div>
    </div>

    <script>
        // テーマ切替
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            document.querySelectorAll('.light-icon').forEach(el => {
                el.style.display = newTheme === 'dark' ? 'none' : 'inline';
            });
            document.querySelectorAll('.dark-icon').forEach(el => {
                el.style.display = newTheme === 'dark' ? 'inline' : 'none';
            });
        }

        // 初期テーマ設定
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'dark') {
                document.querySelectorAll('.light-icon').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.dark-icon').forEach(el => el.style.display = 'inline');
            }
        })();

        // ライトボックス
        let currentImages = [];
        let currentIndex = 0;
        let zoomLevel = 1;
        let isDragging = false;
        let startX, startY, translateX = 0,
            translateY = 0;

        function openLightbox(images, index) {
            currentImages = images;
            currentIndex = index;
            showLightboxImage();
            document.getElementById('lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = '';
            zoomLevel = 1;
            translateX = 0;
            translateY = 0;
        }

        function navigateLightbox(direction) {
            currentIndex = (currentIndex + direction + currentImages.length) % currentImages.length;
            zoomLevel = 1;
            translateX = 0;
            translateY = 0;
            showLightboxImage();
        }

        function showLightboxImage() {
            const image = currentImages[currentIndex];
            const img = document.getElementById('lightboxImage');
            img.src = image.display_url;
            img.style.transform = 'scale(1) translate(0, 0)';

            document.getElementById('lightboxTitle').textContent = image.original_name;
            let meta = `${image.width} × ${image.height}`;
            if (image.genre) meta += ` | ${image.genre}`;
            if (image.tags.length) meta += ` | ${image.tags.join(', ')}`;
            document.getElementById('lightboxMeta').textContent = meta;
        }

        // ホイールズーム
        document.getElementById('imageContainer').addEventListener('wheel', (e) => {
            e.preventDefault();
            const delta = e.deltaY > 0 ? -0.1 : 0.1;
            zoomLevel = Math.min(Math.max(1, zoomLevel + delta), 3);
            const img = document.getElementById('lightboxImage');
            img.style.transform = `scale(${zoomLevel}) translate(${translateX}px, ${translateY}px)`;
        });

        // ドラッグ移動
        const container = document.getElementById('imageContainer');
        container.addEventListener('mousedown', (e) => {
            if (zoomLevel > 1) {
                isDragging = true;
                startX = e.clientX - translateX;
                startY = e.clientY - translateY;
            }
        });

        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                translateX = e.clientX - startX;
                translateY = e.clientY - startY;
                const img = document.getElementById('lightboxImage');
                img.style.transform = `scale(${zoomLevel}) translate(${translateX}px, ${translateY}px)`;
            }
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
        });

        // キーボード操作
        document.addEventListener('keydown', (e) => {
            const lightbox = document.getElementById('lightbox');
            if (lightbox.classList.contains('active')) {
                if (e.key === 'Escape') closeLightbox();
                else if (e.key === 'ArrowLeft') navigateLightbox(-1);
                else if (e.key === 'ArrowRight') navigateLightbox(1);
            }
        });

        // ライトボックス外クリックで閉じる
        document.getElementById('lightbox').addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') closeLightbox();
        });
    </script>

    @stack('scripts')
</body>

</html>