<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Inwos</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/chat.css">
  <link rel="shortcut icon" href="/storage/images/inwos/icon.ico">
</head>

<body>
  <section class="msger">
    <header class="msger-header">
      <div class="msger-header-title">
        <em class="fas fa-comment-alt"></em>
        <span class="chatWith"></span>
      </div>
    </header>

    <div class="msger-chat"></div>

    <form class="msger-inputarea">
      <input type="text" class="msger-input" placeholder="Enter your message...">
      <button type="submit" class="msger-send-btn">Send</button>
    </form>

  </section>

  <script src='https://use.fontawesome.com/releases/v5.0.13/js/all.js'></script>
  <script src="/js/app.js"></script>
  <script src="/js/chat.js"></script>

</body>

</html>
