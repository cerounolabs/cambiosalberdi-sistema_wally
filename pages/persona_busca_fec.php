<?php
    include '../class/header.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
<?php
  include '../incl/head.php';
?>

    </head>
    <body>
        <div class="container-scroller">
<?php
    include '../incl/menu.php';
?>
            <div class="container-fluid page-body-wrapper">
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="page-header">
                            <h1 class="page-title" style="font-size:2.19rem !important;">
                                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                    <i class="mdi mdi-home"></i>                 
                                </span>
                                GEOLOCALIZACI&Oacute;N DE PERSONA X FECHA DIGITALIZADO
                            </h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="forms-sample">
                                            <div class="form-group">
                                                <label for="persona"> FECHA </label>
                                                <input type="date" class="form-control" style="text-transform:uppercase;" id="persona" name="persona" placeholder="FECHA">
                                            </div>

                                            <a type="button" class="btn btn-gradient-primary btn-fw" style="float:right; margin-bottom: .75rem; background-color: rgba(172, 50, 228, 0.9); background-image: linear-gradient(to right, #da8cff, #9a55ff);" onclick="buscaPersona()"> Consultar </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <a type="button" class="btn btn-gradient-primary btn-fw" style="float:right; margin-bottom: .75rem; background-color: rgba(172, 50, 228, 0.9); background-image: linear-gradient(to right, #da8cff, #9a55ff);" href="#" onclick="exportToExcel('exTable')"><i class="mdi mdi-file-excel "></i> Exportar a Excell</a>
                                        <table id="exTable" class="table table-striped" border="1">
                                            <thead>
                                                <tr valign="middle">
                                                    <th style="text-align:center;"> NRO </th>
                                                    <th style="text-align:left;"> FECHA HORA </th>
                                                    <th style="text-align:left;"> SUCURSAL </th>
                                                    <th style="text-align:left;"> ARCHIVO </th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
    if (isset($_GET['persona'])) {
        $item        = 0;
        $arr_persona = $_GET['persona'];
        $suc_array   = array(
            "CASA MATRIZ"               => "/mnt_matriz/",
            "SUC. VILLA MORRA"          => "/mnt_villa/",
            "AGE. SAN LORENZO"          => "/mnt_sanlo/",
            "SUC. CIUDAD DEL ESTE"      => "/mnt_suc1/",
            "AGE. JEBAI"                => "/mnt_jebai/",
            "AGE. LAI LAI"              => "/mnt_lailai/",
            "AGE. UNIAMERICA"           => "/mnt_uniamerica/",
            "AGE. RUBIO ÑU"             => "/mnt_rubio/",
            "AGE. KM4"                  => "/mnt_km4/",
            "SUC. SALTO DEL GUAIRA"     => "/mnt_suc4/",
            "AGE. SALTO DEL GUAIRA"     => "/mnt_ag4/",
            "SUC. ENCARNACION"          => "/mnt_encar/"
        );

        foreach($suc_array as $suc_key => $suc_ip) {
            $fichero    = fopen($suc_ip, "r") or die($suc_key.' => DISCO NO MONTADO'."\n");
        
            if (!$fichero) {
                echo 'NO SE PUDO ABRIR EL DIRECTORIO DE LA SUCURSAL '.$suc_key;
            } else {
                $dir = opendir($suc_ip);
                while ($elemento = readdir($dir)) {
                    if ($elemento == '.' || $elemento == '..' || $elemento == 'Thumbs.db') {
                    } else {
                        $fecCreacion = date("Y-m-d", filemtime($suc_ip.''.$elemento));
                        
                        if ($fecCreacion == $arr_persona) {
                            $item = $item + 1;
?>
                                                <tr>
                                                    <td style="text-align:right;">  <?php echo $item; ?> </td>
                                                    <td style="text-align:left;">   <?php echo date("d/m/Y H:i:s", filemtime($suc_ip.''.$elemento)); ?> </td>
                                                    <td style="text-align:left;">   <?php echo $suc_key; ?>  </td>
                                                    <td style="text-align:left;"> <a href="persona_doc.php?persona=<?php echo $suc_ip.''.$elemento; ?>" target="_blank"> <?php echo $elemento; ?> </a></td>
                                                </tr>
<?php
                        }
                    }
                }
                closedir($dir);
            }
        }
    }
?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php  include '../incl/footer.php'; ?>
        <script>
            function buscaPersona() {
                var persona = document.getElementById("persona").value;
                var urlGET  = "";

                if (persona !== null && persona !== '') {
                    urlGET = "http://10.168.196.152/sistema_wally/pages/persona_busca_fec.php?persona=" + persona;
                } else {
                    urlGET = "http://10.168.196.152/sistema_wally/pages/persona_busca_fec.php";
                }
                
                window.location.href    = urlGET;
            }

            function exportToExcel(tableID){
                var tab_text    ="<table border='2px'><tr bgcolor='#87AFC6' style='height: 75px; text-align: center; width: 250px'>";
                var textRange   = 0; 
                var j           = 0;
                tab             = document.getElementById(tableID);

                for(j = 0 ; j < tab.rows.length ; j++) {
                    tab_text = tab_text;
                    tab_text = tab_text+tab.rows[j].innerHTML.toUpperCase() + "</tr>";
                }

                tab_text    = tab_text + "</table>";
                tab_text    = tab_text.replace(/<A[^>]*>|<\/A>/g, "");
                tab_text    = tab_text.replace(/<img[^>]*>/gi,"");
                tab_text    = tab_text.replace(/<input[^>]*>|<\/input>/gi, "");
                
                var ua      = window.navigator.userAgent;
                var msie    = ua.indexOf("MSIE ");
                
                if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                    txtArea1.document.open("txt/html","replace");
                    txtArea1.document.write('sep=,\r\n' + tab_text);
                    txtArea1.document.close();
                    txtArea1.focus();
                    sa = txtArea1.document.execCommand("SaveAs",true,"sudhir123.txt");
                }
                else {
                    sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
                }
                
                return (sa);
            }

            $(document).keypress(function (e) {
                if (e.which == 13) {
                    buscaPersona();
                }
            });
        </script>
    </body>
</html>