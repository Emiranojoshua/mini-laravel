<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php require "components/nav.comp.php"; ?>

    <form action="" method="post">
        <label for="email">email</label>
        <input type="text" name="email" id="email" value="<?= old('email') ?>" placeholder="email address...">
        <?= errors('email')?>
        <label for="password">password</label>
        <input type="text" name="password" id="password" value="<?= old('password') ?>" placeholder="password...">
        <?= errors('password')?>
        <input type="submit" value="submit">
    </form>

</body>

</html>