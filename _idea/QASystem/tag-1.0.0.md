## QA 系統 - 標籤 API 規格文件 1.0.0

### 資源關係
- 一個問題可以有多個標籤（Many-to-Many）
- 標籤應是共用的，同一個名稱的標籤只存在一筆資料

### 標籤 API
Base URL

```
/api/tags
```
#### 取得標籤列表（List Tags）

- **Method**: `GET`
- **Endpoint**: `/api/tags`
- **Response**:
```json
{
  "data": [
    { "id": 1, "name": "Laravel" },
    { "id": 2, "name": "JavaScript" },
    { "id": 3, "name": "資料庫" }
  ]
}
```

#### 新增標籤（Create Tag）

- **Method**: `POST`
- **Endpoint**: `/api/tags`
- **Request 範例**:
```json
{
  "name": "後端"
}
```
- **Response**:
```json
{
  "id": 10,
  "name": "後端"
}
```
- **HTTP Status**: `201 Created`
- 
#### 查看單一標籤（Get Tag）

- **Method**: `GET`
- **Endpoint**: `/api/tags/{id}`
- **Response**:
```json
{
  "id": 1,
  "name": "Laravel"
}
```

#### 刪除標籤（Delete Tag）

- **Method**: `DELETE`
- **Endpoint**: `/api/tags/{id}`
- **注意事項**:
    - 刪除標籤後，應同時從所有關聯的問題中移除該標籤。
- **Response**:
```json
{
  "message": "標籤已刪除"
}
```
- **HTTP Status**: `204 No Content`

### 與問題關聯的 API

#### 取得某問題的所有標籤（List Tags for Question）

- **Method**: `GET`
- **Endpoint**: `/api/questions/{id}/tags`
- **Response**:
```json
{
  "question_id": 1,
  "tags": [
    {
      "id": 10,
      "name": "Laravel"
    },
    {
      "id": 11,
      "name": "API"
    }
  ]
}
```

#### 替問題新增標籤（Attach Tags to Question）

- **Method**: `POST`
- **Endpoint**: `/api/questions/{id}/tags`
- **範例 Request**:
```json
{
  "tags": ["Laravel", "API", "安全性"]
}
```
- **Response**:
```json
{
  "message": "標籤已成功新增",
  "tags": [
    { "id": 10, "name": "Laravel" },
    { "id": 11, "name": "API" },
    { "id": 12, "name": "安全性" }
  ]
}
```
#### 從問題移除某個標籤（Detach Tag from Question）

- **Method**: `DELETE`
- **Endpoint**: `/api/questions/{question_id}/tags/{tag_id}`
- **Response**:
```json
{
  "message": "標籤已移除"
}
```
- **HTTP Status**: `204 No Content`

### 標籤附註說明

- 若標籤名稱尚未存在，則自動建立。
- 同一個問題不能重複附加同一個標籤。
