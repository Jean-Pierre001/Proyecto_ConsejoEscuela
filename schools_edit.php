<?php
include 'includes/session.php';
include 'includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    if (!$id) {
        $_SESSION['error'] = "ID inválido.";
        header('Location: schools.php');
        exit;
    }

    try {
        if (isset($_POST['update'])) {
            // Recibir datos del formulario
            $schoolName = trim($_POST['schoolName'] ?? '');
            $category_id = intval($_POST['category_id'] ?? 0);
            $is_disadvantaged = ($_POST['is_disadvantaged'] ?? '0') === '1' ? 1 : 0;
            $shift = trim($_POST['shift'] ?? '');
            $service_code = trim($_POST['service_code'] ?? '');
            $shared_building = trim($_POST['shared_building'] ?? '');
            $cue_code = trim($_POST['cue_code'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $locality = trim($_POST['locality'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');

            // Validaciones básicas
            if (!$schoolName || !$category_id || !$shift || !$service_code || !$cue_code || !$address || !$locality) {
                $_SESSION['error'] = "Complete todos los campos obligatorios.";
                header('Location: schools.php');
                exit;
            }
            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email inválido.";
                header('Location: schools.php');
                exit;
            }

            // Obtener el nombre original de la escuela antes de actualizar
            $stmt = $pdo->prepare("SELECT schoolName FROM schools WHERE id = ?");
            $stmt->execute([$id]);
            $school = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$school) {
                $_SESSION['error'] = "Escuela no encontrada.";
                header('Location: schools.php');
                exit;
            }

            // Obtener nombre de la categoría actual
            $stmtCatOld = $pdo->prepare("SELECT c.name FROM schools s JOIN categories c ON s.category_id = c.id WHERE s.id = ?");
            $stmtCatOld->execute([$id]);
            $oldCategoryName = $stmtCatOld->fetchColumn();

            if (!$oldCategoryName) {
                $_SESSION['error'] = "Categoría actual no encontrada.";
                header('Location: schools.php');
                exit;
            }

            // Obtener nombre de la categoría nueva
            $stmtCatNew = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
            $stmtCatNew->execute([$category_id]);
            $newCategoryName = $stmtCatNew->fetchColumn();

            if (!$newCategoryName) {
                $_SESSION['error'] = "Categoría nueva no encontrada.";
                header('Location: schools.php');
                exit;
            }

            // Actualizar escuela en la base de datos
            $stmt = $pdo->prepare("UPDATE schools SET 
                schoolName = :schoolName,
                category_id = :category_id,
                is_disadvantaged = :is_disadvantaged,
                shift = :shift,
                service_code = :service_code,
                shared_building = :shared_building,
                cue_code = :cue_code,
                address = :address,
                locality = :locality,
                phone = :phone,
                email = :email
                WHERE id = :id");

            $stmt->execute([
                ':schoolName' => $schoolName,
                ':category_id' => $category_id,
                ':is_disadvantaged' => $is_disadvantaged,
                ':shift' => $shift,
                ':service_code' => $service_code,
                ':shared_building' => $shared_building,
                ':cue_code' => $cue_code,
                ':address' => $address,
                ':locality' => $locality,
                ':phone' => $phone,
                ':email' => $email,
                ':id' => $id
            ]);

            // --- Lógica para renombrar/mover carpeta en uploads ---
            $baseDir = __DIR__ . '/uploads/';

            $oldFolder = $baseDir . $oldCategoryName . DIRECTORY_SEPARATOR . $school['schoolName'];
            $newFolder = $baseDir . $newCategoryName . DIRECTORY_SEPARATOR . $schoolName;

            if (is_dir($oldFolder)) {
                // Crear carpeta de la nueva categoría si no existe
                if (!is_dir($baseDir . $newCategoryName)) {
                    mkdir($baseDir . $newCategoryName, 0777, true);
                }

                // Renombrar/mover solo si cambió el nombre o la categoría
                if ($oldFolder !== $newFolder) {
                    if (!file_exists($newFolder)) {
                        if (!rename($oldFolder, $newFolder)) {
                            $_SESSION['error'] = "Escuela actualizada, pero no se pudo renombrar la carpeta.";
                            header('Location: schools.php');
                            exit;
                        }
                    } else {
                        $_SESSION['error'] = "Escuela actualizada, pero ya existe una carpeta con el nuevo nombre y categoría.";
                        header('Location: schools.php');
                        exit;
                    }
                }
            }

            if ($stmt->rowCount() > 0) {
                $_SESSION['success'] = "Escuela y carpeta actualizadas correctamente.";
            } else {
                $_SESSION['info'] = "No hubo cambios para actualizar.";
            }
            header('Location: schools.php');
            exit;
        }

        if (isset($_POST['delete_school'])) {
            // Código para eliminar la escuela (opcional)
            $stmt = $pdo->prepare("DELETE FROM schools WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $_SESSION['success'] = "Escuela eliminada correctamente.";
            header('Location: schools.php');
            exit;
        }
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
        header('Location: schools.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = "Error inesperado: " . $e->getMessage();
        header('Location: schools.php');
        exit;
    }
}

header('Location: schools.php');
exit;
