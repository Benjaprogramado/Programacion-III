<?php

require_once "./usuario.php";
require_once "./precios.php";
// require_once "./profesor.php";
// require_once "./asignacion.php";
require_once "./jwt.php";

require __DIR__ . '/vendor/autoload.php';
//composer require firebase/php-jwt
//use \Firebase\JWT\JWT;

$method = $_SERVER["REQUEST_METHOD"];
$path_info = $_SERVER["PATH_INFO"];


switch ($method) {
    case 'POST': //AGREGA DATOS
        switch ($path_info) {
            case "/registro":

                if (isset($_POST['email']) && isset($_POST['tipo']) && isset($_POST['password'])) {

                    if (Usuario::validarEmail($_POST['email']) == true && Usuario::validarTipo($_POST['tipo']) == true) {

                        $usuario = new Usuario($_POST['email'], $_POST['tipo'], $_POST['password']);
                        if ($usuario->saveUserJson($usuario) == true) {
                            echo "Se grabo el usuario";
                        } else {
                            echo "Error al grabar el usuario";
                        }
                    } else {
                        echo "EMAIL O TIPO INVALIDOS";
                    }
                } else {
                    echo "FALTAN DATOS DEL USUARIO";
                }
                break;
            case "/login":
                if (isset($_POST['email']) && isset($_POST['password'])) {

                    $usuario = Usuario::obtenerUsuario($_POST['email'], $_POST['password']);
                    $listaDatos = Usuario::readUserJson();
                    $email = $usuario->_email;
                    $tipo = $usuario->_tipo;

                    foreach ($listaDatos as $dato) {
                        if ($dato->_email == $email && $dato->_tipo == $tipo) {
                            $payload = array(
                                "email" => $email,
                                "tipo" => $tipo
                            );
                            $token = Token::generarToken($payload);
                            echo "SU TOKEN SE CREO CORRECTAMENTE";
                            var_dump($token);
                            return $token;
                        } else {
                            echo "EMAIL O TIPO INCORRECTOS";
                            return false;
                        }
                    }
                } else {
                    echo "FALTAN DATOS DEL USUARIO";
                }

                break;
            case "/precio":
                if (isset($_POST['precio_hora']) && isset($_POST['precio_estadia']) && isset($_POST['precio_mensual'])) {

                    $token = Token::decifrarToken($_SERVER['HTTP_TOKEN']);
                    // var_dump($token);
                    // die();
                    if ((Usuario::esAdmin($token->_tipo)) == true) {

                        $listaPrecios = Precio::readPrecioJson();
                        $precio = new Precio($_POST['precio_hora'], $_POST['precio_estadia'], $_POST['precio_mensual']);
                        Precio::savePrecioJson($precio);
                        echo "Se grabo lista de precios";
                    } else {
                        echo ("Usuario no autorizado");
                    }
                } else {
                    echo "FALTAN DATOS DE PRECIOS";
                }
                break;

            case "/ingreso":
                // if (isset($_POST['legajo']) && isset($_POST['nombre'])) {
                //     $profesor = new Profesor($_POST['legajo'], $_POST['nombre']);
                //     $listaDatos = Profesor::readProfeJson();
                //     $legajo = $profesor->_legajo;
                //     $nombre = $profesor->_nombre;

                //     if (empty($listaDatos)) {
                //         Profesor::saveProfeJson($profesor);
                //         echo "Se grabo el profesor";
                //         return true;
                //     } else {
                //         foreach ($listaDatos as $dato) {
                //             //echo "entro a foreach";
                //             if ($dato->_legajo == $legajo) {
                //                 echo "El profesor no se puede repetir";
                //                 return false;
                //             } else {
                //                 Profesor::saveProfeJson($profesor);
                //                 echo "Se grabo el profesor";
                //                 return true;
                //             }
                //         }
                //     }
                // } else {
                //     echo "FALTAN DATOS DEL INGRESO";
                // }

                break;
            case "/ingreso":
                // if (isset($_POST['legajo']) && isset($_POST['id']) && isset($_POST['turno'])) {
                //     $legajo = $_POST['legajo'];
                //     $id = $_POST['id'];
                //     $turno = $_POST['turno'];
                //     // var_dump($id);
                //     // var_dump($legajo);
                //     // die();

                //     if (Materia::verificarMateria($id) == true && Profesor::verificarProfesor($legajo) == true) {

                //         $asignacion = new Asignacion($_POST['legajo'], $_POST['id'], $_POST['turno']);
                //         $listaDatos = Asignacion::readAsignacionJson();
                //         if (empty($listaDatos)) {
                //             Asignacion::saveAsignacionJson($asignacion);
                //             echo "PRIMER ASIGNACION CORRECTA";
                //             return true;
                //         } else {
                //             $aux = false;
                //             foreach ($listaDatos as $yaAsignada) {
                //                 if ($yaAsignada->_legajo == $asignacion->_legajo && $yaAsignada->_id == $asignacion->_id && $yaAsignada->_turno == $asignacion->_turno) {
                //                     echo "NO SE PUEDEN REPETIR ASIGNACIONES";
                //                     $aux = true;
                //                     return false;
                //                 }
                //             }
                //             if ($aux == false) {
                //                 Asignacion::saveAsignacionJson($asignacion);
                //                 echo "ASIGNACION CORRECTA";
                //                 return true;
                //             }
                //         }
                //     }
                // } else {
                //     echo "FALTAN DATOS PARA LA ASIGNACION";
                // }

                break;
            default:
                # code...
                break;
            case "/retiro":
                break;
        }
        break;
    case 'GET': //LISTA RECURSOS
        switch ($path_info) {
                // case '/materia':
                //     $materias = Materia::readMateriaJson();
                //     echo "MATERIAS: ";
                //     foreach ($materias as $item) {
                //         $m = new Materia($item->_id, $item->_nombre, $item->_cuatrimestre);
                //         echo "\n ID: " . $m->_id . "  NOMBRE: " . $m->_nombre . "  CUATRIMESTRE: " . $m->_cuatrimestre;
                //     }
                //     break;
                // case '/profesor':
                //     $profesores = Profesor::readProfeJson();
                //     echo "PROFESORES: <br>";
                //     foreach ($profesores as $item) {
                //         $p = new Profesor($item->_legajo, $item->_nombre);
                //         echo "\n LEGAJO: " . $p->_legajo . "  NOMBRE: " . $p->_nombre;
                //     }
                //     break;
                // case '/asignacion':
                //     $profesores = Profesor::readProfeJson();
                //     $materias = Materia::readMateriaJson();
                //     $asignaciones = Asignacion::readAsignacionJson();

                //     foreach ($asignaciones as $asignacion) {
                //         $texto = "Turno: $asignacion->_turno \n";
                //         foreach ($profesores as $profesor) {
                //             if ($profesor->_legajo == $asignacion->_legajo) {
                //                 $p = new Profesor($profesor->_legajo, $profesor->_nombre);
                //                 $texto = $texto . "PROFESOR: " . $p;
                //             }
                //         }

                //         foreach ($materias as $materia) {
                //             if ($materia->_id == $asignacion->_id) {
                //                 $m = new Materia($materia->_id, $materia->_nombre, $materia->_cuatrimestre);
                //                 $texto = $texto . "MATERIA: " . $m;
                //             }
                //         }
                //         echo $texto . PHP_EOL;
                //     }
                // break;

            default:
                # code...
                break;
        }
        # code...
        break;
    case 'PUT': //MODIFICA RECURSOS
        # code...
        break;
    case 'DELETE': //BORRA RECURSOS
        # code...
        break;

    default:
        # code...
        break;
}
