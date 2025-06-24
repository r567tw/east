## 判斷是否為質數 API 規格文件 1.0.0

### 概述

此 API 用於判斷一個整數是否為質數。使用者傳入一個正整數，API 回傳該數是否為質數。

### Base URL

```
GET /api/is-prime
```

### 查詢參數

| 參數名稱   | 類型  | 是否必填 | 說明       |
|--------|-----|------|----------|
| number | int | 是    | 欲檢查的整數數值 |

---

### 範例請求

```http
GET /api/is-prime?number=7
```

```json
{
    "number": 7,
    "isPrime": true
}
```

錯誤回應（HTTP 422）：

```json
{
    "error": "Missing or invalid 'number' parameter."
}
```
