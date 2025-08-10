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
            $shared_building = trim($_POST['shared_building'] ?? ''); // varchar(255)
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

            if ($stmt->rowCount() > 0) {
                $_SESSION['success'] = "Escuela actualizada correctamente.";
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
