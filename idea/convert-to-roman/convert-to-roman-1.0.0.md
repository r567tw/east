## 阿拉伯數字轉羅馬數字 API 規格文件 1.0.0

### 概述

將輸入的阿拉伯數字轉成羅馬數字

初期只需要處理 1~10 即可

| 阿拉伯數字 | 羅馬數字 |
|-------|------|
| 1     | I    |
| 2     | II   |
| 3     | III  |
| 4     | IV   |
| 5     | V    |
| 6     | VI   |
| 7     | VII  |
| 8     | VIII |
| 9     | IX   |
| 10    | X    |

---

### Base URL

```
GET /api/convert-to-roman
```

### 📥 Request

### 請求參數（Query Parameters）

| 參數名稱     | 類型      | 必填 | 描述            |
|----------|---------|----|---------------|
| `number` | integer | 是  | 要轉換的正整數（1~10） |

### 規格限制

- 支援正整數（`1 <= number <= 10`）
- 若輸入非整數或超出範圍，應回傳錯誤訊息

---

### 範例

#### 請求

```http
GET /api/convert-to-roman?number=9
```

#### 回應

成功回應（HTTP 200）：

```json
{
    "roman": "IX"
}
```

錯誤回應（HTTP 422 Unprocessable Entity）：

```json
{
    "error": "Missing or invalid 'number' parameter."
}
```
