<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNCライブラリ - グラフィックデザイン</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .subtitle {
            color: #667eea;
            font-size: 1.2em;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .status {
            background: #f0f9ff;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
            text-align: left;
        }

        .status h2 {
            color: #667eea;
            font-size: 1.2em;
            margin-bottom: 15px;
        }

        .status-item {
            display: flex;
            align-items: center;
            margin: 10px 0;
            font-size: 0.95em;
        }

        .status-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border-radius: 50%;
            background: #10b981;
            color: white;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
        }

        .info {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }

        .info h3 {
            color: #92400e;
            margin-bottom: 10px;
        }

        .info p {
            color: #78350f;
            line-height: 1.6;
        }

        code {
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        .button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .button:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🎨 SNCライブラリ</h1>
        <p class="subtitle">グラフィックデザイン管理システム</p>

        <div class="status">
            <h2>✓ Docker環境が正常に起動しています</h2>
            <div class="status-item">
                <span class="status-icon">✓</span>
                <span>Webサーバー: Apache + PHP 8.2</span>
            </div>
            <div class="status-item">
                <span class="status-icon">✓</span>
                <span>データベース: MySQL 8.0</span>
            </div>
            <div class="status-item">
                <span class="status-icon">✓</span>
                <span>画像処理: GD & Imagick</span>
            </div>
        </div>

        <div class="info">
            <h3>📋 次のステップ</h3>
            <p>
                Laravelプロジェクトをセットアップしてください。<br>
                <code>src</code> ディレクトリにLaravelをインストールするか、<br>
                既存のプロジェクトを配置してください。
            </p>
        </div>

        <a href="http://localhost:8081" class="button" target="_blank">
            phpMyAdmin を開く
        </a>
    </div>
</body>

</html>