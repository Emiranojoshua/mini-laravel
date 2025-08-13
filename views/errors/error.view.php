<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - 500</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: #e2e8f0;
        }


        .error-container {
            min-height: 50vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            background: rgba(26, 32, 44, 0.95);
            border-bottom: 1px solid rgba(74, 85, 104, 0.3);
        }

        .dark-toggle {
            background: none;
            border: 2px solid #e53e3e;
            color: #e53e3e;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dark-toggle:hover {
            background: #e53e3e;
            color: white;
        }

        body.dark .dark-toggle {
            border-color: #68d391;
            color: #68d391;
        }

        body.dark .dark-toggle:hover {
            background: #68d391;
            color: #1a202c;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #e53e3e;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-icon {
            width: 40px;
            height: 40px;
            background: #e53e3e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 35px;
            font-weight: bold;
            margin-right: 10px;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            display: flex;
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .error-details {
            flex: 2;
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            min-width: 0;
            overflow-wrap: break-word;
            background: rgba(26, 32, 44, 0.95);
            border: 1px solid rgba(74, 85, 104, 0.3);
        }




        .error-code {
            font-size: 2.5rem;
            font-weight: bold;
            color: #e53e3e;
            margin-bottom: 1rem;
            display: flex;
            justify-content: left;
            align-items: center;
        }

        .error-message {
            background: rgba(229, 62, 62, 0.2);
            color: #fca5a5;
            font-size: 0.9rem;
            color: #e53e3e;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: rgba(229, 62, 62, 0.1);
            border-radius: 8px;
            border-left: 4px solid #e53e3e;
            font-family: 'Monaco', 'Consolas', monospace;
            word-break: break-word;
            overflow-wrap: break-word;
            transition: all 0.3s ease;
        }


        .file-info {
            background: #0d1117;
            border: 1px solid #30363d;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 0.8rem;
            word-break: break-all;
            transition: all 0.3s ease;
        }



        .file-path {
            color: #68d391;
            font-weight: 500;
        }

        .line-number {
            color: #fbb6ce;
            margin-top: 0.25rem;
        }

        .stack-trace {
            border-radius: 8px;
            max-height: 300px;
            overflow-y: auto;
            transition: all 0.3s ease;
            background: #0d1117;
            border: 1px solid #30363d;
        }


        .stack-item {
            padding: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 0.8rem;
            word-break: break-word;
            transition: all 0.3s ease;
        }

        .stack-item:last-child {
            border-bottom: none;
        }

        .stack-item:hover {
            background: #21262d;
            cursor: pointer;
        }

        .stack-item {
            border-bottom: 1px solid #30363d;
        }

        body.dark .stack-item:hover {
            background: #21262d;
        }

        .stack-file {
            color: #2b6cb0;
            font-weight: 500;
        }

        .stack-method {
            color: #718096;
            font-size: 0.8rem;
            margin-left: 1rem;
        }

        .sidebar {
            flex: 1;
            min-width: 300px;
        }

        .info-card {
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: rgba(26, 32, 44, 0.95);
            border: 1px solid rgba(74, 85, 104, 0.3);
        }

        .info-title {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #30363d;
            font-size: 0.875rem;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #4a5568;
            font-weight: 500;
        }

        .info-value {
            color: #2d3748;
            font-family: 'Monaco', 'Consolas', monospace;
            word-break: break-word;
            transition: all 0.3s ease;
        }

        .info-title {
            color: #e2e8f0;
        }

        .info-label {
            color: #a0aec0;
        }

        .info-value {
            color: #e2e8f0;
        }

        @media (max-width: 1024px) {
            .main-content {
                padding: 1.5rem 1rem;
                gap: 1.5rem;
            }

            .error-details {
                padding: 1.25rem;
            }

            .info-card {
                padding: 1.25rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }

            .sidebar {
                min-width: unset;
            }

            .header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .header h1 {
                justify-content: center;
            }

            .error-code {
                font-size: 2.5rem;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                text-align: center;
            }

            .error-details {
                padding: 1rem;
            }

            .error-message {
                font-size: 0.8rem;
                padding: 0.75rem;
            }

            .file-info {
                font-size: 0.75rem;
                padding: 0.75rem;
            }

            .stack-item {
                padding: 0.5rem;
                font-size: 0.75rem;
            }

            .info-card {
                padding: 1rem;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
                padding: 0.5rem 0;
            }

            .info-value {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 0.75rem;
            }

            .main-content {
                padding: 0.75rem;
            }

            .error-code {
                font-size: 2rem;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                text-align: center;
            }

            .error-message {
                font-size: 0.75rem;
                padding: 0.5rem;
            }

            .file-info {
                font-size: 0.7rem;
                padding: 0.5rem;
            }

            .stack-item {
                padding: 0.4rem;
                font-size: 0.7rem;
            }

            .stack-method {
                margin-left: 0;
                margin-top: 0.25rem;
                display: block;
            }

            .info-card {
                padding: 0.75rem;
            }

            .info-title {
                font-size: 0.9rem;
            }

            .info-value {
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="main-content">
            <div class="error-details">
                <div class="error-code">
                    <div class="error-icon">!</div>
                    <?= $errorCode ?> <?= $errorName ?>
                </div>

                <div class="error-message">
                    <?= $errorMessage ?>
                </div>

                <div class="file-info">
                    <div class="file-path">File: /var/www/html/app/Http/Controllers/UserController.php</div>
                    <div class="line-number">Line: 42</div>
                </div>

                <div class="stack-trace">
                    <div class="stack-item">
                        <div class="stack-file">UserController.php:42</div>
                        <div class="stack-method">App\Http\Controllers\UserController->show()</div>
                    </div>
                    <div class="stack-item">
                        <div class="stack-file">Controller.php:54</div>
                        <div class="stack-method">Illuminate\Routing\Controller->callAction()</div>
                    </div>
                    <div class="stack-item">
                        <div class="stack-file">ControllerDispatcher.php:45</div>
                        <div class="stack-method">Illuminate\Routing\ControllerDispatcher->dispatch()</div>
                    </div>
                    <div class="stack-item">
                        <div class="stack-file">Route.php:261</div>
                        <div class="stack-method">Illuminate\Routing\Route->runController()</div>
                    </div>
                    <div class="stack-item">
                        <div class="stack-file">Route.php:204</div>
                        <div class="stack-method">Illuminate\Routing\Route->run()</div>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <div class="info-card">
                    <div class="info-title">
                        📋 Request Info
                    </div>
                    <div class="info-item">
                        <span class="info-label">Method:</span>
                        <span class="info-value">GET</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">URL:</span>
                        <span class="info-value">/users/123</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Route:</span>
                        <span class="info-value">users.show</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Time:</span>
                        <span class="info-value">14:30:25</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
