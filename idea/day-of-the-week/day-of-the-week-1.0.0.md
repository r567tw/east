## 判斷星期幾 API 規格文件 1.0.0

### 概述

`判斷星期幾 API` 提供一個簡單的服務，使用者提供日期，API 將回傳該日期為星期幾。

---

### Base URL

```
GET /api/day-of-the-week
```

---

### 請求參數（Query Parameters）

| 參數名稱   | 類型     | 必填 | 描述                    |
|--------|--------|----|-----------------------|
| `date` | string | 是  | 欲查詢的日期（格式：YYYY-MM-DD） |


### 回傳格式（Response Format）

#### 成功回應 (200 OK)

```json
{
    "date": "2025-04-22",
    "dayOfWeek": "Tuesday"
}
```

#### 失敗回應（例如參數錯誤）

- **422 Unprocessable Entity**

```json
{
    "error": "Invalid or missing 'date' parameter. Expected format: YYYY-MM-DD"
}
```

### 範例請求

```
GET /api/day-of-the-week?date=2025-04-22
```

回傳內容

```json
{
    "date": "2025-04-22",
    "dayOfWeek": "Tuesday"
}
```
