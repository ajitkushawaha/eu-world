<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $error_title; ?></title>

	<style>
	div.logo {
		height: 200px;
		width: 155px;
		display: inline-block;
		opacity: 0.08;
		position: absolute;
		top: 2rem;
		left: 50%;
		margin-left: -73px;
	}
	body {
		height: 100%;
		background: #fafafa;
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		color: #777;
		font-weight: 300;
	}
	h1 {
		font-weight: lighter;
		letter-spacing: 0.8;
		font-size: 3rem;
		margin-top: 0;
		margin-bottom: 0;
		color: #222;
	}
	.wrap {
		max-width: 1024px;
		margin: 5rem auto;
		padding: 2rem;
		background: #fff;
		text-align: center;
		border: 1px solid #efefef;
		border-radius: 0.5rem;
		position: relative;
	}
	pre {
		white-space: normal;
		margin-top: 1.5rem;
	}
	code {
		background: #fafafa;
		border: 1px solid #efefef;
		padding: 0.5rem 1rem;
		border-radius: 5px;
		display: block;
	}
	p {
		margin-top: 1.5rem;
	}
	.footer {
		margin-top: 2rem;
		border-top: 1px solid #efefef;
		padding: 1em 2em 0 2em;
		font-size: 85%;
		color: #999;
	}
	a:active,
	a:link,
	a:visited {
		color: #dd4814;
	}
</style>
</head>
<body>
	<div class="wrap">
		<h1><b> <?php if (! empty($error_title) && $error_title !== '(null)') : ?>
			<?= esc($error_code) ?> - <?= esc($error_title) ?>
			<?php else : ?>
				Sorry! Cannot seem to find the page you were looking for.
			<?php endif ?></b> </h1>

			<h3><?php if (! empty($error_message) && $error_message !== '(null)') : ?>
				<?= esc($error_message) ?>
			<?php else : ?>
				Sorry! Cannot seem to find the page you were looking for.
			<?php endif ?></h3>



		
	</div>
</body>
</html>