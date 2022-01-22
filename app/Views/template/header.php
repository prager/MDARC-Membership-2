<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- Option 1: Include in HTML -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="/img/mdarc-icon.ico" type="image/x-icon">
  <title>MDARC Membership - Dev</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light navbar-light py-2 fixed-top">
  <div class="container">
      <a href="<?php echo base_url(); ?>" class="navbar-brand">MDARC Members Portal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                  <a href="<?php echo base_url(); ?>" class="nav-link">Home</a>
              </li>
              <li class="nav-item">
                  <a href="<?php echo base_url() . '/index.php/contact'; ?>" class="nav-link">Contact</a>
              </li>
              <li class="nav-item">
                  <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#tech">About</a>
              </li>
              <li class="nav-item">
                  <a href="#"  data-bs-toggle="modal" data-bs-target="#login" class="nav-link"> Login <i class="bi bi-person"></i></a>
              </li>
          </ul>
      </div>
  </div>
</nav>
