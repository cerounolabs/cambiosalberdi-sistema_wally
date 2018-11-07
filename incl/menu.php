        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <a href="#" class="nav-link">
                        <div class="nav-profile-image" style="width:100%; height:100%;">
                            <img src="../images/logo/logo_menu.png" style="width:100%; height:100%; border-radius:0%;" alt="profile">
                            <span class="login-status online"></span>             
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-title">Dashboard</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../pages/persona_alta.php">
                        <span class="menu-title">Nuevas</span>
                        <i class="mdi mdi-account menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" aria-expanded="false" aria-controls="ui-basic">
                        <span class="menu-title">Busqueda</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-account menu-icon"></i>
                    </a>
                    <div class="collapse show">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="../pages/persona_busca_dig.php">Busca x Digitalizado</a></li>
                            <li class="nav-item"> <a class="nav-link" href="../pages/persona_busca_doc.php">Busca x Documento</a></li>
                            <li class="nav-item"> <a class="nav-link" href="../pages/persona_busca_nom.php">Busca x Nombre</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../class/logout.php">
                        <span class="menu-title">Cerrar Sesi&oacute;n</span>
                        <i class="mdi mdi-power menu-icon"></i>
                    </a>
                </li>
            </ul>
        </nav>