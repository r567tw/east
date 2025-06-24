## QA 系統 - 答案 API 規格文件 1.0.0

### 資源關係

- 一個問題（Question）可以有多個答案（Answer）
- 答案本身不獨立存在，需有對應問題
- 每個答案由使用者提交，可編輯或刪除

#### 查看問題的所有答案（List Answers for a Question）

- **Method**: `GET`
- **Endpoint**: `/api/questions/{question_id}/answers`
- **Response**:

```json
{
    "question_id": 1,
    "answers": [
        {
            "id": 1001,
            "content": "REST 是一種風格，不是協定，常見於 HTTP。",
            "author": {
                "id": 12,
                "name": "Alice"
            },
            "created_at": "2025-04-20T12:00:00Z",
            "updated_at": "2025-04-20T12:00:00Z"
        },
        {
            "id": 1002,
            "content": "REST 是一種規範，常見於 API 設計。",
            "author": {
                "id": 15,
                "name": "Bob"
            },
            "created_at": "2025-04-21T12:00:00Z",
            "updated_at": "2025-04-21T12:00:00Z"
        }
    ]
}
```

#### 新增答案（Create Answer）

- **Method**: `POST`
- **Endpoint**: `/api/questions/{question_id}/answers`
- **Request 範例**:

```json
{
    "content": "您可以使用 Laravel 的 Passport 套件來建立 OAuth 認證流程。"
}
```

- **Response**:

```json
{
    "id": 1003,
    "question_id": 1,
    "content": "您可以使用 Laravel 的 Passport 套件來建立 OAuth 認證流程。",
    "author": {
        "id": 15,
        "name": "Bob"
    },
    "created_at": "2025-04-21T13:00:00Z",
    "updated_at": "2025-04-21T13:00:00Z"
}
```

- **HTTP Status**: `201 Created`

#### 查看單一答案（Get Answer）

- **Method**: `GET`
- **Endpoint**: `/api/answers/{answer_id}`
- **Response**:

```json
{
    "id": 1003,
    "question_id": 1,
    "content": "您可以使用 Laravel 的 Passport 套件來建立 OAuth 認證流程。",
    "author": {
        "id": 15,
        "name": "Bob"
    },
    "created_at": "2025-04-21T13:00:00Z",
    "updated_at": "2025-04-21T13:00:00Z"
}
```

#### 修改答案（Update Answer）: PUT & PATCH

這邊 `PUT` 或 `PATCH` 行為一致

- **Method**: `PUT` 或 `PATCH`
- **Endpoint**: `/api/answers/{answer_id}`

- **Request 範例**:

```json
{
    "content": "建議使用 Sanctum 來處理前後端分離的 token 驗證。"
}
```

- **Response**:

```json
{
    "id": 1002,
    "question_id": 1,
    "content": "建議使用 Sanctum 來處理前後端分離的 token 驗證。",
    "updated_at": "2025-04-20T14:00:00Z"
}
```

#### 刪除答案（Delete Answer）

- **Method**: `DELETE`
- **Endpoint**: `/api/answers/{answer_id}`
- **Response**:
    - 成功時無回傳內容
- **HTTP Status**: `204 No Content`

###  錯誤處理（Error Response 範例）

```json
{
  "message": "找不到該答案。",
  "errors": {
    "id": ["此答案不存在。"]
  }
}
```

- **HTTP Status**:
    - `404 Not Found`（找不到資源）
    - `422 Unprocessable Entity`（資料格式錯誤）
    - `401 Unauthorized` / `403 Forbidden`（未授權或無權限）
