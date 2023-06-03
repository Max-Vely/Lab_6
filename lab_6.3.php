<!DOCTYPE html>
<html>
  <head>
    <title>Мій веб-сайт</title>
    <style>
      .header {
        text-align: center;
      }

      .sidebar {
        float: left;
        width: 20%;
      }

      .content {
        margin-left: 20%;
      }

      .footer {
        text-align: center;
      }

      /* Стилі для заголовків */
      h1 {
        color: blue;
        font-size: 24px;
      }

      h2 {
        color: green;
        font-size: 18px;
      }

      /* Стилі для навігаційного бокового меню */
      .sidebar {
        background-color: lightgray;
        padding: 10px;
      }

      .sidebar h2 {
        font-size: 16px;
      }

      .sidebar ul {
        list-style-type: none;
        padding: 0;
        display: flex;
        justify-content: space-around;
      }

      .sidebar li {
        margin-bottom: 5px;
      }

      .sidebar a {
        text-decoration: none;
        color: black;
        display: block;
        padding: 5px;
        background-color: lightgray;
        transition: background-color 0.3s;
      }

      .sidebar a:hover {
        background-color: gray;
      }

      /* Стилі для змісту */
      .content {
        padding: 10px;
      }

      /* Стилі для таблиці */
      table {
        width: 100%;
        border-collapse: collapse;
      }

      th, td {
        padding: 5px;
        text-align: left;
      }

      th {
        background-color: lightgray;
      }

      /* Стилі для підвалу */
      .footer {
        background-color: lightgray;
        padding: 10px;
        font-size: 12px;
      }

      /* Стилі для відгуків */
      .reviews {
        margin-top: 20px;
      }

      .reviews p {
        margin-bottom: 10px;
      }

      /* Стилі для форми */
      .review-form {
        margin-top: 20px;
      }

      .review-form label {
        display: block;
        margin-bottom: 5px;
      }

      .review-form textarea {
        width: 100%;
        height: 100px;
      }

      .review-form input[type="submit"] {
        margin-top: 10px;
      }

      .review-form .error {
        color: red;
      }
    </style>
  </head>
  <body>
    <div class="header">
      <img src="" alt="Логотип Мого Веб-сайту">
      <h1>Мій веб-сайт</h1>
    </div>
    
    <div class="sidebar">
      <h2>Навігація</h2>
      <ul>
        <li><a href="#list" onclick="toggleList()">Список</a></li>
        <li><a href="#table">Таблиця</a></li>
        <li><a href="#video">Відео</a></li>
        <li><a href="#reviews">Відгуки</a></li>
      </ul>
    </div>

    <div class="content">
      <h2 id="list">Список:</h2>
      <ul id="listItems" style="display: none;">
        <li>Елемент 1</li>
        <li>Елемент 2</li>
        <li>Елемент 3</li>
      </ul>

      <h2 id="table">Таблиця:</h2>
      <table border="1">
        <tr>
          <td>Назва</td>
          <td>Ціна</td>
        </tr>
        <tr>
          <td>Продукт 1</td>
          <td>10$</td>
        </tr>
        <tr>
          <td>Продукт 2</td>
          <td>20$</td>
        </tr>
      </table>

      <h2 id="video">Відео:</h2>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/lh9jfXcrN_g" title="YouTube video" frameborder="0" allowfullscreen></iframe>

      <h2 id="reviews">Відгуки:</h2>
      <div class="reviews">
        <?php
          // Підключення до бази даних
          $conn = new PDO('sqlite:reviews.db');
          // Створення таблиці відгуків, якщо вона ще не існує
          $conn->exec("CREATE TABLE IF NOT EXISTS reviews (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, comment TEXT)");

          // Обробка форми відгука
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $comment = $_POST['comment'];

            // Валідація форми
            $errors = [];
            if (empty($name)) {
              $errors[] = "Ім'я є обов'язковим полем";
            }
            if (empty($comment)) {
              $errors[] = "Відгук є обов'язковим полем";
            }

            // Якщо форма не містить помилок, збереження відгука в базі даних
            if (empty($errors)) {
              $stmt = $conn->prepare("INSERT INTO reviews (name, comment) VALUES (:name, :comment)");
              $stmt->bindParam(':name', $name);
              $stmt->bindParam(':comment', $comment);
              $stmt->execute();
            }
          }

          // Вибірка всіх відгуків з бази даних
          $stmt = $conn->query("SELECT * FROM reviews");
          $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Виведення відгуків
          foreach ($reviews as $review) {
            echo "<p><strong>{$review['name']}:</strong> {$review['comment']}</p>";
          }

          // Закриття з'єднання з базою даних
          $conn = null;
        ?>
      </div>

      <h2>Додати відгук:</h2>
      <div class="review-form">
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($errors)): ?>
          <div class="error">
            <?php foreach ($errors as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <form method="POST" action="#">
          <label for="name">Ім'я:</label>
          <input type="text" id="name" name="name">
          <label for="comment">Відгук:</label>
          <textarea id="comment" name="comment"></textarea>
          <input type="submit" value="Відправити">
        </form>
      </div>
    </div>
    
    <div class="footer">
      <p>© 2023 Мій веб-сайт. Усі права захищені.</p>
    </div>

    <script>
      // JavaScript код для переключення списку
      function toggleList() {
        var list = document.getElementById('listItems');
        if (list.style.display === 'none') {
          list.style.display = 'block';
        } else {
          list.style.display = 'none';
        }
      }
    </script>
  </body>
</html>
