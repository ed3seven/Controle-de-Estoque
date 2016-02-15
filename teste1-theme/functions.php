<?php


// CRIA POST TYPE P/ PRODUTO

add_action( 'init', 'create_post_type_produto' );
function create_post_type_produto() {
	register_post_type( 'produto',
		array(
			'labels' => array(
				'name' => __('Produtos'),
				'singular_name' => __('Produto'),
				'add_new' => __('Adicionar Novo'),
				'add_new_item' => __('Adicionar Novo Produto'),
				'edit_item' => __('Editar Produto'),
				'new_item' => __('Novo Produto'),
				'all_items' => __('Todos os Produtos'),
				'view_item' => __('Visualizar Produto'),
				'search_items' => __('Procurar Produto'),
				'not_found' =>  __('Nenhum Produto Encontrado'),
				'not_found_in_trash' => __('Nenhum Produto Encontrado no Lixo'),
				'parent_item_colon' => '',
				'menu_name' => 'Produtos'
				),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title'),
		)
	);
}


// CUSTOM FIELDS PERSONALIZADOS EM META BOX
// ID = GERADO AUTOMATICAMENTE PELO WORDPRESS
// TITLE = NOME DO PRODUTO
// DESC = BREVE DESCRIÇÃO DO PRODUTO
// PRICE = PREÇO DO PRODUTO

function product_meta_add() {
	add_meta_box( 'product_id', 'Id', 'product_id_box', 'produto', 'normal', 'high' );
	add_meta_box( 'product_desc', 'Descrição', 'product_desc_box', 'produto', 'normal', 'high' );
	add_meta_box( 'product_price', 'Preço', 'product_price_box', 'produto', 'normal', 'high' );
}
function product_id_box() {
	?><p>Gerado automaticamente pelo sistema.</p><?php  
}
function product_desc_box() {
	$values = get_post_custom( $post->ID );
	$text = isset( $values['desc'] ) ? esc_attr( $values['desc'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
		<textarea name="desc" id="excerpt"><?php echo $text; ?></textarea>
	<?php  
}
function product_price_box() {
	$values = get_post_custom( $post->ID );
	$text = isset( $values['price'] ) ? esc_attr( $values['price'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
		<p>Insira o valor do produto R$ <input type="number" style="width: 85px;" max="99999" name="price" id="price" value="<?php echo $text; ?>" /> (utilize ponto ou vírgula para definir as casas decimais)</p>
	<?php  
}


// VERIFICA E SALVA CONTEÚDOS INSERIDOS NO META BOX

function product_meta_save( $post_id ) {
 	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'meta_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'meta_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
	if( isset( $_POST[ 'desc' ] ) ) {
		update_post_meta( $post_id, 'desc', sanitize_text_field( $_POST[ 'desc' ] ) );
	}
	if( isset( $_POST[ 'price' ] ) ) {
		update_post_meta( $post_id, 'price', sanitize_text_field( $_POST[ 'price' ] ) );
	}
}


// ADICIONA E PERSONALIZA COLUNAS NA TELA DE LISTAGEM

function desc_columns_head($defaults) {
    $defaults['desc'] = 'Descrição';
    $defaults['price'] = 'Preço';
    unset($defaults['date']);
    return $defaults;
} 
function desc_columns_content($column_name, $post_ID) {
    if ($column_name == 'desc') {
        echo get_post_meta( get_the_ID(), 'desc', true );
    }
    if ($column_name == 'price') {
        echo "R$ " . get_post_meta( get_the_ID(), 'price', true );
    }
}


// ADICIONA AS FUNÇÕES NO WORDPRESS

add_action( 'add_meta_boxes', 'product_meta_add' );
add_action( 'save_post', 'product_meta_save' );
add_filter('manage_produto_posts_columns', 'desc_columns_head');
add_action('manage_produto_posts_custom_column', 'desc_columns_content', 10, 2);










// CRIA POST TYPE P/ CLIENTE

add_action( 'init', 'create_post_type_cliente' );
function create_post_type_cliente() {
	register_post_type( 'cliente',
		array(
			'labels' => array(
				'name' => __('Cliente'),
				'singular_name' => __('Cliente'),
				'add_new' => __('Adicionar Novo'),
				'add_new_item' => __('Adicionar Novo Cliente'),
				'edit_item' => __('Editar Cliente'),
				'new_item' => __('Novo Cliente'),
				'all_items' => __('Todos os Clientes'),
				'view_item' => __('Visualizar Cliente'),
				'search_items' => __('Procurar Cliente'),
				'not_found' =>  __('Nenhum Cliente Encontrado'),
				'not_found_in_trash' => __('Nenhum Cliente Encontrado no Lixo'),
				'parent_item_colon' => '',
				'menu_name' => 'Clientes'
				),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title'),
		)
	);
}


// CUSTOM FIELDS PERSONALIZADOS EM META BOX
// ID = GERADO AUTOMATICAMENTE PELO WORDPRESS
// TITLE = NOME DO CLIENTE
// EMAIL = EMAIL DO CLIENTE
// TEL = TELEFONE DO CLIENTE

function cliente_meta_add() {
	add_meta_box( 'cliente_id', 'Id', 'cliente_id_box', 'cliente', 'normal', 'high' );
	add_meta_box( 'cliente_desc', 'Email', 'cliente_email_box', 'cliente', 'normal', 'high' );
	add_meta_box( 'cliente_tel', 'Telefone', 'cliente_tel_box', 'cliente', 'normal', 'high' );
}
function cliente_id_box() {
	?><p>Gerado automaticamente pelo sistema.</p><?php  
}
function cliente_email_box() {
	$values = get_post_custom( $post->ID );
	$text = isset( $values['email'] ) ? esc_attr( $values['email'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
		<p>Insira o email do cliente <input type="email" style="width: 200px;" name="email" id="email" value="<?php echo $text; ?>" /> Ex: something@gmail.com</p>
	<?php  
}
function cliente_tel_box() {
	$values = get_post_custom( $post->ID );
	$text = isset( $values['tel'] ) ? esc_attr( $values['tel'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
		<p>Insira o DDD e o número de teleone <input type="tel" style="width: 200px;" name="tel" id="tel" value="<?php echo $text; ?>" /> Ex: 11 958658825</p>
	<?php  
}


// VERIFICA E SALVA CONTEÚDOS INSERIDOS NO META BOX

function cliente_meta_save( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'meta_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'meta_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
 	if( isset( $_POST[ 'email' ] ) ) {
		update_post_meta( $post_id, 'email', sanitize_text_field( $_POST[ 'email' ] ) );
	}
	if( isset( $_POST[ 'tel' ] ) ) {
		update_post_meta( $post_id, 'tel', sanitize_text_field( $_POST[ 'tel' ] ) );
	}
}


// ADICIONAR E PERSONALIZAR COLUNAS NA TELA DE LISTAGEM

function clientes_columns_head($defaults) {
    $defaults['email'] = 'Email';
    $defaults['tel'] = 'Telefone';
    unset($defaults['date']);
    return $defaults;
} 
function clientes_columns_content($column_name, $post_ID) {
    if ($column_name == 'email') {
        echo get_post_meta( get_the_ID(), 'email', true );
    }
    if ($column_name == 'tel') {
        echo get_post_meta( get_the_ID(), 'tel', true );
    }
}


// ADICIONA AS FUNÇÕES NO WORDPRESS

add_action( 'add_meta_boxes', 'cliente_meta_add' );
add_action( 'save_post', 'cliente_meta_save' );
add_filter('manage_cliente_posts_columns', 'clientes_columns_head');
add_action('manage_cliente_posts_custom_column', 'clientes_columns_content', 10, 2);










// CRIA POST TYPE P/ PEDIDO

add_action( 'init', 'create_post_type_pedido' );
function create_post_type_pedido() {
	register_post_type( 'pedido',
		array(
			'labels' => array(
				'name' => __('Pedido'),
				'singular_name' => __('Pedido'),
				'add_new' => __('Adicionar Novo'),
				'add_new_item' => __('Adicionar Novo Pedido'),
				'edit_item' => __('Editar Pedido'),
				'new_item' => __('Novo Pedido'),
				'all_items' => __('Todos os Pedidos'),
				'view_item' => __('Visualizar Pedido'),
				'search_items' => __('Procurar Pedido'),
				'not_found' =>  __('Nenhum Pedido Encontrado'),
				'not_found_in_trash' => __('Nenhum Pedido Encontrado no Lixo'),
				'parent_item_colon' => '',
				'menu_name' => 'Pedidos'
				),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('false'),
		)
	);
}


// CUSTOM FIELDS PERSONALIZADOS EM META BOX
// ID = GERADO AUTOMATICAMENTE PELO WORDPRESS
// PROD = PRODUTOS VINCULADOS AO PEDIDO
// CLI = CLIENTES VINCULADOS AO PEDIDO

function pedido_meta_add() {
	add_meta_box( 'pedido_id', 'Id', 'pedido_id_box', 'pedido', 'normal', 'high' );
	add_meta_box( 'pedido_prod', 'Produtos', 'pedido_prod_box', 'pedido', 'normal', 'high' );
	add_meta_box( 'pedido_cli', 'Cliente', 'pedido_cli_box', 'pedido', 'normal', 'high' );
}
function pedido_id_box() {
	?><p>Gerado automaticamente pelo sistema.</p><?php  
}
function pedido_prod_box() {
	$values = get_post_custom( $post->ID );
	$text = isset( $values['prod'] ) ? esc_attr( $values['prod'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
		<p>Insira e/ou selecione o nome do Produto <input list="prod" name="prod" value="<?php echo $text; ?>"></p>
		<datalist id="prod">

		<?php 
		$args = array( 'post_type' => 'produto', 'posts_per_page' => 9999 );
		$the_query = new WP_Query( $args ); 
		if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			
			<option value="<?php the_title(); ?>">

		<?php wp_reset_postdata(); endwhile; endif; ?>

		</datalist>
	<?php  
}
function pedido_cli_box() {
	$values = get_post_custom( $post->ID );
	$text = isset( $values['cli'] ) ? esc_attr( $values['cli'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
		
		<p>Insira e/ou selecione o nome do Cliente <input list="cli" name="cli" value="<?php echo $text; ?>"> Ex: Vinicius Santos</p>
		<datalist id="cli">

		<?php 
		$args = array( 'post_type' => 'cliente', 'posts_per_page' => 9999 );
		$the_query = new WP_Query( $args ); 
		if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			
			<option value="<?php the_title(); ?>">

		<?php wp_reset_postdata(); endwhile; endif; ?>

		</datalist>
	<?php  
}


// VERIFICA E SALVA CONTEÚDOS INSERIDOS NO META BOX

function pedido_meta_save( $post_id ) {
 	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'meta_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'meta_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
 	if( isset( $_POST[ 'prod' ] ) ) {
		update_post_meta( $post_id, 'prod', sanitize_text_field( $_POST[ 'prod' ] ) );
	}
	if( isset( $_POST[ 'cli' ] ) ) {
		update_post_meta( $post_id, 'cli', sanitize_text_field( $_POST[ 'cli' ] ) );
	}
}


// ADICIONAR E PERSONALIZAR COLUNAS NA TELA DE LISTAGEM

function pedidos_columns_head($defaults) {
    $defaults['id'] = 'Número de Identificação';
    $defaults['cli'] = 'Clientes';
    $defaults['prod'] = 'Produtos';
    unset($defaults['title']);
    unset($defaults['date']);
    return $defaults;
} 
function pedidos_columns_content($column_name, $post_ID) {
    if ($column_name == 'id') {
        echo edit_post_link('Pedido nº ' . get_the_ID());
    }
    if ($column_name == 'cli') {
        echo get_post_meta( get_the_ID(), 'cli', true );
    }
    if ($column_name == 'prod') {
        get_post_meta( get_the_ID(), 'prod', true );
    }
}


// ADICIONA AS FUNÇÕES NO WORDPRESS

add_action( 'add_meta_boxes', 'pedido_meta_add' );
add_action( 'save_post', 'pedido_meta_save' );
add_filter('manage_pedido_posts_columns', 'pedidos_columns_head');
add_action('manage_pedido_posts_custom_column', 'pedidos_columns_content', 10, 2);










// REMOVE BARRA DE ADMINISTRADOR DAS PÁGINAS

add_filter( 'show_admin_bar', '__return_false' );

 ?>