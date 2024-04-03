<?php
// Функция для проверки корректности формата файла
function verifyFile($filePath) {
    $file = file_get_contents($filePath);
    $lines = explode("\n", $file);
    foreach ($lines as $line) {
        if (rtrim($line) != '' && count(explode(':', $line)) != 3) {
            return false;
        }
    }
    return true;
    
}

// Поиск всех файлов с данными пользователей в подпапках
function getAllFiles() {
    $userFiles = [];
    $directory = './';
    $files = glob($directory . '*.txt');
    foreach ($files as $filePath) {
        if (verifyFile($filePath)) {
            $userFiles[] = [$filePath, explode("\n", file_get_contents($filePath))];
        }
    }
    
    return $userFiles;
}

// Функция для получения данных пользователя из верифицированных файлов
function getUserData($username) {
    $files = getAllFiles();
    foreach ($files as $file) {
        list($filePath, $fileData) = $file;
        foreach ($fileData as $line) {
            $decomposedLine = explode(':', $line);
            if (count($decomposedLine) != 3) {
                continue;
            }
            list($user, $password, $keyword) = $decomposedLine;
            $keyword = rtrim($keyword);
            if ($user == $username) {
                return array('username' => $user, 'password' => $password, 'keyword' => $keyword);
            }
        }
    }
    return null;
}

// Функция для изменения пароля пользователя
function changePassword($username, $newPassword) {
    $files = getAllFiles();
    foreach ($files as $file) {
        list($filePath, $fileData) = $file;
        foreach ($fileData as &$line) {
            $decomposedLine = explode(':', $line);
            if (count($decomposedLine) != 3) {
                continue;
            }
            list($user, $password, $keyword) = $decomposedLine;
            if ($user == $username) {
                $line = $user . ':' . $newPassword . ':' . $keyword;
            }
        }
        file_put_contents($filePath, implode("\n", $fileData));
    }
}

// Проверка имени пользователя и пароля
if (isset($_POST['username']) && isset($_POST['password'])) {
    $userData = getUserData($_POST['username']);
    if ($userData) {
        if ($_POST['password'] == $userData['password']) {
            echo "Вы успешно вошли в систему!";
        } else {
            if (isset($_POST['keyword']) && $_POST['keyword'] == $userData['keyword']) {
                echo "Ваш пароль: " . $userData['password'];
            } else {
                echo "Неправильный пароль!";
            }
        }
    } else {
        echo "Неправильное имя пользователя!";
    }
}

// Изменение пароля
if (isset($_POST['username']) && isset($_POST['keyword']) && isset($_POST['newPassword'])) {
    $userData = getUserData($_POST['username']);
    if ($userData && $_POST['keyword'] == $userData['keyword']) {
        changePassword($_POST['username'], $_POST['newPassword']);
        echo "Пароль успешно изменен!";
    } else {
        echo "Неправильное имя пользователя или ключевое слово!";
    }
}
?>