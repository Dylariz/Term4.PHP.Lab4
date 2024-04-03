<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Текст, который будет отправлен, если пользователь нажмет кнопку "Отмена"';
    exit;
} else {
    echo "<p>Привет, {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>Вы ввели {$_SERVER['PHP_AUTH_PW']} в качестве пароля.</p>";
}
?>