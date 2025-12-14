<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Game Store</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4; /* Abu sangat muda */
            color: #333;
        }
        .navbar {
            background-color: #ffffff !important; /* Putih */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: #333 !important;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #555; /* Abu gelap */
            border-color: #444;
        }
        .btn-primary:hover {
            background-color: #333;
        }
        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            background-color: #fff;
        }
        .jumbotron {
            background-color: #e9ecef;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>