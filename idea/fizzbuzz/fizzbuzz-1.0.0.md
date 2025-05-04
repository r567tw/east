## FizzBuzz API 規格文件 1.0.0

### 概述

`FizzBuzz API` 提供一個簡單的服務，使用者可以提供起始數字與結束數字，API 將回傳對應的 FizzBuzz 結果。

---

### Base URL

```
GET /api/fizzbuzz
```

---

### 請求參數（Query Parameters）

| 參數名稱    | 類型      | 必填 | 描述           |
|---------|---------|----|--------------|
| `start` | integer | 是  | 起始數字（例如：1）   |
| `end`   | integer | 是  | 結束數字（例如：100） |

---

### 回傳格式（Response Format）

#### 成功回應 (200 OK)

```json
{
    "start": 1,
    "end": 15,
    "result": [
        "1",
        "2",
        "Fizz",
        "4",
        "Buzz",
        "Fizz",
        "7",
        "8",
        "Fizz",
        "Buzz",
        "11",
        "Fizz",
        "13",
        "14",
        "FizzBuzz"
    ]
}
```

#### 失敗回應（例如參數錯誤）

- **422 Unprocessable Entity**

```json
{
    "error": "Invalid input. 'start' and 'end' must be integers, and start <= end."
}
```

---

### 邏輯規則

對於從 `start` 到 `end` 的每一個整數：

- 若該數能被 3 整除，回傳 "Fizz"
- 若該數能被 5 整除，回傳 "Buzz"
- 若該數能同時被 3 和 5 整除，回傳 "FizzBuzz"
- 否則回傳該數的字串形式

---

### 範例請求

```
GET /api/fizzbuzz?start=2&end=15
```

回傳內容

```json
{
    "start": 2,
    "end": 15,
    "result": [
        "2",
        "Fizz",
        "4",
        "Buzz",
        "Fizz",
        "7",
        "8",
        "Fizz",
        "Buzz",
        "11",
        "Fizz",
        "13",
        "14",
        "FizzBuzz"
    ]
}
```

(p.s. 到這一階段，你已經完成了 Leetcode 412. Fizz Buzz https://leetcode.com/problems/fizz-buzz/)
