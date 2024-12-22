<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>
<style>
	.page-link{
		background-color: white;
		box-shadow: 0px 3px 6px #00000029;
		margin: 5px;
		border-radius: 10px;
		color:black;
	}
	.page-link:hover{
		color:white;
		background-color: #006DBC;
	}
	.active{
		color:white;
		background-color: #006DBC;
	}
	.page-link.active{
		color:white;
		background-color: #006DBC;
	}
</style>
<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
	<ul class="pagination">
		<?php if ($pager->hasPrevious()) : ?>
			<li class="page-item">
				<a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
					<span aria-hidden="true"><?= '<i class="fa-solid fa-angles-left"></i>' ?></span>
				</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
					<span aria-hidden="true"><?= '<i class="fa-solid fa-chevron-left"></i>' ?></span>
				</a>
			</li>
		<?php endif ?>

		<?php foreach ($pager->links() as $link) : ?>
			<li class="page-item">
				<a class="page-link  <?= $link['active'] ? 'active' : '' ?>"  href="<?= $link['uri'] ?>">
					<?= $link['title'] ?>
				</a>
			</li>
		<?php endforeach ?>

		<?php if ($pager->hasNext()) : ?>
			<li class="page-item">
				<a class="page-link" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
					<span aria-hidden="true"><?= '<i class="fa-solid fa-chevron-right"></i>' ?></span>
				</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
					<span aria-hidden="true"><?= '<i class="fa-solid fa-angles-right"></i>' ?></span>
				</a>
			</li>
		<?php endif ?>
	</ul>
</nav>
