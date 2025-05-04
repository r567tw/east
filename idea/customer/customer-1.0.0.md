## 客戶資料 API 規格文件 1.0.0

### 概述

以下是一份客戶資料的 CRUD API 規格書。

這些 API 遵循 RESTful 原則設計，可用於建立、讀取、更新與刪除客戶資料。

---

### Base URL

```
/api/customers
```

### 客戶資料結構

| 參數名稱     | 類型      | 描述                    |
|----------|---------|-----------------------|
| `id`     | integer | 客戶 id                 |
| `name`   | string  | 客戶姓名                  |
| `email`  | string  | 客戶 email              |
| `phone`  | string  | 客戶電話（僅顯示後四碼，其他需以星號掩蓋） |
| `joined` | string  | 客戶資料建立日期              |

### 客戶資料加密要求

`email` 和 `phone` 欄位在資料庫內需加密處理，不可以直接儲存。

#### 取得所有客戶（List Customers）

- **Method**: `GET`
- **Endpoint**: `/api/customers`
- **Query Parameters**:
    - `page`（可選）: 頁數，預設為 1。
    - `per_page`（可選）: 每頁筆數，預設為 10。
    - `keyword`（可選）: 根據關鍵字搜尋客戶。
- **Response**:

```json
{
    "data": [
        {
            "id": 1,
            "name": "Mrs. Beulah Friesen",
            "email": "pollich.wilton@example.net",
            "phone": "******1377",
            "joined": "2025-04-24"
        }
    ],
    "meta": {
        "current_page": 1,
        "per_page": 10,
        "total": 100
    }
}
```

#### 取得單一客戶（Get Question）

- **Method**: `GET`
- **Endpoint**: `/api/customers/{id}`
- **Response**:

```json
{
    "id": 1,
    "name": "Mrs. Beulah Friesen",
    "email": "pollich.wilton@example.net",
    "phone": "******1377",
    "joined": "2025-04-24"
}
```

#### 新增客戶（Create Question）

- **Method**: `POST`
- **Endpoint**: `/api/customers`
- **Request Body**:

```json
{
    "name": "Santina Kris",
    "email": "emiliano67@example.com",
    "phone": "0923562662"
}
```

- **Response**:

```json
{
    "id": 12,
    "name": "Santina Kris",
    "email": "emiliano67@example.com",
    "phone": "******2662",
    "joined": "2025-04-24"
}
```

- **HTTP Status**: `201 Created`

#### 更新客戶（Update Question）: PUT

需包含完整客戶內容

- **Method**: `PUT`
- **Endpoint**: `/api/customers/{id}`
- **Request Body**:

```json
{
    "name": "Judge Kilback",
    "email": "agustina.mueller@example.org",
    "phone": "0923567044"
}
```

- **Response**:

```json
{
    "id": 12,
    "name": "Judge Kilback",
    "email": "agustina.mueller@example.org",
    "phone": "******7044",
    "joined": "2025-04-24"
}
```

#### 更新客戶（Update Question）: PATCH

允許只輸入部分更新內容，不需包含完整客戶

- **Method**:  `PATCH`
- **Endpoint**: `/api/customers/{id}`
- **Request Body**:

```json
{
    "phone": "0923563652"
}
```

- **Response**:

```json
{
    "id": 12,
    "name": "Judge Kilback",
    "email": "agustina.mueller@example.org",
    "phone": "******3652",
    "joined": "2025-04-24"
}
```

#### 刪除客戶（Delete Question）

- **Method**: `DELETE`
- **Endpoint**: `/api/customers/{id}`
- **Response**: 無內容
- **HTTP Status**: `204 No Content`

### 錯誤處理（Error Response 範例）

```json
{
    "message": "找不到該客戶。",
    "errors": {
        "id": [
            "此客戶不存在。"
        ]
    }
}
```

- **HTTP Status**:
    - `404 Not Found`（找不到資源）
    - `422 Unprocessable Entity`（資料格式錯誤）
    - `401 Unauthorized` / `403 Forbidden`（未授權或無權限）
