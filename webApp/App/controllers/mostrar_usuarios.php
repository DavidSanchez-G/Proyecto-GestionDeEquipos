<?php
echo "<table class='tabla-listado' aria-describedby='titulo-listado'>";
echo "<thead>
<tr>
<th scope='col'>Usuario</th>
<th scope='col'>Rol de usuario</th>
<th scope='col'>Nombre y apellidos</th>
<th scope='col'>Email</th>";
$rol = $_GET['rol'];
if ($rol == 'alumno') {
    echo "<th scope='col'>Aula</th>";
    echo "<th scope='col'>Ver Equipos</th>";
}
if ($rolUsuario != 'profesor') {
    echo "<th scope='col'></th>";
}
echo "</tr></thead>";
echo "<tbody>";
if ($rol == 'alumno') {
    $sql = "SELECT * FROM alumnos WHERE 1=1";
    if (!empty($_GET['nombre'])) {
        $nombre = htmlspecialchars($_GET['nombre']);
        $sql .= " AND nombre LIKE '%$nombre%'";
    }
    if (!empty($_GET['apellidos'])) {
        $apellidos = htmlspecialchars($_GET['apellidos']);
        $sql .= " AND apellidos LIKE '%$apellidos%'";
    }
    if (!empty($_GET['email'])) {
        $email = htmlspecialchars($_GET['email']);
        $sql .= " AND email = '$email'";
    }
    if (!empty($_GET['aula'])) {
        $aula = htmlspecialchars($_GET['aula']);
        $sql .= " AND fk_idAula_alumno = '$aula'";
    }
    $sql .= " ORDER BY nombre ASC";
    $alumnos = mysqli_query($conn, $sql);
    if (mysqli_num_rows($alumnos) > 0) {
        while ($alumno = mysqli_fetch_assoc($alumnos)) {
            echo "<tr>";
            $sql = mysqli_query($conn, "SELECT * FROM usuario WHERE idUsuario ='". $alumno['fk_idUsuario_alumno']. "'");
            if (mysqli_num_rows($sql) > 0) {
                while ($usuario = mysqli_fetch_assoc($sql)) {
                    echo "<td class='campo'>". $usuario['usuario'] . "</td>";
                    echo "<td class='campo'>". $usuario['rol'] . "</td>";
                }
            } else {
                echo "<td class='campo'></td>";
                echo "<td class='campo'></td>";
            }
            echo "<td class='campo'>". $alumno['nombre'] . " ". $alumno['apellidos']. "</td>";
            echo "<td class='campo'>". $alumno['email']. "</td>";
            $sql = mysqli_query($conn, "SELECT * FROM aulas WHERE idAula ='". $alumno['fk_idAula_alumno']. "'");
            if (mysqli_num_rows($sql) > 0) {
                while ($aula = mysqli_fetch_assoc($sql)) {
                    echo "<td class='campo'>". $aula['nombre_aula']. "</td>";
                }
            } else {
                echo "<td class='campo'></td>";
            }
            echo "<td><a href='portatiles_admin.php?filtro=filtrar&nombre=". $alumno['nombre']. "&apellido=". $alumno['apellidos']."'><button class='btn-eliminar'>VER EQUIPOS</button></a>";
            if ($rolUsuario == 'admin') {
                echo "<td class='campo'><form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' name='alumno' value='". $alumno['idAlumno']. "'>ELIMINAR</button></form></td>";
            }
            echo "</tr>";
        }
    } else {
        echo "<tr>";
        echo "<td class='campo' colspan='6'>No hay se han encontrado alumnos</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} elseif ($rol == 'profesor') {
    $sql = "SELECT * FROM profesor WHERE 1=1";
    if (!empty($_GET['nombre'])) {
        $nombre = htmlspecialchars($_GET['nombre']);
        $sql .= " AND nombre LIKE '%$nombre%'";
    }
    if (!empty($_GET['apellidos'])) {
        $apellidos = htmlspecialchars($_GET['apellidos']);
        $sql .= " AND apellidos LIKE '%$apellidos%'";
    }
    if (!empty($_GET['email'])) {
        $email = htmlspecialchars($_GET['email']);
        $sql .= " AND email = '$email'";
    }
    $profesores = mysqli_query($conn, $sql);
    if (mysqli_num_rows($profesores) > 0) {
        while ($profesor = mysqli_fetch_assoc($profesores)) {
            echo "<tr>";
            $sql = mysqli_query($conn, "SELECT * FROM usuario WHERE idUsuario ='". $profesor['fk_idUsuario']. "'");
            if (mysqli_num_rows($sql) > 0) {
                while ($usuario = mysqli_fetch_assoc($sql)) {
                    echo "<td class='campo'>". $usuario['usuario'] . "</td>";
                    echo "<td class='campo'>". $usuario['rol'] . "</td>";
                }
            } else {
                echo "<td class='campo'></td>";
                echo "<td class='campo'></td>";
            }
            echo "<td class='campo'>". $profesor['nombre'] . " ". $profesor['apellidos']. "</td>";
            echo "<td class='campo'>". $profesor['email']. "</td>";
            echo "<td class='campo'><form action='../../controllers/control_eliminar.php' method='POST'><button class='btn-eliminar' name='profesor' value='". $profesor['idProfesor']. "'>ELIMINAR</button></form></td>";
            echo "</tr>";
        }
    }
    echo "</tbody>";
    echo "</table>";
}
