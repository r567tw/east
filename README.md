# EAST

[![Deploy](https://github.com/r567tw/east/actions/workflows/deploy.yml/badge.svg)](https://github.com/r567tw/east/actions/workflows/deploy.yml)
[![codecov](https://codecov.io/github/r567tw/east/graph/badge.svg?token=YMF3NXRXRJ)](https://codecov.io/github/r567tw/east)

一個基於 Laravel 12 的個人 Side Project，整合多元化 API 服務與實用工具的全端 Web 應用程式。

## 🚀 特色功能

### API

- **認證系統** - JWT 認證機制，包含註冊、登入、刷新 token
- **短網址** - 建立 URL 縮短與訪問統計
- **實用工具 API**：
    - 黃金價格查詢
    - 空氣查詢
    - 占星資訊查詢
    - 位置服務

### Web

- **與 LINE Bot 整合** - LINE Webhook 處理

## 🛠 技術架構

- **後端**: Laravel 12 + PHP 8.2
- **認證**: JWT (tymon/jwt-auth)
- **快取**: Redis (上線環境)
- **資料庫**: PostgreSQL (上線環境) SQLite (本地環境)
- **測試**: PHPUnit
- **DevOps**: Github Action

## 📦 安裝步驟

```bash
# 複製專案
git clone https://github.com/r567tw/east.git
cd east

# 安裝依賴
composer install

# 如果想要啟用 laravel pint 在 每次 Git Commit 時 (Optional)
cp .pre-commit/pint .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit


# 環境設定
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# 資料庫設定
touch database/database.sqlite
php artisan migrate

# 啟動服務
php artisan serve
```

## 🔧 環境變數設定

```bash
# JWT 設定
JWT_SECRET=your_jwt_secret

# LINE Bot 設定
LINE_CHANNEL_SECRET=your_line_channel_secret
LINE_CHANNEL_ACCESS_TOKEN=your_line_access_token

# 第三方 API
CWB_API_KEY=your_weather_api_key # 整合中央氣象局 公開資訊 API
GOOGLE_GEMINI_API_KEY=your_gemini_api_key # 整合 AI API
```

## 🧪 測試

```bash
# 執行所有測試
php artisan test

# 執行特定測試
php artisan test --filter=LineWebhookMiddlewareTest

# 加入測試覆蓋率報告
php artisan test --coverage
```

## 📝 部署資訊

### Vultr Specification

#### AMD High Performance

- **1 vCPU, 1 GB RAM, 25 GB Storage, 2 TB Transfer (6 USD)(Current)**
- 1 vCPU, 2 GB RAM , 50 GB Storage, 3 TB Transfer (12 USD)
- 2 vCPU, 2 GB RAM , 60 GB Storage, 4 TB Transfer (18 USD)
- 2 vCPU, 4 GB RAM , 100 GB Storage, 5 TB Transfer (24 USD)
- 參考：https://www.vultr.com/pricing/#cloud-compute
