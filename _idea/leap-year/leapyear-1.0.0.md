## 閏年 API 規格文件 1.0.0

### 概述

此 API 用於判斷一個年份是否為閏年。使用者傳入一個整數，API 回傳該年份是否為閏年。

### Base URL

```
GET /api/leap-year
```

### 查詢參數

| 參數名稱 | 類型  | 是否必填 | 說明     |
|------|-----|------|--------|
| year | int | 是    | 欲檢查的年份 |

### 範例請求

```http
GET /api/leap-year?year=2025

### 回應格式（JSON）

成功回應（HTTP 200）：

```json
{
    "year": 2025,
    "isLeapYear": false
}
```

錯誤回應（HTTP 422 Unprocessable Entity）：

```json
{
    "error": "Missing or invalid 'year' parameter."
}
```

### 回傳欄位說明

| 欄位名稱       | 類型   | 說明       |
|------------|------|----------|
| year       | int  | 使用者傳入的年份 |
| isLeapYear | bool | 是否為閏年    |
