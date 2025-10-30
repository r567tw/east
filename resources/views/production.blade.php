<!-- resources/views/swagger.blade.php -->
<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>EAST API</title>
  <script type="module" src="https://unpkg.com/rapidoc/dist/rapidoc-min.js"></script>
</head>
<body>
<rapi-doc
    spec-url="/swagger-production.yaml"
    allow-server-selection="false"
    layout="column"
    default-schema-tab="model"
    schema-description-expanded="true"
></rapi-doc>
<p>此為公開 API, 開放所有人使用，若有使用上的問題可聯絡 &lt;<em><code style="color:red; text-decoration:underline;"><a style="color:red; text-decoration:underline;" href="mailto:r567tw@gmail.com">r567tw@gmail.com</a></code></em>&gt;</p>
</body>
</html>
