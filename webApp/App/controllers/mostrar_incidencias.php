<?php
echo "<table class='tabla-listado' aria-describedby='titulo-listado'>";
echo "<thead>
<tr>
<th scope='col'>Ticket</th>
<th scope='col'>Nº de ticket</th>
<th scope='col'>Fecha</th>
<th scope='col'>Alumno</th>
<th scope='col'>Equipo</th>
<th scope='col'>Estado</th>";
if ( $rolUsuario == 'admin') {
    echo "<th scope='col'></th>";
}
echo "</tr>
</thead>";
echo "<tbody>";
$sql = "SELECT * FROM mantenimiento WHERE 1=1";
if (!empty($_GET['num_ticket'])) {
    $num_ticket = htmlspecialchars($_GET['num_ticket']);
    $sql .= " AND num_ticket = $num_ticket";
}
if (!empty($_GET['fecha'])) {
    $fecha = htmlspecialchars($_GET['fecha']);
    $sql .= " AND fecha = '$fecha'";
}
if (!empty($_GET['estado'])) {
    $estado = htmlspecialchars($_GET['estado']);
    $sql .= " AND estado = '$estado'";
}
if (!empty($_GET['tipo'])) {
    $tipo = htmlspecialchars($_GET['tipo']);
    $sql .= " AND tipo = '$tipo'";

}
$tickets = mysqli_query($conn, $sql);
if (mysqli_num_rows($tickets) > 0) {
    while ($row = mysqli_fetch_assoc($tickets)) {
        echo "<tr>";
        echo "<td class='campo'>" . $row['tipo'] . "</td>";
        echo "<td class='campo'>" . $row['num_ticket'] . "</td>";
        echo "<td class='campo'>" . $row['fecha'] . "</td>";
        $idAlumno= htmlspecialchars($row['fk_idAlumno']);
        $sql_alumno = mysqli_query($conn, "SELECT * FROM alumnos WHERE idAlumno = '$idAlumno' ");
        if (mysqli_num_rows($sql_alumno) > 0) {
            $row_alumno = mysqli_fetch_assoc($sql_alumno);
            echo "<td class='campo'>" . $row_alumno['nombre'] . " ". $row_alumno['apellidos']. "</td>";
        }
        if (isset($row['fk_idOrdenador'])) {
            $idEquipo= htmlspecialchars($row['fk_idOrdenador']);
            $sql_equipo = mysqli_query($conn, "SELECT * FROM ordenadores WHERE idOrdenador = '$idEquipo' ");
            if (mysqli_num_rows($sql_equipo) > 0) {
                $row_equipo = mysqli_fetch_assoc($sql_equipo);
                $sql_aula = mysqli_query($conn,"SELECT * FROM aulas WHERE idAula = '{$row_equipo['fk_idAula']}' ");
                if (mysqli_num_rows($sql_aula) > 0) {
                    $row_aula = mysqli_fetch_assoc($sql_aula);
                    echo "<td class='campo'>Ordenador: " . $row_equipo['modelo']. $row_equipo['numero']. " ". $row_aula['nombre_aula'] . "</td>";
                } else {
                    echo "<td class='campo'>Ordenador: ". $row_equipo['modelo']. "</td>";
                }
            } else {
                echo "<td></td>";
            }
        } elseif (isset($row['fk_idPeriferico'])) {
            $idEquipo= htmlspecialchars($row['fk_idPeriferico']);
            $sql_equipo = mysqli_query($conn, "SELECT * FROM perifericos WHERE idPeriferico = '$idEquipo' ");
            if (mysqli_num_rows($sql_equipo) > 0) {
                $row_equipo = mysqli_fetch_assoc($sql_equipo);
                $sql_tipo = mysqli_query($conn, "SELECT * FROM tipo_perifericos WHERE id_tipo_periferico = '{$row_equipo['fk_id_tipo_periferico']}' ");
                if (mysqli_num_rows($sql_tipo) > 0) {
                    $row_tipo = mysqli_fetch_assoc($sql_tipo);
                } else {
                    $row_tipo['tipo']= "";
                }
                $sql_aula = mysqli_query($conn,"SELECT * FROM aulas WHERE idAula = '{$row_equipo['fk_idAula']}' ");
                if (mysqli_num_rows($sql_aula) > 0) {
                    $row_aula = mysqli_fetch_assoc($sql_aula);
                } else {
                    $row_aula['nombre_aula'] = "";
                }
                echo "<td class='campo'>". $row_tipo['tipo']. $row_equipo['modelo']. " ". $row_equipo['numero']. $row_aula['nombre_aula']. "</td>";
            } else {
                echo "<td class='campo'></td>";
            }
        } else {
            echo "<td class='campo'></td>";
        }
        echo "<td class='campo'>". $row['estado']. "</td>";
        if ($rolUsuario == 'admin') {
            echo "<td class='campo'><form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' type='submit' name='solucionar' value='". $row['idMantenimiento']."'>Solucionada</button></form></td>";
        }
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' class='campo'>Descripción del ticket</td>";
        echo "<td colspan='4' class='campo'>".$row['descripcion']."</td>";
        if ($rolUsuario == 'admin') {
            echo "<td class='campo'><form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' name='pendiente' value='". $row['idMantenimiento']."'>Marcar pendiente</button></form></td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr>";
    echo "<td colspan='7' class='campo'>No se encontraron tickets</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

