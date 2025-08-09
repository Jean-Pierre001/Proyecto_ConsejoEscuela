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
            // Actualizar escuela
            $schoolName = trim($_POST['schoolName'] ?? '');
            $service_code = trim($_POST['service_code'] ?? '');
            $shift = trim($_POST['shift'] ?? '');
            $cue_code = trim($_POST['cue_code'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $locality = trim($_POST['locality'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $shared_building = ($_POST['shared_building'] ?? '0') === '1' ? 1 : 0;
            $category_id = intval($_POST['category_id'] ?? 0);

            // Validaciones básicas
            if (!$schoolName || !$service_code || !$shift || !$cue_code || !$address || !$locality || !$category_id) {
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
                service_code = :service_code,
                shift = :shift,
                cue_code = :cue_code,
                address = :address,
                locality = :locality,
                phone = :phone,
                email = :email,
                shared_building = :shared_building,
                category_id = :category_id
                WHERE id = :id");

            $stmt->execute([
                ':schoolName' => $schoolName,
                ':service_code' => $service_code,
                ':shift' => $shift,
                ':cue_code' => $cue_code,
                ':address' => $address,
                ':locality' => $locality,
                ':phone' => $phone,
                ':email' => $email,
                ':shared_building' => $shared_building,
                ':category_id' => $category_id,
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
            $pdo->beginTransaction();

            $delAuth = $pdo->prepare("DELETE FROM authorities WHERE school_id = :id");
            $delAuth->execute([':id' => $id]);

            $delSchool = $pdo->prepare("DELETE FROM schools WHERE id = :id");
            $delSchool->execute([':id' => $id]);

            $pdo->commit();

            $_SESSION['success'] = "Escuela y sus autoridades eliminadas correctamente.";
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
