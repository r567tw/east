## 判斷星期幾 API 規格文件 3.0.0

### 概述

`判斷星期幾 API 3.0.0` 提供比起 [判斷星期幾 API 規格文件 2.0.0](day-of-the-week-2.0.0.md)
更進階的服務，除了判斷星期幾和多語系以外，日期改用陣列傳入，可以一次判斷多個日期。

### Base URL

```
GET /api/v3/day-of-the-week
```

### 請求參數（Query Parameters）

| 名稱      | 類型       | 是否必填 | 說明                            |
|---------|----------|------|-------------------------------|
| dates[] | string[] | 是    | 一組日期（`YYYY-MM-DD` 格式）         |
| locale  | string   | 否    | 回傳語系，支援 `en`（預設）、`zh_TW`、`ja` |

### 📥 範例請求

```http
GET /api/day-of-week?dates[]=2025-04-22&dates[]=invalid&dates[]=2025-12-25&locale=zh_TW
```

---

### 📤 範例回應

```json
{
  "locale": "zh_TW",
  "results": [
    {
      "date": "2025-04-22",
      "dayOfWeek": "星期二"
    },
    {
      "date": "invalid",
      "error": "Invalid date format"
    },
    {
      "date": "2025-12-25",
      "dayOfWeek": "星期四"
    }
  ]
}
```


