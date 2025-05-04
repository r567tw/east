## 判斷星期幾 API 規格文件 2.0.0

### 概述

`判斷星期幾 API 2.0.0` 提供比起 [判斷星期幾 API 規格文件 1.0.0](day-of-the-week-1.0.0.md) 更進階的服務，除了判斷星期幾以外，可以再加上
`locale` 參數，控制回傳的語言。支援英文（預設）、中文、日文。

### Base URL

```
GET /api/v2/day-of-the-week
```

### 請求參數（Query Parameters）

| 參數名稱     | 類型     | 必填 | 描述                           |
|----------|--------|----|------------------------------|
| `locale` | string | 否  | 回傳語系（支援 en, zh_TW, ja，預設 en） |

### 範例請求

```
GET /api/day-of-the-week?date=2025-04-22&locale=zh
```

回傳內容

```json
{
    "date": "2025-04-22",
    "locale": "zh_TW",
    "dayOfWeek": "Tuesday"
}
```


```
GET /api/day-of-the-week?date=2025-04-22&locale=ja
```

回傳內容

```json
{
    "date": "2025-04-22",
    "locale": "ja",
    "dayOfWeek": "火曜日"
}
```

