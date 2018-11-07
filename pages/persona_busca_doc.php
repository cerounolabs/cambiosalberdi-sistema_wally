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
            <div class="container-fluid page-body-wrapper">
<?php
  include '../incl/menu.php';
?>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="page-header">
                            <h1 class="page-title" style="font-size:2.19rem !important;">
                                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                    <i class="mdi mdi-home"></i>                 
                                </span>
                                GEOLOCALIZACIÓN DE PERSONA X NRO DOCUMENTO
                            </h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="forms-sample">
                                            <div class="form-group">
                                                <label for="persona"> N&Uacute;MERO DOCUMENTO </label>
                                                <input type="text" class="form-control" style="text-transform:uppercase;" id="persona" name="persona" placeholder="N&Uacute;MERO DOCUMENTO">
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
                                                    <th style="text-align:center;"> FECHA HORA </th>
                                                    <th style="text-align:center;"> SUCURSAL </th> 
                                                    <th style="text-align:center;"> ESTADO </th>
                                                    <th style="text-align:center;"> AUTORIZADO </th>
                                                    <!--<th style="text-align:center;"> ID_PERSONA </th>-->
                                                    <th style="text-align:center;"> CODIGO </th>
                                                    <th style="text-align:center;"> CODIGO_UNICO </th>
                                                    <th style="text-align:center;"> RUC </th>
                                                    <th style="text-align:center;"> PASAPORTE </th>
                                                    <th style="text-align:center;"> NACIONALIDAD </th>
                                                    <th style="text-align:center;"> PAIS </th>
                                                    <th style="text-align:center;"> APELLIDO, NOMBRE </th>
                                                    <th style="text-align:center;"> INGRESADO POR </th>
                                                    <!--<th style="text-align:center;"> AUTORIZADO POR </th>-->
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
    $item           = 0;

    if (isset($_GET['persona'])) {
        $arr_persona = getPersDocumento($_GET['persona']);

        foreach($arr_persona as $dat_persona) {
            $item   = $item + 1;
?>
                                                <tr>
                                                    <td style="text-align:right;">  <?php echo $item; ?> </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['fecha'].' '.$dat_persona['hora']; ?> </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['sucursal']; ?>  </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['nombre_estado']; ?>  </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['nombre_autorizado']; ?>  </td>
                                                    <!--<td style="text-align:left;">   <?php //echo $dat_persona['id_persona']; ?>  </td>-->
                                                    <td style="text-align:left;">   <?php echo $dat_persona['codigo_persona']; ?>  </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['codigo_unico']; ?>  </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['ruc']; ?>  </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['pasaporte']; ?>  </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['nombre_nacionalidad']; ?> </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['nombre_pais']; ?>  </td>
                                                    <td style="text-align:left; font-weight:bold;"> <?php echo $dat_persona['nombre_persona']; ?>  </td>
                                                    <td style="text-align:left;">   <?php echo $dat_persona['usuario_ingresado']; ?>   </td>
                                                    <!--<td style="text-align:left;">   <?php //echo $dat_persona['usuario_autorizado']; ?>   </td>-->
                                                </tr>
<?php
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
                    urlGET = "http://10.168.196.152/sistema_wally/pages/persona_busca_doc.php?persona=" + persona;
                } else {
                    urlGET = "http://10.168.196.152/sistema_wally/pages/persona_busca_doc.php";
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