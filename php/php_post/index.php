<?php
  $methods = [
    "POST",
    "GET",
    "PUT",
    "DELETE",
    "PATCH",
    "HEAD",
    "OPTIONS",
    "TRACE",
    "CONNECT",
  ];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Metas -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>PHP Post</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="lib/bootstrap/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/php_post.css">
  </head>
  <body>
    <div class="container">
      <div class="jumbotron">
        <h1 class="display-4">Welcome to PHP Post</h1>
        <p class="lead">
          Using PHP Post you can make web requests using JQuery AJAX method.
        </p>
      </div>
      <div class="jumbotron">
        <h1>Make Request:</h1>
        <p class="lead">
          Make a new request in following:
        </p>
        <form class="row my-5">
          <div class="form-group col-md-6">
            <label for="method">Method</label>
            <select class="form-control" name="method" id="method" required>
              <?php
                foreach($methods as $method){
                  ?>
                    <option value="<?=$method?>"><?=$method?></option>
                  <?php
                }
              ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="url">URL</label>
            <input class="form-control" type="text" name="url" id="url" placeholder="https://example.com/api/v1/reports" required>
          </div>
          <div class="form-group col-12">
            <label for="data">Data</label>
            <textarea name="data" id="data" placeholder="name=Test&amp;limit=2" class="form-control" style='height: 100px; resize: vertical;'></textarea>
          </div>
          <div class="col-12 text-right">
            <button class="btn btn-success" id="send-request">Send Request</button>
          </div>
          <div class="col-12">
            <code class="form-control p-4 mt-4" style="height: auto;" id="response-output"><span class="text-muted">Response Output</span></code>
          </div>
          <div class="col-12">
            <code class="form-control p-4 mt-4" style="height: auto;" id="response-raw"><span class="text-muted">Raw Response</span></code>
          </div>
          <div class="col-12 text-right my-4">
            <button type="button" class="btn btn-secondary" id="clear-button">Clear Response</button>
          </div>
        </form>
      </div>
      <div class="jumbotron">
        <h1 class="display-4">Cross-Orign Error ?</h1>
        <p class="lead">
          To disable CORS, close all chrome process(es) and start it with CLI command:
          
          <table class="table table-bordered table-hover table-dark">
            <tr>
              <th>OS</th>
              <th>Command</th>
            </tr>
            <tr>
              <td>Windows</td>
              <td><code>"[PATH_TO_CHROME]\chrome.exe" --disable-web-security --disable-gpu --user-data-dir=~/chromeTemp</code></td>
            </tr>
            <tr>
              <td>Linux</td>
              <td><code>google-chrome --disable-web-security</code></td>
            </tr>
            <tr>
              <td>OSX</td>
              <td><code>open -n -a /Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --args --user-data-dir="/tmp/chrome_dev_test" --disable-web-security</code></td>
            </tr>
          </table>

          <br>

          <p class="text-right lead">
            Even not solved yet ? kindly add <code>Access-Control-Allow-Origin</code> header.
            <br>
            You can also try using this script on same server (if it is PHP-Back-End).
            <br>
            <br>
            After above steps, Do not have a PHP server ? I am useless for you. <code>rm -rf</code> me.
          </p>
        </p>
      </div>
    </div>
    <!-- JQuery -->
    <script src="lib/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="lib/bootstrap/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/php_post.js"></script>
  </body>
</html>