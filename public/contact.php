<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$pageTitle = 'Contact';
require BASE_PATH . '/src/views/header.php';
?>

<div class="section__head">
    <p class="section__eyebrow">Get in touch</p>
    <h1>Contact</h1>
    <p class="section__lede">
        Questions about how Handypost works, or about the security decisions behind
        it, are welcome.
    </p>
</div>

<dl class="contact-grid">
    <div class="contact-item">
        <dt>Email</dt>
        <dd><a href="mailto:you@example.com">you@example.com</a></dd>
    </div>

    <div class="contact-item">
        <dt>Source code</dt>
        <dd><a href="https://github.com/yourusername/handypost">github.com/yourusername/handypost</a></dd>
    </div>

    <div class="contact-item">
        <dt>Location</dt>
        <dd>Kampala, Uganda</dd>
    </div>
</dl>

<?php require BASE_PATH . '/src/views/footer.php'; ?>