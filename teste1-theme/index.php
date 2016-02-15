<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Teste 1</title>

	<link href="<?php bloginfo('template_directory');?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php bloginfo('template_directory');?>/css/style.css" rel="stylesheet">
</head>
<body> 

	<nav class="navbar navbar-dark navbar-fixed-top bg-inverse">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Controle de Estoque</a>
			</div>
			<ul class="nav navbar-nav pull-xs-right">
				<li class="nav-item active">
					<a class="nav-link" href="#">Produtos <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Clientes</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Pedidos</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">About</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="jumbotron">
		<div class="container">

		<?php if (isset($_GET['prod']) && $_GET['prod'] == "add") { ?>
		
	        <form class="col-xs-12">
				<fieldset class="form-group col-xs-6">
					<label for="produto">Nome do Produto</label>
					<input type="text" class="form-control" id="produto">
				</fieldset>
				<fieldset class="form-group col-xs-3">
					<label for="desc">Preço</label>
					<div class="input-group">
						<div class="input-group-addon">R$</div>
						<input type="number" class="form-control" id="price" placeholder="Amount">
						<div class="input-group-addon">.00</div>
					</div>
				</fieldset>  
				<fieldset class="form-group col-xs-12">
					<label for="desc">Descrição</label>
					<textarea rows="5" class="form-control" id="desc"></textarea>
				</fieldset>
			</form>

		<?php } else { ?>

			<h1>Olá, seja bem vindo!</h1>
			<p class="lead">Este é um template inicial para controle de estoque. Aqui você encontrará tabelas de Produtos, Clientes e Pedidos estruturados com PHP e Wordpress. Use-o como ponto de partida para criar algo único.</p>

		<?php } ?>
		</div>
	</div>

	<div id="main" class="container">
		
		<h4 class="page-header col-md-11">Produtos</h4>
		<a class="btn btn-primary-outline btn-sm add-button" href="http://altran.thaeds.com/wp-admin/post-new.php?post_type=produto" role="button">Adicionar</a>

		<div id="list" class="row">
			<div class="table-responsive col-md-12">
				<table class="table table-striped table-bordered" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
					<th>Id</th>
					<th>Nome</th>
					<th>Descrição</th>
					<th>Preço</th>
					<th class="actions">Ações</th>
					</tr>
				</thead>
				<tbody>

				<?php 
				$args = array( 'post_type' => 'produto', 'posts_per_page' => 9999 );
				$the_query = new WP_Query( $args ); 
				if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	
					<tr>
						<td><?php echo the_ID(); ?></td>
						<td><?php the_title(); ?></td>
						<td><?php echo get_post_meta( get_the_ID(), 'desc', true ); ?></td>
						<td>R$ <?php echo get_post_meta( get_the_ID(), 'price', true ); ?></td>
						<td class="actions">
						    <a class="btn btn-success btn-sm" href="<?php echo get_edit_post_link( $id, $context ); ?>">Visualizar</a>
						    <a class="btn btn-warning btn-sm" href="<?php echo get_edit_post_link( $id, $context ); ?>">Editar</a>
						    <a class="btn btn-danger btn-sm"  href="<?php echo get_delete_post_link( $id, $deprecated, $force_delete ); ?> " data-toggle="modal" data-target="#delete-modal">Excluir</a>
						</td>
					</tr>

				<?php wp_reset_postdata(); endwhile; endif; ?>

				</tbody>
			</table>
			</div>
		</div>

		<br>
		<h4 class="page-header col-md-11">Clientes</h4>
		<a class="btn btn-primary-outline btn-sm add-button" href="http://altran.thaeds.com/wp-admin/post-new.php?post_type=cliente" role="button">Adicionar</a>

		<div id="list" class="row">
			<div class="table-responsive col-md-12">
				<table class="table table-striped table-bordered" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
					<th>Id</th>
					<th>Nome</th>
					<th>Email</th>
					<th>Telefone</th>
					<th class="actions">Ações</th>
					</tr>
				</thead>
				<tbody>

				<?php 
				$args = array( 'post_type' => 'cliente', 'posts_per_page' => 9999 );
				$the_query = new WP_Query( $args ); 
				if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	
					<tr>
						<td><?php echo the_ID(); ?></td>
						<td><?php the_title(); ?></td>
						<td><?php echo get_post_meta( get_the_ID(), 'email', true ); ?></td>
						<td>R$ <?php echo get_post_meta( get_the_ID(), 'tel', true ); ?></td>
						<td class="actions">
						    <a class="btn btn-success btn-sm" href="<?php echo get_edit_post_link( $id, $context ); ?>">Visualizar</a>
						    <a class="btn btn-warning btn-sm" href="<?php echo get_edit_post_link( $id, $context ); ?>">Editar</a>
						    <a class="btn btn-danger btn-sm"  href="<?php echo get_delete_post_link( $id, $deprecated, $force_delete ); ?> " data-toggle="modal" data-target="#delete-modal">Excluir</a>
						</td>
					</tr>

				<?php wp_reset_postdata(); endwhile; endif; ?>

				</tbody>
			</table>
			</div>
		</div>

		<br>
		<h4 class="page-header col-md-11">Pedidos</h4>
		<a class="btn btn-primary-outline btn-sm add-button" href="http://altran.thaeds.com/wp-admin/post-new.php?post_type=pedido" role="button">Adicionar</a>


		<div id="list" class="row">
			<div class="table-responsive col-md-12">
				<table class="table table-striped table-bordered" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
					<th>Id</th>
					<th>Produto</th>
					<th>Cliente</th>
					<th class="actions">Ações</th>
					</tr>
				</thead>
				<tbody>

				<?php 
				$args = array( 'post_type' => 'pedido', 'posts_per_page' => 9999 );
				$the_query = new WP_Query( $args ); 
				if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	
					<tr>
						<td><?php echo the_ID(); ?></td>
						<td><?php echo get_post_meta( get_the_ID(), 'prod', true ); ?></td>
						<td><?php echo get_post_meta( get_the_ID(), 'cli', true ); ?></td>
						<td class="actions">
						    <a class="btn btn-success btn-sm" href="<?php echo get_edit_post_link( $id, $context ); ?>">Visualizar</a>
						    <a class="btn btn-warning btn-sm" href="<?php echo get_edit_post_link( $id, $context ); ?>">Editar</a>
						    <a class="btn btn-danger btn-sm"  href="<?php echo get_delete_post_link( $id, $deprecated, $force_delete ); ?> " data-toggle="modal" data-target="#delete-modal">Excluir</a>
						</td>
					</tr>

				<?php wp_reset_postdata(); endwhile; endif; ?>

				</tbody>
			</table>
			</div>
		</div>
 
	</div>

	<script src="<?php bloginfo('template_directory');?>/js/jquery.min.js"></script>
	<script src="<?php bloginfo('template_directory');?>/js/bootstrap.min.js"></script>
</body>
</html>