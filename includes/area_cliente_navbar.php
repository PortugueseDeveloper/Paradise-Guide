<!-- Navbar --> 
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="area_cliente.php">LOGO AQUI</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active" id="area_cliente_tab">
                <a class="nav-link" href="#">Área de cliente</a>
            </li>
            <li class="nav-item" id="minhas_atividades_tab">
                <a class="nav-link" href="#">Minhas atividades</a>
            </li>
            <li class="nav-item" id="todas_atividades_tab">
                <a class="nav-link" href="#">Todas as atividades</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2 pesquisa_area_cliente" type="text" name="pesquisa_area_cliente" placeholder="Pesquise qualquer atividade...">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Pesquisar!</button>
        </form>
        <a href="includes/cliente_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão</button></a>
    </div>
</nav>
<!-- Final da navbar -->