## QA 系統 - 問題 API 規格文件 1.0.0

### 概述

以下是一份「問題（Question）」在 QA 系統中的 CRUD API 規格書。

這些 API 遵循 RESTful 原則設計，可用於建立、讀取、更新與刪除問題資料。

### Base URL

```
/api/questions
```

#### 取得所有問題（List Questions）

- **Method**: `GET`
- **Endpoint**: `/api/questions`
- **Query Parameters**:
    - `page`（可選）: 頁數，預設為 1。
    - `per_page`（可選）: 每頁筆數，預設為 10。
    - `keyword`（可選）: 根據關鍵字搜尋問題標題或內容。
- **Response**:
```json
{
  "data": [
    {
      "id": 1,
      "title": "什麼是 REST API？",
      "content": "我想了解 REST API 的基本概念。",
      "created_at": "2025-04-20T10:00:00Z",
      "updated_at": "2025-04-20T10:00:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 10,
    "total": 100
  }
}
```


#### 取得單一問題（Get Question）

- **Method**: `GET`
- **Endpoint**: `/api/questions/{id}`
- **Response**:
```json
{
  "id": 1,
  "title": "什麼是 REST API？",
  "content": "我想了解 REST API 的基本概念。",
  "created_at": "2025-04-20T10:00:00Z",
  "updated_at": "2025-04-20T10:00:00Z"
}
```


#### 新增問題（Create Question）

- **Method**: `POST`
- **Endpoint**: `/api/questions`
- **Request Body**:
```json
{
  "title": "如何設計一個登入系統？",
  "content": "請問有哪些基本元件與安全性考量？"
}
```
- **Response**:
```json
{
  "id": 101,
  "title": "如何設計一個登入系統？",
  "content": "請問有哪些基本元件與安全性考量？",
  "created_at": "2025-04-20T11:00:00Z",
  "updated_at": "2025-04-20T11:00:00Z"
}
```
- **HTTP Status**: `201 Created`

#### 更新問題（Update Question）: PUT

需包含完整問題內容

- **Method**: `PUT` 或 `PATCH`
- **Endpoint**: `/api/questions/{id}`
- **Request Body**:
```json
{
  "title": "什麼是 RESTful API？",
  "content": "我想更深入了解 RESTful API 的設計方式。"
}
```
- **Response**:
```json
{
  "id": 1,
  "title": "什麼是 RESTful API？",
  "content": "我想更深入了解 RESTful API 的設計方式。",
  "created_at": "2025-04-20T10:00:00Z",
  "updated_at": "2025-04-20T12:00:00Z"
}
```

#### 更新問題（Update Question）: PATCH

允許只輸入部分更新內容，不需包含完整問題

- **Method**:  `PATCH`
- **Endpoint**: `/api/questions/{id}`
- **Request Body**:
```json
{
  "content": "我想更了解 RESTful API 的設計方式。"
}
```
- **Response**:
```json
{
  "id": 1,
  "title": "什麼是 RESTful API？",
  "content": "我想更了解 RESTful API 的設計方式。",
  "created_at": "2025-04-20T10:00:00Z",
  "updated_at": "2025-04-20T12:00:00Z"
}
```

#### 刪除問題（Delete Question）

- **Method**: `DELETE`
- **Endpoint**: `/api/questions/{id}`
- **Response**: 無內容
- **HTTP Status**: `204 No Content`

###  錯誤處理（Error Response 範例）

```json
{
  "message": "找不到該問題。",
  "errors": {
    "id": ["此問題不存在。"]
  }
}
```

- **HTTP Status**:
    - `404 Not Found`（找不到資源）
    - `422 Unprocessable Entity`（資料格式錯誤）
    - `401 Unauthorized` / `403 Forbidden`（未授權或無權限）
