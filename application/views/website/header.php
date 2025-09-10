<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= $aplikasi['title_aplikasi']; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/aplikasi/' . $aplikasi['favicon']); ?>">
	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content="" />
	<meta property="og:image" content="" />
	<meta property="og:url" content="" />
	<meta property="og:site_name" content="" />
	<meta property="og:description" content="" />
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,700" rel="stylesheet">
	<!-- Animate.css -->
	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>css/magnific-popup.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/all.css">
	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>css/owl.theme.default.min.css">
	<!-- Flexslider  -->
	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>css/flexslider.css">
	<!-- Flaticons  -->
	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>fonts/flaticon/font/flaticon.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>css/style.css">

	<link rel="stylesheet" href="<?= base_url('assets/lawmaker/') ?>wa/floating-wpp.min.css">

	<!-- Modernizr JS -->
	<script src="<?= base_url('assets/lawmaker/') ?>js/modernizr-2.6.2.min.js"></script>
	<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: white;
            flex-direction: column;
            text-align: center;
        }
        h1 {
            color: black;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .panic-button {
            background: linear-gradient(135deg, #ff4d4d, #ff0000);
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 20px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            width: 160px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            text-transform: uppercase;
            text-decoration: none;
        }
        .panic-button:hover {
            background: linear-gradient(135deg, #ff6666, #cc0000);
            transform: scale(1.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        .panic-button:active {
            background: linear-gradient(135deg, #cc0000, #990000);
            transform: scale(0.9);
        }
        .panic-button:visited, .panic-button:focus {
            color: white;
        }
        .tap-text {
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }
        @media (max-width: 600px) {
            .panic-button {
                font-size: 14px;
                width: 130px;
                height: 130px;
            }
        }
	</style>
</head>

<body>
