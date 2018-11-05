<!-- Header da área de cliente -->
<?php include_once("includes/includes_area_cliente/area_cliente_header.php"); ?>

<?php 
    
    # Definir mensagem de sucesso e de erro - vazias inicialmente
    $message_error_or_success = "";

?>

<?php 

    # Aceder a todos os dados de cada atividade
    $activities = Activity::find_all_activities(); 

    // Funcionalidade que possibilita reservar atividades
    # Obter o ID do utilizador que possui sessão iniciada
    $username = $_SESSION["client"];
    $user_id = User::find_id_by_username($username);
    $idUser = $user_id->idUser;

    // Processo de inserção na base de dados
    if (isset($_POST["reserve_btn"])) {
        
        # Obter o número do cartão de crédito
        $cartaoCredito = $_POST["credit_card"];

        if (!empty($cartaoCredito)) {
            
            /* Eliminar todo o "whitespace" em branco do campo que contém o número 
            de cartão de crédito */
            $cartaoCredito = trim(preg_replace('/\s+/', '', $cartaoCredito));

            # Proteção contra XSS (Cross-Site Scripting)
            $cartaoCredito = htmlspecialchars($cartaoCredito, ENT_QUOTES, 'UTF-8');
            
            # Variável do resultado das validações definida como verdadeira inicialmente 
            $result = true;

             # Obter o ID da atividade em questão
            if (isset($_GET["action"])) {
                $idAtividade = $_GET["id"];
            }

            # Validações do número de cartão de crédito (número de caracteres)
            if (strlen($cartaoCredito) !== 16) {
                $message_error_or_success = "<div class='alert alert-danger text-center' role='alert'>O número de cartão de crédito introduzido não é válido!</div>";
                $result = false;
            } else {
                $message_error_or_success = "<div class='alert alert-success text-center' role='alert'>A atividade foi reservada com sucesso! Poderá verificar o estado da mesma na lista de atividades.</div>";
            }

            /* Caso a validação do número de cartão de crédito obtenha sucesso
            a variável de resultado retorna "true" */
            if ($result) {

                # Proceder à reserva de uma dada atividade
                $sql = "INSERT INTO reservas (idAtividade, idUser, cartaoCredito, estadoReserva) ";
                $sql .= "VALUES(:idAtividade, :idUser, :cartaoCredito, :estadoReserva)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([":idAtividade" => $idAtividade, ":idUser" => $idUser, ":cartaoCredito" => $cartaoCredito, ":estadoReserva" => "Marcada"]);

                # Refrescar a página 
                header("Refresh:3;url=area_cliente.php");

            }
            
        }
         
    }

?>

<body class="body_area_cliente">

    <!-- Navbar da área de cliente -->
    <?php include_once("includes/includes_area_cliente/area_cliente_navbar.php"); ?>

    <!-- Listagem de todas as atividades disponíveis --> 
    <div id="all_activities">

        <h1>Aqui se encontram todas as atividades disponíveis</h1>

        <?php

        foreach($activities as $activity) {
        
        ?>
            
            <!-- Grupo que contém os detalhes de cada atividade -->
            <div class="list-group">
            <div class="list-group-item list-group-item-action flex-column align-items-start active">
            
            <!-- Título da atividade -->
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-3"><?php echo $activity->nomeAtividade; ?></h5>
            </div>
            
            <!-- Descrição da atividade --> 
            <p class="mb-3"><?php echo utf8_encode($activity->descricaoAtividade); ?></p>

            <!-- Zona da atividade --> 
            <p class="mb-2"><span class="subtitulo_listagem">Zona:</span> <?php echo utf8_encode($activity->zonaAtividade); ?></p>

            <!-- Duração média da atividade -->
            <p class="mb-2"><span class="subtitulo_listagem">Duração média:</span> <?php echo ($activity->duracaoAtividade); ?></p>  

            <!-- Preço da atividade -->
            <p class="mb-2"><span class="subtitulo_listagem">Preço:</span> <?php echo $activity->precoAtividade; ?>€</p>

            <p>IMAGEM DE DESTAQUE À DIREITA</p>
                
                <!-- Separador --> 
                <hr class="hr_style">

                <!-- Formulário de reserva - através de cartão de crédito -->
                <h3 class="call_to_reserve">Deseja reservar esta atividade? Proceda ao preenchimento do formulário abaixo!</h3>

                <form action="area_cliente.php?action=reserve&id=<?php echo $activity->idAtividade; ?>" method="post" autocomplete="off" id="reserve_form" role="form">

                        <!-- Transmissão da mensagem de erro ou de sucesso consoante a validação 
                        do cartão de crédito -->
                        <?php 
                            
                            if(!empty($_GET["action"])) {

                                if($_GET["id"] === $activity->idAtividade) { 
                                    echo $message_error_or_success;
                                }
                            
                            }
                        ?>

                        <!-- Número do cartão de crédito -->
                        <div class="form-group">
                            <label>Número do cartão de crédito</label>
                            <input type="text" name="credit_card" id="cn" class="form-control" placeholder="" required>
                        </div>

                        <!-- Data de expiração do cartão de crédito -->
                        <div class="form-group">
                            <label>Data de expiração</label>
                            <input type="text" name="expiration_date" id="exp" placeholder="MM / AA" class="form-control" required>
                        </div>

                        <!-- Nome presente no cartão de crédito -->
                        <div class="form-group">
                        <label>Nome presente no cartão</label>
                        <input type="text" name="card_name" id="card_name" placeholder="Digite aqui o nome presente no cartão" class="form-control" required>
                        
                        <!-- Inputs type "hidden" -->
                        <input type="hidden" name="nome_atividade" value="<?php echo $activity->idAtividade; ?>">

                     </div>

                    <!-- Botão de reserva -->
                    <div style="text-align: center">
                        <button type="submit" name="reserve_btn" id="reserve_button" 
                        class="btn">Reservar atividade!</button>
                    </div>

                </form>

            </div>
        
        </div>

        <?php } ?>

    </div>

    <!-- Atividades escolhidas pelo utilizador -->
    <div id="user_activities">

        <h1>Pode consultar aqui todas as suas atividades reservadas</h1>
        
        <!-- Tabela com todas as atividades escolhidas pelo utilizador --> 
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">

                <thead>
                    <tr>
                        <th>Nome da atividade</th>
                        <th>Descrição da atividade</th>
                        <th>Zona</th>
                        <th>Duração média</th>
                        <th>Imagem</th>
                        <th>Preço</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    
                    <?php 

                    # Obter da base de dados todas as reservas efetuadas pelo utilizador --> 
                    $reserves = Reserve::find_all_reserves();

                    /* Relacionar as tabelas "atividades" e "reservas", de modo a obter as reservas 
                    e atividades do utilizador em questão */
                    foreach ($reserves as $reserve) {
                        $idAtividadeReserva = $reserve->idAtividade;
                        $estadoReserva = $reserve->estadoReserva;
                        $userReserva = $reserve->idUser;

                        if ($userReserva === $idUser) {

                            foreach($activities as $activity) {
                                
                                $idAtividade = $activity->idAtividade;
                                
                                if ($idAtividadeReserva === $idAtividade) {
                                    
                                    echo "<tr>";
                                    echo utf8_encode("<td>{$activity->nomeAtividade}</td>");
                                    echo utf8_encode("<td>{$activity->descricaoAtividade}</td>");
                                    echo utf8_encode("<td>{$activity->zonaAtividade}</td>");
                                    echo "<td>{$activity->duracaoAtividade}</td>" ;
                                    echo utf8_encode("<td>{$activity->imagemAtividade}</td>");
                                    echo "<td>{$activity->precoAtividade}€</td>" ;
                                    echo "<td>{$reserve->estadoReserva}</td>" ;
                                    echo "</tr>";

                                }

                            }

                        }


                    }

                    ?>

                </tbody>
            
            </table>

        </div>

    </div> 

    <!-- Footer do índex -->
    <?php include_once("includes/includes_area_cliente/area_cliente_footer.php"); ?>

</body>
</html>