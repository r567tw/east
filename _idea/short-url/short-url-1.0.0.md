## Short URL API 規格書 1.0.0

### 概述

本 API 允許使用者建立短網址（short URL），可對其進行查詢、更新原始網址或刪除。

### 資源名稱

`ShortUrl`

### Base URL

```
/api/short-urls
```

#### 建立短網址

##### Endpoint

```
POST /api/short-urls
```

##### Request Headers

| 名稱           | 值                |
|--------------|------------------|
| Content-Type | application/json |

##### Request Body

```json
{
    "original_url": "https://www.example.com/some/very/long/url"
}
```

##### Response (201 Created)

```json
{
    "id": "1",
    "slug": "abcd",
    "original_url": "https://www.example.com/some/very/long/url",
    "created_at": "2025-04-26 12:34:56"
}
```

---

#### 取得短網址資訊

##### Endpoint

```
GET /short-urls/{id}
```

##### Response (200 OK)

```json
{
    "id": "1",
    "slug": "abcd",
    "original_url": "https://www.example.com/some/very/long/url",
    "created_at": "2025-04-26 12:34:56"
}
```

##### Response (404 Not Found)

```json
{
    "error": "Short URL not found."
}
```

---

#### 更新短網址的原始 URL

##### Endpoint

```
PUT /short-urls/{1}
```

##### Request Body

```json
{
    "original_url": "https://www.new-url.com"
}
```

##### Response (200 OK)

```json
{
    "id": "1",
    "slug": "abcd",
    "original_url": "https://www.new-url.com",
    "updated_at": "2025-04-26T14:10:00Z"
}
```

---

#### 刪除短網址

##### Endpoint

```
DELETE /short-urls/{id}
```

##### Response (204 No Content)

#### 錯誤格式統一範例

```json
{
    "error": "Description of the error."
}
```

## 資料格式限制

| 欄位             | 條件                           |
|----------------|------------------------------|
| `original_url` | 必填，必須為有效 URL，長度建議不超過 2048 字元 |
| `slug`         | 系統產生，四碼英文數字                  |
