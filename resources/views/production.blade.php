<!-- resources/views/swagger.blade.php -->
<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>EAST API</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5/swagger-ui.css" />
</head>
<body>
<p>此為公開 API, 開放所有人使用，若有使用上的問題可聯絡 <<em><code style="color:red;">r567tw@gmail.com</code></em>></p>
  <div id="swagger-ui"></div>
  <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
  <script>
    const ui = SwaggerUIBundle({
      url: '/production.yaml',
      dom_id: '#swagger-ui',
      deepLinking: true,
      presets: [
        SwaggerUIBundle.presets.apis,
      ],
      // layout 可選值有 "BaseLayout", "StandaloneLayout"
      layout: "BaseLayout",
    })
  </script>
</body>
</html>
