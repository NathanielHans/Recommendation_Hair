<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cover Section Fullscreen</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
    }

    .cover {
      height: 100vh; /* 100% dari tinggi layar */
      background: url('https://source.unsplash.com/1600x900/?nature') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
      font-family: Arial, sans-serif;
    }

    .cover h1 {
      font-size: 3rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .cover p {
      font-size: 1.2rem;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <section class="cover">
    <div>
      <h1>Selamat Datang di Website Kami</h1>
      <p>Temukan berbagai informasi menarik di sini.</p>
    </div>
  </section>

</body>
</html>
