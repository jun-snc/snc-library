<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .container {
            text-align: center;
            padding: 2rem;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .subtitle {
            font-size: 1.2rem;
            margin-bottom: 3rem;
            opacity: 0.9;
        }

        .libraries {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .library-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            transition: all 0.3s;
            text-decoration: none;
            color: white;
            display: block;
        }

        .library-card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .library-card h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .library-card p {
            opacity: 0.9;
            line-height: 1.6;
        }

        .admin-link {
            position: fixed;
            top: 2rem;
            right: 2rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }

        .admin-link:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .libraries {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <a href="{{ route('admin.login') }}" class="admin-link">管理画面</a>

    <div class="container">
        <h1>{{ config('app.name') }}</h1>
        <p class="subtitle">デザインライブラリシステム</p>

        <div class="libraries">
            <a href="{{ route('graphic.index') }}" class="library-card">
                <h2>グラフィックデザイン</h2>
                <p>グラフィックデザイン作品の<br>画像ライブラリです</p>
            </a>

            <a href="{{ route('spatial.index') }}" class="library-card">
                <h2>空間デザイン</h2>
                <p>空間デザイン作品の<br>画像ライブラリです</p>
            </a>
        </div>
    </div>
</body>
</html>
