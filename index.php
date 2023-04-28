<?php
spl_autoload_register(function ($class){
	require_once realpath(__DIR__) . DIRECTORY_SEPARATOR . $class . '.php';
});
use classes\CProducts;
$page = new CProducts;
?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Products</title>
<meta name="description" content="Таблица Products">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="/css/page.css" rel="stylesheet">
</head>
<body>
<div class="page">
<section class="container-lg">
	<h1 class="text-center my-3">Таблица Products</h1>
<?php if(!$page->error): ?>
	<?php if($page->dataProducts): ?>
	<div class="page-error alert alert-danger" role="alert"></div>
	<div class="table-responsive-lg mb-3">
		<table class="table table-hover">
			<thead class="table-dark">
				<tr>
					<th scope="col">ID-продукта</th>
					<th scope="col">Название</th>
					<th scope="col">Артикул</th>
					<th scope="col">Цена (руб.)</th>
					<th scope="col">Количество</th>
					<th scope="col">Дата создания</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($page->dataProducts as $value): ?>
				<tr class="align-middle">
					<th scope="row"><?= $value['product_id'] ?></th>
					<td><?= $value['product_name'] ?></td>
					<td><?= $value['product_article'] ?></td>
					<td><?= $value['product_price'] ?></td>
					<td>
						<div class="d-flex justify-content-between align-items-center">
							<div class="me-2"><?= $value['product_quantity'] ?></div>
							<div id="<?= $value['product_id'] ?>" class="d-flex buttons-group">
								<button data-set="plus" type="button" class="btn btn-success me-2" title="Увеличить">+</button>
								<button data-set="minus" type="button" class="btn btn-danger" title="Уменьшить">-</button>
							</div>
						</div>
					</td>
					<td><?= date('d.m.Y', strtotime($value['date_create'])) ?></td>
					<td><button data-product="<?= $value['product_id'] ?>" type="button" class="btn btn-primary hide-product" title="Скрыть продукт">Скрыть</button></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php if(count($page->pagination) > 1): ?>
	<nav>
		<ul class="pagination justify-content-center">
		<?php if($page->currentPage > 1): ?>
			<li class="page-item"><a class="page-link" href="?page=1"><span aria-hidden="true">&laquo;</span></a></li>
		<?php endif; ?>
		<?php foreach($page->pagination as $value): ?>
			<li class="page-item<?= $page->currentPage == $value ? ' active' : null ?>"><?= $page->currentPage == $value ? '<span class="page-link">' . $value . '</span>' : '<a class="page-link" href="?page=' . $value . '">' . $value . '</a>' ?></li>
		<?php endforeach; ?>
		<?php if($page->currentPage < $page->allPages): ?>	
			<li class="page-item"><a class="page-link" href="?page=<?= $page->allPages ?>"><span aria-hidden="true">&raquo;</span></a></li>
		<?php endif; ?>
		</ul>
	</nav>
	<?php endif; ?>
	<?php else: ?>
	<div class="text-center mb-3">Таблица Products пуста</div>
	<?php endif; ?>
<?php else: ?>
	<div class="alert alert-danger text-center mb-3" role="alert"><?= $page->error ?></div>
<?php endif; ?>
</section>
</div>
<?php if(!$page->error): ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="/js/script.js"></script>
<?php endif; ?>
</body>
</html>