<?php include 'app/views/shares/header.php'; ?>

<?php
if (isset($errors)) {
    echo "<ul>";
    foreach ($errors as $err) {
        echo "<li class='text-danger'>$err</li>";
    }
    echo "</ul>";
}
?>

<div class="card-body p-5 text-center">
<form action="/webbanhang/account/save" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <br>

    <label for="fullname">Full Name:</label>
    <input type="text" name="fullname" id="fullname" required>
    <br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>

    <label for="confirmpassword">Confirm Password:</label>
    <input type="password" name="confirmpassword" id="confirmpassword" required>
    <br>

    <label for="role">Role:</label>
    <select name="role" id="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    <br>

    <button type="submit">Register</button>
</form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
