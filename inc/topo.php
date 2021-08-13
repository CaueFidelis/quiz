<ul class="nav mt-2 mb-2">
    <?php
    // session_start();
    // Verificar se o usuário está logado
    Helper::logado();

        if(isset($_SESSION['usuario'])){
            echo '<li class="nav-item"><span class="nav-link">Olá '.$_SESSION['usuario'].'</span></li>';
        }
    ?>
    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-home"></i> HOME</a></li>
    <li class="nav-item"><a class="nav-link" href="classificacao"><i class="fas fa-trophy"></i> CLASSIFICAÇÃO</a></li>
    <li class="nav-item"><a class="nav-link" href="responder-perguntas"><i class="fas fa-question-circle"></i> RESPONDER </a></li>
    <?php
        if($_SESSION['nivel'] == 2){
    ?>
    <li class="nav-item"><a class="nav-link" href="categorias"><i class="fas fa-list"></i> CATEGORIAS</a></li>
    <li class="nav-item"><a class="nav-link" href="perguntas"><i class="fas fa-question-circle"></i> PERGUNTAS</a></li>
    <li class="nav-item"><a class="nav-link" href="usuarios"><i class="fas fa-users"></i> USUÁRIOS</a></li>
    <?php
      } // fecha if
    ?>
    <li class="nav-item"><a class="nav-link" href="sair"><i class="fas fa-sign-out-alt"></i> SAIR</a></li>
</ul>