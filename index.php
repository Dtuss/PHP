<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["id_user"];
if (isset($_POST["tambah_tugas"])) {
    $isi_tugas = htmlspecialchars($_POST["tugas"]);
    mysqli_query($conn, "INSERT INTO tugas (id_user, isi_tugas) VALUES ('$user_id', '$isi_tugas')");
    header("Location: index.php");
    exit;
}
if (isset($_GET["hapus"])) {
    $hapus_id = intval($_GET["hapus"]);
    mysqli_query($conn, "DELETE FROM tugas WHERE id = $hapus_id AND id_user = $user_id");
    header("Location: index.php");
    exit;
}
if (isset($_GET["selesai"])) {
    $selesai_id = intval($_GET["selesai"]);
    mysqli_query($conn, "UPDATE tugas SET status = 'Sudah Selesai' WHERE id = $selesai_id AND id_user = $user_id");
    header("Location: index.php");
    exit;
}
$tugas = mysqli_query($conn, "SELECT * FROM tugas WHERE id_user = '$user_id' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f8f8;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding-top: 60px;
            position: relative;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
        }
        
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 30px;
            width: 400px;
            text-align: center;
        }

        .input-section {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 14px;
        }

        button {
            padding: 10px 15px;
            font-size: 14px;
            cursor: pointer;
            background-color: #4CB4E4;
            border: none;
            color: white;
            border-radius: 4px;
        }
        button:hover {
            background: #67E3FF;
        }

        .todo-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .todo-text {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            margin-right: 10px;
            border-radius: 4px;
            text-align: left;
        }
    </style>
</head>
<body>

<br><br>

<div class="container">
    <h2>Tugas Anda</h2>
    <form action="" method="post" class="input-section">
        <input type="text" name="tugas" placeholder="Tugas..." required>
        <button type="submit" name="tambah_tugas">Tambah</button>
    </form>

    <div id="todo-list">
    <?php while($row = mysqli_fetch_assoc($tugas)) : ?>
        <div class="todo-item">
            <div class="todo-text <?= $row["status"] === "Sudah Selesai" ? 'done' : '' ?>">
                <?= htmlspecialchars($row["isi_tugas"]) ?>
                <small style="display:block; font-size:12px; color:<?= $row["status"] === "Sudah Selesai" ? 'green' : 'orange' ?>">
                    Status: <?= $row["status"] ?>
                </small>
            </div>
            
            <?php if ($row["status"] !== "Sudah Selesai") : ?>
                <a href="?selesai=<?= $row["id"] ?>" onclick="return confirm('Ingin Menyelesaikan Tugas?')">
                    <button>Selesai</button>
                </a>
            <?php endif; ?>

            <a href="?hapus=<?= $row["id"] ?>" onclick="return confirm('Yakin hapus?')">
                <button style="background:#dc3545;">Hapus</button>
            </a>
        </div>
    <?php endwhile; ?>
    </div>


<script>
function selesaiTugas(id) {
    const textEl = document.getElementById('text-' + id);
    textEl.classList.toggle('done');
}
</script>

<style>
.done {
    text-decoration: line-through;
    color: gray;
}
</style>
</div>
<header style="
    width: 100%;
    background-color: #f0f0f0;
    padding: 10px 0;
    position: fixed;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <div style="
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="foto.jpg" alt="Foto Profil" style="width: 35px; height: 35px; border-radius: 50%;">
            <span style="font-weight: bold;">Benedictus Ditus Atmarestanto [235314007]</span>
        </div>

        <a href="login.php" style="
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;">
            Logout
        </a>
    </div>
</header>


</body>
</html>
