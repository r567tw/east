## 四的冪次 API 規格文件 1.0.0

### 概述

此 API 用於判斷一個整數是否為 4 的冪次。使用者傳入一個整數，API 回傳該數是否為 4 的冪。

### Base URL

```
GET /api/is-power-of-four
```

### 查詢參數

| 參數名稱   | 類型  | 是否必填 | 說明       |
|--------|-----|------|----------|
| number | int | 是    | 欲檢查的整數數值 |

---

### 範例請求

```http
GET /api/is-power-of-four?number=64
```

---

### 回應格式（JSON）

成功回應（HTTP 200）：

```json
{
    "number": 64,
    "isPowerOfThree": true
}
```

錯誤回應（HTTP 422 Unprocessable Entity）：

```json
{
    "error": "Missing or invalid 'number' parameter."
}
```

### 回傳欄位說明

| 欄位名稱          | 類型   | 說明         |
|---------------|------|------------|
| number        | int  | 使用者傳入的整數   |
| isPowerOfFour | bool | 是否為 4 的冪次方 |


(p.s. 到這一階段，你已經完成了 342. Power of Four https://leetcode.com/problems/power-of-four/)
