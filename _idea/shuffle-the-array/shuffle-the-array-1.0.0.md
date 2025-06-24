## Shuffle the Array API 規格文件 1.0.0

### 概述

`Shuffle the Array API` 提供陣列處理的服務。本 API 接收一個整數陣列 `nums` `[x1, x2,..., xn, y1, y2,..., yn]`，與一個整數
`n`，將陣列重新排列為交錯格式 `[x1, y1, x2, y2, ..., xn, yn]`，其中 `x1...xn` 來自 `nums` 的前半段，`y1...yn` 來自後半段。

### Base URL

```
POST /api/shuffle
```

### Request Headers

| 名稱           | 值                |
|--------------|------------------|
| Content-Type | application/json |

### Request Body 範例

```json
{
    "nums": [
        2,
        5,
        1,
        3,
        4,
        7
    ],
    "n": 3
}
```

#### 欄位說明：

| 欄位     | 類型                | 描述                  | 必填 |
|--------|-------------------|---------------------|----|
| `nums` | array of integers | 長度必須為 `2 * n` 的整數陣列 | ✅  |
| `n`    | integer           | 整數，為陣列應拆分為兩半的單邊長度   | ✅  |

#### 欄位說明：

| 欄位       | 類型                | 描述        |
|----------|-------------------|-----------|
| `result` | array of integers | 經交錯排列後的陣列 |

---

### 錯誤回應

#### 400 Bad Request

- **範例：陣列長度錯誤**

```json
{
    "error": "The length of 'nums' must be exactly 2 * n."
}
```

- **範例：n 非正整數**

```json
{
    "error": "'n' must be a positive integer."
}
```

- **範例：nums 包含非整數元素**

```json
{
    "error": "'nums' must be an array of integers."
}
```


