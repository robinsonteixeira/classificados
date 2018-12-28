<?php require 'cabecalho.php';?> <!-- chamando o arquivo do inicio do html, head e o cabeçalho . Economiza espaço aqui e
								quando for fazer qualquer alteração no cabeçalho, altera todos os arquivos que tiver 
								o cabeçalho.
								OBS... O arquivo cabecalho.php já está chamando o conexao-db.php -->
<?php 
	require 'classes/anuncios.classe.php';
	require_once 'classes/usuarios.classe.php';
	require 'classes/categoria.classe.php';
			 $a = new Anuncios();
			 $u = new Usuarios(); 
			 $c = new Categoria();

			 $total_anuncios = $a->getTotalAnuncios();
			 $total_usuarios = $u->getTotalUsuarios();
			 $categorias = $c->getCategoria();
			

		//---------- Paginação ---------------------- 
		
		$p = 1; // página atual vai ser $p e por padrão com valor 1

		if (isset($_GET['p']) && !empty($_GET['p'])) {
			
			$p = addslashes($_GET['p']);  // a página padrão é $p = 1, mas se tiver outra página, grava o $_GET['p'] na variável $p.
		}

		$por_pagina = 5;
		$total_paginas = ceil($total_anuncios / $por_pagina);

		$anuncios = $a->getUltimosAnuncios($p, $por_pagina); // recebe o parâmetro $p 

		// ----------- Fim paginação -----------------------

?>
	<div class="container-fluid">
		<div class="jumbotron">
			<h2>Nós temos hoje <?php echo $total_anuncios ;?> anúncios.</h2>
			<h3><?php echo $total_usuarios ;?> usuários cadastrados.</h3>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<h4>Pesquisa avançada</h4>
				<form method="GET">
					<div class="form-group">
						<label id="categoria">Categoria:</label>
						<select id="categoria" class="form-control" name="filtros[categoria]">
							<option></option>
							<?php foreach ($categorias as $cat):?>
							<option value="<?php echo $cat['id'];?>"><?php echo $cat['nome'];?></option>
							<?php endforeach ;?>
						</select>
					</div>
					<div class="form-group">
						<label id="preco">Preço:</label>
						<select class="form-control" id="preco" name="filtros[preco]">
							<option></option>
							<option value="0-100">R$ 0 - 100,00</option>
							<option value="101-500">R$ 101,00 - 500,00</option>
							<option value="501-1000">R$ 501,00 - 1.000,00</option>
							<option value="1001-5000">R$ 1.001,00 - 5.000,00</option>
						</select>
					</div>
					<div class="form-group">
						<label id="estado">Estado de conservação:</label>
						<select class="form-control" id="estado" name="filtros[estado]">
							<option></option>
							<option value="1">Ruim</option>
							<option value="2">Bom</option>
							<option value="3">Ótimo</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Buscar">
					</div>
				</form>
			</div>
			<div class="col-sm-9">
				<h4>Últimos anúncios</h4>
				<table class="table table-striped">
					<tbody>
						<?php foreach ($anuncios as $anuncio):?>
						<tr>
							<td>
								<?php if(!empty($anuncio['url'])) :?> <!--se $anuncio['url'] não estiver vazia, pegar a foto do bd. senão colocar a foto em breve-->
								<a href="produto.php?id=<?php echo $anuncio['id'];?>"><img src="imagens/anuncios/<?php echo $anuncio['url'] ;?>" height="50" border="0"></a>
								<?php else :?>
								<a href="produto.php?id=<?php echo $anuncio['id'];?>"><img src="imagens/anuncios/breve.png" height="50"></a>
								<?php endif ;?>	
							</td>
							<td>	
								<a href="produto.php?id=<?php echo $anuncio['id'];?>"><?php echo $anuncio['titulo'];?></a></br>
								<?php echo $anuncio['categoria'];?>
							</td>
							<td>
								R$ <?php echo $anuncio['valor'];?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<ul class="pagination">
					<?php for($q=1;$q<=$total_paginas;$q++): ?>
					<li><a href="index.php?p=<?php echo $q; ?>"><?php echo $q; ?></a></li>
					<?php endfor;?>
				</ul>	
			</div>
		</div>
	</div>

<?php require 'rodape.php';?> <!-- chamando o arquivo do rodape separado. Economiza espaço aqui e
								 quando for fazer qualquer alteração, altera todos os arquivos que tiver o rodape.-->	
