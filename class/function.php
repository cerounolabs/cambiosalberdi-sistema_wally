<?php
    function getRealIP() {
        if (isset($_SERVER["HTTP_CLIENT_IP"])){
            return $_SERVER["HTTP_CLIENT_IP"];
        }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
            return $_SERVER["HTTP_X_FORWARDED"];
        }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }elseif (isset($_SERVER["HTTP_FORWARDED"])){
            return $_SERVER["HTTP_FORWARDED"];
        }else{
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    function getPersNueva($str_fecha) {
        $dataPersona    = array();
        $suc_array      = array(
            "CASA MATRIZ"               => "192.168.0.200:aliadocambios",
            "SUC. VILLA MORRA"          => "10.168.196.130:aliadocambios",
            "AGE. SAN LORENZO"          => "10.168.191.130:aliadocambios",
            "SUC. CIUDAD DEL ESTE"      => "10.168.192.138:aliadocambios",
            "AGE. JEBAI"                => "10.168.193.130:aliadocambios",
            "AGE. LAI LAI"              => "10.168.194.130:aliadocambios",
            "AGE. UNIAMERICA"           => "10.168.199.131:aliadocambios",
            "AGE. RUBIO ÑU"             => "10.168.195.130:aliadocambios",
            "AGE. KM4"                  => "10.168.190.130:aliadocambios",
            "SUC. SALTO DEL GUAIRA"     => "10.168.198.130:aliadocambios",
            "AGE. SALTO DEL GUAIRA"     => "10.168.197.130:aliadocambios",
            "SUC. ENCARNACION"          => "10.168.189.130:aliadocambios"
        );
    
        foreach($suc_array as $suc_key => $suc_ip) {
            $str_db         = $suc_ip;
            $str_user       = 'sysdba';
            $str_pass       = 'dorotea';
            $str_conn       = ibase_connect($str_db, $str_user, $str_pass) OR DIE("NO SE CONECTO AL SERVIDOR: ".ibase_errmsg());
            $wSQL00         = ibase_query("SELECT t1.FECHA, t1.ID_PERSONA, t1.CODIGO, t1.CODIGO_UNICO, t1.RUC, t1.PASAPORTE, t1.ID_NACIONALIDAD, t2.DESCRIPCION, t1.ID_PAIS, t3.DESCRIPCION, t1.RAZONSOCIAL, t1.INGRESADOPOR, t1.AUTORIZADOPOR
                                                FROM PERSONAS t1
                                                LEFT JOIN NACIONALIDADES t2 ON t2.ID_NACIONALIDAD = t1.ID_NACIONALIDAD
                                                LEFT JOIN PAISES t3 ON t3.ID_PAIS = t1.ID_PAIS
                                                WHERE t1.FECHA >= '$str_fecha'
                                                ORDER BY t1.FECHA", $str_conn);
        
            while ($row00 = ibase_fetch_row($wSQL00)) {
                $fecPersona     = substr($row00[0], 8, 2).'/'.substr($row00[0], 5, 2).'/'.substr($row00[0], 0, 4);
                $horPersona     = substr($row00[0], 11, 8);
                $dataPersona[]  = array("fecha" => $fecPersona, "hora" => $horPersona, "sucursal" => $suc_key, "id_persona" => $row00[1], "codigo_persona" => $row00[2], "codigo_unico" => $row00[3], 
                                    "ruc" => $row00[4], "pasaporte" => $row00[5], "codigo_nacionalidad" => $row00[6], "nombre_nacionalidad" => $row00[7], "codigo_pais" => $row00[8], "nombre_pais" => $row00[9],
                                    "nombre_persona" => $row00[10], "usuario_ingresado" => $row00[11], "usuario_autorizado" => $row00[12]);
            }

            ibase_free_result($wSQL00);
            ibase_close($str_conn);
        }

        return $dataPersona;
    }

    function getPersDocumento($persona) {
        $persona        = strtoupper($persona);
        $persona        = str_replace(" ", "%", $persona);
        $dataPersona    = array();
        $suc_array      = array(
            "CASA MATRIZ"               => "192.168.0.200:aliadocambios",
            "SUC. VILLA MORRA"          => "10.168.196.130:aliadocambios",
            "AGE. SAN LORENZO"          => "10.168.191.130:aliadocambios",
            "SUC. CIUDAD DEL ESTE"      => "10.168.192.138:aliadocambios",
            "AGE. JEBAI"                => "10.168.193.130:aliadocambios",
            "AGE. LAI LAI"              => "10.168.194.130:aliadocambios",
            "AGE. UNIAMERICA"           => "10.168.199.131:aliadocambios",
            "AGE. RUBIO ÑU"             => "10.168.195.130:aliadocambios",
            "AGE. KM4"                  => "10.168.190.130:aliadocambios",
            "SUC. SALTO DEL GUAIRA"     => "10.168.198.130:aliadocambios",
            "AGE. SALTO DEL GUAIRA"     => "10.168.197.130:aliadocambios",
            "SUC. ENCARNACION"          => "10.168.189.130:aliadocambios"
        );
    
        foreach($suc_array as $suc_key => $suc_ip) {
            $str_db         = $suc_ip;
            $str_user       = 'sysdba';
            $str_pass       = 'dorotea';
            $str_conn       = ibase_connect($str_db, $str_user, $str_pass) OR DIE("NO SE CONECTO AL SERVIDOR: ".ibase_errmsg());
            $wSQL00         = ibase_query("SELECT t1.FECHA, t1.ID_PERSONA, t1.CODIGO, t1.CODIGO_UNICO, t1.RUC, t1.PASAPORTE, t1.ID_NACIONALIDAD, t2.DESCRIPCION, t1.ID_PAIS, t3.DESCRIPCION, t1.RAZONSOCIAL, t1.INGRESADOPOR, t1.AUTORIZADOPOR, t1.ESTADO, t1.CLIENTEAUTORIZADO
                                                FROM PERSONAS t1
                                                LEFT JOIN NACIONALIDADES t2 ON t2.ID_NACIONALIDAD = t1.ID_NACIONALIDAD
                                                LEFT JOIN PAISES t3 ON t3.ID_PAIS = t1.ID_PAIS
                                                WHERE (t1.CODIGO LIKE '%$persona%' OR t1.CODIGO_UNICO LIKE '%$persona%' OR t1.RUC LIKE '%$persona%' OR t1.PASAPORTE LIKE '%$persona%')
                                                ORDER BY t1.FECHA", $str_conn);
        
            while ($row00 = ibase_fetch_row($wSQL00)) {
                $fecPersona     = substr($row00[0], 8, 2).'/'.substr($row00[0], 5, 2).'/'.substr($row00[0], 0, 4);
                $horPersona     = substr($row00[0], 11, 8);

                switch ($row00[13]) {
                    case 'I':
                        $estPersona = 'INACTIVO';
                        break;

                    case 'A':
                        $estPersona = 'ACTIVO';
                        break;
                }

                switch ($row00[14]) {
                    case 'N':
                        $autPersona = 'NO';
                        break;

                    case 'S':
                        $autPersona = 'SI';
                        break;
                    
                    case 'I':
                        $autPersona = 'INACTIVO';
                        break;
                }

                $dataPersona[]  = array("fecha" => $fecPersona, "hora" => $horPersona, "sucursal" => $suc_key, "id_persona" => $row00[1], "codigo_persona" => $row00[2], "codigo_unico" => $row00[3], 
                                    "ruc" => $row00[4], "pasaporte" => $row00[5], "codigo_nacionalidad" => $row00[6], "nombre_nacionalidad" => $row00[7], "codigo_pais" => $row00[8], "nombre_pais" => $row00[9],
                                    "nombre_persona" => $row00[10], "usuario_ingresado" => $row00[11], "usuario_autorizado" => $row00[12], "codigo_estado" => $row00[13], "nombre_estado" => $estPersona,
                                    "codigo_autorizado" => $row00[14], "nombre_autorizado" => $autPersona);
            }

            ibase_free_result($wSQL00);
            ibase_close($str_conn);
        }

        return $dataPersona;
    }

    function getPersNombre($persona) {
        $persona        = strtoupper($persona);
        $persona        = str_replace(" ", "%", $persona);
        $dataPersona    = array();
        $suc_array      = array(
            "CASA MATRIZ"               => "192.168.0.200:aliadocambios",
            "SUC. VILLA MORRA"          => "10.168.196.130:aliadocambios",
            "AGE. SAN LORENZO"          => "10.168.191.130:aliadocambios",
            "SUC. CIUDAD DEL ESTE"      => "10.168.192.138:aliadocambios",
            "AGE. JEBAI"                => "10.168.193.130:aliadocambios",
            "AGE. LAI LAI"              => "10.168.194.130:aliadocambios",
            "AGE. UNIAMERICA"           => "10.168.199.131:aliadocambios",
            "AGE. RUBIO ÑU"             => "10.168.195.130:aliadocambios",
            "AGE. KM4"                  => "10.168.190.130:aliadocambios",
            "SUC. SALTO DEL GUAIRA"     => "10.168.198.130:aliadocambios",
            "AGE. SALTO DEL GUAIRA"     => "10.168.197.130:aliadocambios",
            "SUC. ENCARNACION"          => "10.168.189.130:aliadocambios"
        );
    
        foreach($suc_array as $suc_key => $suc_ip) {
            $str_db         = $suc_ip;
            $str_user       = 'sysdba';
            $str_pass       = 'dorotea';
            $str_conn       = ibase_connect($str_db, $str_user, $str_pass) OR DIE("NO SE CONECTO AL SERVIDOR: ".ibase_errmsg());
            $wSQL00         = ibase_query("SELECT t1.FECHA, t1.ID_PERSONA, t1.CODIGO, t1.CODIGO_UNICO, t1.RUC, t1.PASAPORTE, t1.ID_NACIONALIDAD, t2.DESCRIPCION, t1.ID_PAIS, t3.DESCRIPCION, t1.RAZONSOCIAL, t1.INGRESADOPOR, t1.AUTORIZADOPOR
                                                FROM PERSONAS t1
                                                LEFT JOIN NACIONALIDADES t2 ON t2.ID_NACIONALIDAD = t1.ID_NACIONALIDAD
                                                LEFT JOIN PAISES t3 ON t3.ID_PAIS = t1.ID_PAIS
                                                WHERE (t1.APELLIDO LIKE '%$persona%' OR t1.NOMBRE LIKE '%$persona%' OR t1.RAZONSOCIAL LIKE '%$persona%')
                                                ORDER BY t1.FECHA", $str_conn);
        
            while ($row00 = ibase_fetch_row($wSQL00)) {
                $fecPersona     = substr($row00[0], 8, 2).'/'.substr($row00[0], 5, 2).'/'.substr($row00[0], 0, 4);
                $horPersona     = substr($row00[0], 11, 8);

                switch ($row00[13]) {
                    case 'I':
                        $estPersona = 'INACTIVO';
                        break;

                    case 'A':
                        $estPersona = 'ACTIVO';
                        break;
                }

                switch ($row00[14]) {
                    case 'N':
                        $autPersona = 'NO';
                        break;

                    case 'S':
                        $autPersona = 'SI';
                        break;
                    
                    case 'I':
                        $autPersona = 'INACTIVO';
                        break;
                }
                
                $dataPersona[]  = array("fecha" => $fecPersona, "hora" => $horPersona, "sucursal" => $suc_key, "id_persona" => $row00[1], "codigo_persona" => $row00[2], "codigo_unico" => $row00[3], 
                                    "ruc" => $row00[4], "pasaporte" => $row00[5], "codigo_nacionalidad" => $row00[6], "nombre_nacionalidad" => $row00[7], "codigo_pais" => $row00[8], "nombre_pais" => $row00[9],
                                    "nombre_persona" => $row00[10], "usuario_ingresado" => $row00[11], "usuario_autorizado" => $row00[12], "codigo_estado" => $row00[13], "nombre_estado" => $estPersona,
                                    "codigo_autorizado" => $row00[14], "nombre_autorizado" => $autPersona);
            }

            ibase_free_result($wSQL00);
            ibase_close($str_conn);
        }
        
        return $dataPersona;
    }
?>