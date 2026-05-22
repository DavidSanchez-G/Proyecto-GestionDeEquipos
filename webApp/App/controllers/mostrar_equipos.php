<table id="tabla-historial" class="tabla-listado" aria-describedby="titulo-listado">
    <thead>
    <tr>
        <th scope="col">Equipo</th>
        <th scope="col">Numero</th>
        <th scope="col">Aula</th>
        <th scope="col">Alumno</th>
        <th scope="col">Nº de serie</th>
        <th scope="col">Modelo</th>
        <th scope="col">Marca</th>
        <?php
        $tipo = '';
        if (isset($_GET['tipo'])) {
            $tipo = $_GET['tipo'];
        }

        if ($tipo == "ordenador" or empty($tipo)) {
            echo "<th scope='col'>Sistema operativo</th>";
        }
        echo "<th scope='col'>Estado</th>";
        if ($rolUsuario == 'admin') {
            echo "<th scope='col'></th>";
        }
        ?>
    </tr>
    </thead>

    <tbody>
    <?php
    if($tipo == 'ordenador' or empty($tipo)) {
        $sql = "SELECT * FROM ordenadores WHERE 1=1";

        if (!empty($_GET['numero_equipo'])){
            $numero_equipo = $_GET['numero_equipo'];
            $sql .= " AND numero = '". $numero_equipo. "'";
        }
        if (!empty($_GET['aula'])){
            $aula = $_GET['aula'];
            $sql .= " AND fk_idAula = '". $aula. "'";

        }
        if (!empty($_GET['numero_serie'])){
            $numero_serie = $_GET['numero_serie'];
            $sql .= " AND num_serie = '". $numero_serie. "'";
        }
        if (!empty($_GET['modelo'])){
            $modelo = $_GET['modelo'];
            $sql .= " AND modelo = '". $modelo. "'";
        }
        if (!empty($_GET['marca'])){
            $marca = $_GET['marca'];
            $sql .= " AND marca = '". $marca. "'";
        }
        if (!empty($_GET['so'])){
            $so = $_GET['so'];
            $sql .= " AND so = '". $so. "'";
        }
        if (!empty($_GET['estado'])){
            $estado = $_GET['estado'];
            $sql .= " AND estado = '". $estado. "'";
        }
        if (!empty($_GET['nombre']) OR !empty($_GET['apellido'])) {
            $nombre = htmlspecialchars($_GET['nombre']);
            $apellido = htmlspecialchars($_GET['apellido']);
            $alumnos = "SELECT * FROM alumnos WHERE 1=1";
            if (!empty($_GET['nombre'])) {
                $alumnos .= " AND nombre LIKE '%" . $nombre . "%'";
            }
            if (!empty($_GET['apellido'])) {
                $alumnos .= " AND apellidos LIKE '%". $apellido. "%'";
            }
            $result = mysqli_query($conn, $alumnos);
            while ($row = mysqli_fetch_assoc($result)) {
                $sql .= " AND idOrdenador = '". $row['fk_idOrdenador_alumno']. "'";
                $resultado = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultado) > 0) {
                    while($row_ordenador = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td id='usuario1'>Ordenador</td>";
                        echo "<td>".$row_ordenador['numero']."</td>";
                        $sql_aula = "SELECT * FROM aulas WHERE idAula = '".$row_ordenador['fk_idAula']."'";
                        $resultado_aula = mysqli_query($conn, $sql_aula);
                        if (mysqli_num_rows($resultado_aula) > 0) {
                            $row_aula = mysqli_fetch_assoc($resultado_aula);
                            echo "<td>".$row_aula['nombre_aula']."</td>";
                        } else {
                            echo "<td>Sin aula</td>";
                        }
                        $sql_alumno = "SELECT * FROM alumnos WHERE fk_idOrdenador_alumno = '".$row_ordenador['idOrdenador']."'";
                        $resultado_alumno = mysqli_query($conn, $sql_alumno);
                        if (mysqli_num_rows($resultado_alumno) > 0) {
                            while($row_alumno = mysqli_fetch_assoc($resultado_alumno)) {
                                echo "<td>".$row_alumno['nombre']. " ". $row_alumno['apellidos'];
                                echo "<br><form action='../../controllers/control_asignar.php' method='POST'><button type='submit' class='btn-eliminar' name='ordenador_quitar' value='" . $row_alumno['idAlumno'] . "'>DES-ASIGNAR</button></form></td>";
                            }
                        } else {
                            echo "<td>sin alumno asignado";
                            echo "<br><form action='asignar.php' method='POST'><button type='submit' class='btn-eliminar' name='ordenador' value='" . $row_ordenador['idOrdenador'] . "'>ASIGNAR</button></form></td>";
                        }

                        echo "<td>".$row_ordenador['num_serie']."</td>";
                        echo "<td>".$row_ordenador['modelo']."</td>";
                        echo "<td>".$row_ordenador['marca']."</td>";
                        echo "<td>".$row_ordenador['so']."</td>";
                        echo "<td>".$row_ordenador['estado'];
                        if ($rolUsuario == 'admin') {
                            echo "<br> <form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' type='submit' name='estado_ordenador' value='". $row_ordenador['idOrdenador']. "'>cambiar estado</button></form></td>";
                            echo "<td><form action='../../controllers/control_eliminar.php' method='POST'><button type='submit' class='btn-eliminar' name='ordenador' value='" . $row_ordenador['idOrdenador'] . "'>ELIMINAR</button></form></td>";
                        } else {
                            echo "</td>";
                        }
                        echo "</tr>";
                    }

                }
            }
        } else {
            $resultado = mysqli_query($conn, $sql);
            if (mysqli_num_rows($resultado) > 0) {
                while($row_ordenador = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td id='usuario1'>Ordenador</td>";
                    echo "<td>".$row_ordenador['numero']."</td>";
                    $sql_aula = "SELECT * FROM aulas WHERE idAula = '".$row_ordenador['fk_idAula']."'";
                    $resultado_aula = mysqli_query($conn, $sql_aula);
                    if (mysqli_num_rows($resultado_aula) > 0) {
                        $row_aula = mysqli_fetch_assoc($resultado_aula);
                        echo "<td>".$row_aula['nombre_aula']."</td>";
                    } else {
                        echo "<td>Sin aula</td>";
                    }
                    $sql_alumno = "SELECT * FROM alumnos WHERE fk_idOrdenador_alumno = '".$row_ordenador['idOrdenador']."'";
                    $resultado_alumno = mysqli_query($conn, $sql_alumno);
                    if (mysqli_num_rows($resultado_alumno) > 0) {
                        while($row_alumno = mysqli_fetch_assoc($resultado_alumno)) {
                            echo "<td>".$row_alumno['nombre']. " ". $row_alumno['apellidos'];
                            echo "<br><form action='../../controllers/control_asignar.php' method='POST'><button type='submit' class='btn-eliminar' name='ordenador_quitar' value='" . $row_alumno['idAlumno'] . "'>DES-ASIGNAR</button></form></td>";
                        }
                    } else {
                        echo "<td>sin alumno asignado";
                        echo "<br><form action='asignar.php' method='POST'><button type='submit' class='btn-eliminar' name='ordenador' value='" . $row_ordenador['idOrdenador'] . "'>ASIGNAR</button></form></td>";
                    }

                    echo "<td>".$row_ordenador['num_serie']."</td>";
                    echo "<td>".$row_ordenador['modelo']."</td>";
                    echo "<td>".$row_ordenador['marca']."</td>";
                    echo "<td>".$row_ordenador['so']."</td>";
                    echo "<td>".$row_ordenador['estado'];
                    if ($rolUsuario == 'admin') {
                        echo "<br> <form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' type='submit' name='estado_ordenador' value='". $row_ordenador['idOrdenador']. "'>cambiar estado</button></form></td>";
                        echo "<td><form action='../../controllers/control_eliminar.php' method='POST'><button type='submit' class='btn-eliminar' name='ordenador' value='" . $row_ordenador['idOrdenador'] . "'>ELIMINAR</button></form></td>";
                    } else {
                        echo "</td>";
                    }
                    echo "</tr>";
                }

            } else {
                echo "<tr><td colspan='9'>No se encontraron resultados</td></tr>";
            }
        }

    }
    if ($tipo != 'ordenador' or empty($tipo)) {
        echo "<tr>";
        $sql = "SELECT * FROM perifericos WHERE 1=1";
        if (!empty($_GET['numero_equipo'])) {
            $numero_equipo = $_GET['numero_equipo'];
        }
        if (!empty($_GET['aula'])) {
            $aula = $_GET['aula'];
            $sql .= " AND fk_idAula = '" . $aula . "'";
        }
        if (!empty($_GET['numero_serie'])) {
            $numero_serie = $_GET['numero_serie'];
            $sql .= " AND num_serie = '" . $numero_serie . "'";
        }
        if (!empty($_GET['modelo'])) {
            $modelo = $_GET['modelo'];
            $sql .= " AND modelo = '" . $modelo . "'";
        }
        if (!empty($_GET['marca'])) {
            $marca = $_GET['marca'];
            $sql .= " AND marca = '" . $marca . "'";
        }
        if (!empty($_GET['estado'])) {
            $estado = $_GET['estado'];
            $sql .= " AND estado = '" . $estado . "'";
        }
        if (!empty($_GET['tipo'])) {
            $tipo = $_GET['tipo'];
            $sql .= " AND fk_id_tipo_periferico = '" . $tipo . "'";
        }
        if (!empty($_GET['nombre']) or !empty($_GET['apellido'])) {
            $nombre = $_GET['nombre'];
            $apellido = $_GET['apellido'];
            $alumnos = "SELECT * FROM alumnos WHERE 1=1";
            if (!empty($_GET['nombre'])) {
                $alumnos .= " AND nombre LIKE '%" . $nombre . "%'";
            }
            if (!empty($_GET['apellido'])) {
                $alumnos .= " AND apellidos LIKE '%" . $apellido . "%'";
            }
            $result = mysqli_query($conn, $alumnos);
            while ($row_filtro = mysqli_fetch_assoc($result)) {
                $sql .= " AND fk_idAlumno = '". $row_filtro['idAlumno']. "'";
                $resultado = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultado) > 0) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        $sql_tipo = "SELECT * FROM tipo_periferico WHERE id_tipo_periferico = '" . $row['fk_id_tipo_periferico'] . "'";
                        $resul_tipo = mysqli_query($conn, $sql_tipo);
                        if (mysqli_num_rows($resul_tipo) > 0) {
                            $row_tipo = mysqli_fetch_assoc($resul_tipo);
                            echo "<td>" . htmlspecialchars($row_tipo['tipo']) . "</td>";
                        }
                        echo "<td>" . htmlspecialchars($row['numero']) . "</td>";
                        $sql_aula = "SELECT * FROM aulas WHERE idAula = '" . $row['fk_idAula'] . "'";
                        $resultado_aula = mysqli_query($conn, $sql_aula);
                        if (mysqli_num_rows($resultado_aula) > 0) {
                            $row_aula = mysqli_fetch_assoc($resultado_aula);
                            echo "<td>" . $row_aula['aula'] . "</td>";
                        } else {
                            echo "<td>Sin aula asignada</td>";
                        }
                        $sql_alumno = "SELECT * FROM alumnos WHERE idAlumno = '" . $row['fk_idAlumno'] . "'";
                        $resultado_alumno = mysqli_query($conn, $sql_alumno);
                        if (mysqli_num_rows($resultado_alumno) > 0) {
                            $row_alumno = mysqli_fetch_assoc($resultado_alumno);
                            echo "<td>" . $row_alumno['nombre'] . " " . $row_alumno['apellidos'];
                            echo "<br><form action='asignar.php' method='POST'><button type='submit' class='btn-eliminar' name='periferico_quitar' value='" . $row['idPeriferico'] . "'>DES-ASIGNAR</button></form></td>";
                        } else {
                            echo "<td>Sin alumno asignado";
                            echo "<br><form action='asignar.php' method='POST'><button type='submit' class='btn-eliminar' name='periferico' value='" . $row['idPeriferico'] . "'>ASIGNAR</button></form></td>";
                        }
                        echo "<td>" . $row['num_serie'] . "</td>";
                        echo "<td>" . $row['modelo'] . "</td>";
                        echo "<td>" . $row['marca'] . "</td>";
                        if (empty($tipo)) {
                            echo "<td></td>";
                        }
                        echo "<td>" . $row['estado'];
                        if ($rolUsuario == 'admin') {
                            echo "<br><form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' type='submit' name='estado_periferico' value='" . $row['idPeriferico'] . "'>cambiar estado</button></form></td>";
                            echo "<td><form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' type='submit' name='periferico' value='" . $row['idPeriferico'] . "'>ELIMINAR</button></form></td>";
                        } else {
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                }
            }
        } else {
            $resultado = mysqli_query($conn, $sql);
            if (mysqli_num_rows($resultado) > 0) {
                while ($row = mysqli_fetch_assoc($resultado)) {
                    $sql .= " AND idOrdenador = '" . $row['fk_idOrdenador_alumno'] . "'";
                    $sql_tipo = "SELECT * FROM tipo_periferico WHERE id_tipo_periferico = '" . $row['fk_id_tipo_periferico'] . "'";
                    $resul_tipo = mysqli_query($conn, $sql_tipo);
                    if (mysqli_num_rows($resul_tipo) > 0) {
                        $row_tipo = mysqli_fetch_assoc($resul_tipo);
                        echo "<td>" . htmlspecialchars($row_tipo['tipo']) . "</td>";
                    }
                    echo "<td>" . htmlspecialchars($row['numero']) . "</td>";
                    $sql_aula = "SELECT * FROM aulas WHERE idAula = '" . $row['fk_idAula'] . "'";
                    $resultado_aula = mysqli_query($conn, $sql_aula);
                    if (mysqli_num_rows($resultado_aula) > 0) {
                        $row_aula = mysqli_fetch_assoc($resultado_aula);
                        echo "<td>" . $row_aula['aula'] . "</td>";
                    } else {
                        echo "<td>Sin aula asignada</td>";
                    }
                    $sql_alumno = "SELECT * FROM alumnos WHERE idAlumno = '" . $row['fk_idAlumno'] . "'";
                    $resultado_alumno = mysqli_query($conn, $sql_alumno);
                    if (mysqli_num_rows($resultado_alumno) > 0) {
                        $row_alumno = mysqli_fetch_assoc($resultado_alumno);
                        echo "<td>" . $row_alumno['nombre'] . " " . $row_alumno['apellidos'];
                        echo "<br><form action='asignar.php' method='POST'><button type='submit' class='btn-eliminar' name='periferico_quitar' value='" . $row['idPeriferico'] . "'>DES-ASIGNAR</button></form></td>";
                    } else {
                        echo "<td>Sin alumno asignado";
                        echo "<br><form action='asignar.php' method='POST'><button type='submit' class='btn-eliminar' name='periferico' value='" . $row['idPeriferico'] . "'>ASIGNAR</button></form></td>";
                    }
                    echo "<td>" . $row['num_serie'] . "</td>";
                    echo "<td>" . $row['modelo'] . "</td>";
                    echo "<td>" . $row['marca'] . "</td>";
                    if (empty($tipo)) {
                        echo "<td></td>";
                    }
                    echo "<td>" . $row['estado'];
                    if ($rolUsuario == 'admin') {
                        echo "<br><form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' type='submit' name='estado_periferico' value='" . $row['idPeriferico'] . "'>cambiar estado</button></form></td>";
                        echo "<td><form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' type='submit' name='periferico' value='" . $row['idPeriferico'] . "'>ELIMINAR</button></form></td>";
                    } else {
                        echo "</td>";
                    }
                    echo "</tr>";
                }
            } elseif (!empty($tipo)) {
                echo "<tr><td colspan='9'>No se encontraron resultados</td></tr>";
            }
        }
    }
?>