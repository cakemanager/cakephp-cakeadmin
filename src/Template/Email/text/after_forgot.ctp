Hello <?= $user->email ?>,

You've got this e-mail because you lost your password at <?= $baseUrl ?>.
Via the following url you will be able to set a new password: <?= $resetUrl ?>.

After you've chosen your new password you are able to login at: <?= $loginUrl ?>.

If you didn't request a new password, you can ignore this e-mail and continue your account at <?= $baseUrl ?>.

Greetz,

<?= $baseUrl ?>
