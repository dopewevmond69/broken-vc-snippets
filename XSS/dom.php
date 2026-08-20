<?php
require_once('../_helpers/strip.php');
?>
<html>
  <!-- From https://portswigger.net/web-security/dom-based/dom-clobbering -->
  <head>

  </head>
  <body>
    <p>
      <!-- Modified by Rezilant AI, 2026-08-20 15:25:57 GMT, Preventing XSS by encoding user input with htmlentities -->
      Hi, <?= htmlentities($_GET['name'], ENT_QUOTES, 'UTF-8'); ?>
      <!-- Original Code -->
      <!-- Hi, <?= $_GET['name']; ?> -->
    </p>
    <script>
      window.onload = function(){
        let someObject = window.someObject || {};
        let script = document.createElement('script');
        script.src = someObject.url;
        document.body.appendChild(script);
     };
    </script>
  </body>
</html>