<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?= esc($errorCode) ?></title>
    <style>
        :root {
            --primary-color: #2563eb;
            --error-color: #dc2626;
            --background-color: #f3f4f6;
            --text-color: #1f2937;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: var(--background-color);
            color: var(--text-color);
        }
        
        .error-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .error-header {
            border-bottom: 2px solid var(--error-color);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .error-title {
            font-size: 2rem;
            color: var(--error-color);
            margin: 0;
        }
        
        .error-message {
            font-size: 1.2rem;
            margin: 1rem 0;
            padding: 1rem;
            background: #fee2e2;
            border-radius: 4px;
        }
        
        .error-details {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 4px;
            margin-top: 2rem;
        }
        
        .error-details pre {
            overflow-x: auto;
            background: #1f2937;
            color: #f3f4f6;
            padding: 1rem;
            border-radius: 4px;
        }
        
        .error-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .meta-item {
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 4px;
        }
        
        .meta-label {
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .button-group {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }
        
        .button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .button-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .button-secondary {
            background: var(--background-color);
            color: var(--text-color);
        }
        
        @media (max-width: 768px) {
            .error-container {
                margin: 1rem;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>