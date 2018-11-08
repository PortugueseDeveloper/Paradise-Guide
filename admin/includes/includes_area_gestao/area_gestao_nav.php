<!-- Navegação administrativa -->
<div class="admin">

  <!-- Admin sidebar -->
  <div class="admin-sidebar bg-faded">
    
    <div class="navbar navbar-light">

      <!-- Toggler to menu de navegação -->
      <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#sidebar-navigation" aria-controls="sidebar-navigation" aria-expanded="false" aria-label="Toggle navigation" id="menu_button">
          <ion-icon class="menu_icons" name="menu"></ion-icon>Menu administrativo
      </button>
      
      <div class="collapse show navbar-toggleable-md py-2" role="navigation" id="sidebar-navigation">
 
        <hr>

        <!-- Gestão de atividades -->
        <ul class="nav navbar-nav">
          
          <!-- Opção de vizualizar todas as atividades -->
          <li>
            <a href="" onclick="return false;" class="nav-link active" id="all_activities_admin_tab">
              <ion-icon name="eye" class="menu_icons"></ion-icon>
              Vizualizar todas as atividades
            </a>
          </li>
          <li>

            <!-- Opção de criar uma nova atividade -->
            <a href="" onclick="return false;" class="nav-link" id="new_activity_admin_tab">
            <ion-icon name="add-circle" class="menu_icons"></ion-icon>
              Criar uma nova atividade
            </a>
          </li>

          <!-- Opção de editar atividades -->
          <li>    
            <a href="" onclick="return false;" class="nav-link" id="edit_activities_admin_tab">
              <ion-icon name="build" class="menu_icons"></ion-icon>Editar atividades</a>
          </li>
         
        </ul>

        <hr>

        <ul class="nav navbar-nav">

            <!-- Opção de vizualizar todas as reservas -->
            <li>
                <a href="" onclick="return false;" class="nav-link" id="all_reserves_admin_tab">
                <ion-icon name="eye" class="menu_icons"></ion-icon>Vizualizar todas as reservas</a>
            </li>

            <!-- Opção de editar estado das reservas -->
            <li>
                <a href="" onclick="return false;" class="nav-link" id="edit_reserves_admin_tab">
                <ion-icon name="build" class="menu_icons"></ion-icon>Editar estado das reservas
                </a>
            </li>

        </ul>

        <hr>
        
    </div>

  </div>

</div>