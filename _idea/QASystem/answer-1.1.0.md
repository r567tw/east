## QA 系統 - 答案 API 規格文件 1.1.0

### 概述

基於 [QA 系統 - 答案 API 規格文件 1.0.0](answer-1.0.0.md) 功能

在新增與修改時加上內容檢查

#### 規則

```json
{
  "content": "required|string|min:10|max:65000"
}
```

#### 驗證錯誤回傳格式

驗證錯誤回傳（422 Unprocessable Entity）

```json
{
  "message": "資料驗證失敗",
  "errors": {
    "content": ["內容最少需 10 字"]
  }
}

```
