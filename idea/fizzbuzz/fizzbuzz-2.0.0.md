## FizzBuzz API 規格文件 2.0.0

### 概述

`FizzBuzz API 2.0.0` 提供比起 [FizzBuzz API 1.0.0](fizzbuzz-1.0.0.md) 更進階的服務，除了提供起始數字與結束數字，API
將根據客製化規則回傳對應的結果。

### 新增功能說明

用戶可以自訂多組 `[條件數字 → 對應字串]` 規則。例如：

- 3: `"Fizz"`
- 5: `"Buzz"`
- 7: `"Jazz"`

當某個數字能被多個條件整除時，會將對應字串合併起來（例如 `3*5*7 = 105`，輸出為 `"FizzBuzzJazz"`）

### Base URL

```
POST /api/v2/fizzbuzz
```

### 請求格式（Request Body）

```json
{
    "start": 1,
    "end": 35,
    "rules": {
        "3": "Fizz",
        "5": "Buzz",
        "7": "Jazz"
    }
}
```

#### 請求 Body 參數（Query Parameters）

| 參數名稱    | 類型      | 必填 | 描述           |
|---------|---------|----|--------------|
| `start` | integer | 是  | 起始數字（例如：1）   |
| `end`   | integer | 是  | 結束數字（例如：100） |
| `rules` | array   | 是  | 規則陣列         |

### 成功回應 (200 OK)

```json
{
    "start": 1,
    "end": 35,
    "rules": {
        "3": "Fizz",
        "5": "Buzz",
        "7": "Jazz"
    },
    "result": [
        "1",
        "2",
        "Fizz",
        "4",
        "Buzz",
        "Fizz",
        "Jazz",
        "8",
        "Fizz",
        "Buzz",
        "11",
        "Fizz",
        "13",
        "Jazz",
        "FizzBuzz",
        "16",
        "17",
        "Fizz",
        "19",
        "Buzz",
        "FizzJazz",
        "22",
        "23",
        "Fizz",
        "Buzz",
        "26",
        "Fizz",
        "Jazz",
        "29",
        "FizzBuzz",
        "31",
        "32",
        "Fizz",
        "34",
        "BuzzJazz"
    ]
}

```

---

### 失敗回應範例

- **422 Unprocessable Entity** – 缺少必要欄位或參數格式錯誤

```json
{
    "error": "Missing or invalid 'rules' parameter. Must be a JSON object with integer keys."
}
```

---

### 邏輯規則說明

對於每一個數字 `n`，從 `start` 到 `end`：

1. 檢查是否能被任意 `rules` 中的 key 整除。
2. 若符合，將對應的字串依照順序合併。
3. 若沒有符合任何條件，則回傳該數字的字串表示。
