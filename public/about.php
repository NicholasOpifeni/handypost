<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$pageTitle = 'About';
require BASE_PATH . '/src/views/header.php';
?>

<div class="prose">
    <h1>About Handypost</h1>

    <p>
        Handypost is a small authentication system for teams who need users to be
        able to sign up, log in and manage their own details, without taking on a
        large framework to do it.
    </p>

    <h2>Why it exists</h2>

    <p>
        Authentication is the part of a web application that gets written quickly
        and reviewed rarely. It is also the part where a mistake costs the most.
        Most of the login code circulating in tutorials and starter templates
        contains the same handful of flaws: queries assembled from user input,
        passwords stored in a form the database can read back, session identifiers
        that never change, and pages that redirect without stopping.
    </p>

    <p>
        Handypost was built by working through those failures one at a time and
        fixing each properly, rather than reaching for a framework that hides them.
        The result is a codebase small enough to read in an afternoon.
    </p>

    <h2>What it does</h2>

    <p>
        Account creation with server-side validation. Login that behaves identically
        whether or not an account exists, so nobody can use it to discover which
        email addresses are registered. Session handling with hardened cookies and
        identifier rotation at every point where the security context changes.
        Profile editing where changing your name does not disturb your password.
    </p>

    <h2>What it does not do</h2>

    <p>
        There is no password reset, because that needs email delivery and its own
        threat model. There is no rate limiting yet, which would need a persistent
        store rather than the session. There is no email verification and no
        "remember me". These are listed openly rather than quietly omitted.
    </p>

    <h2>Where it comes from</h2>

    <p>
        Built and maintained in Kampala, Uganda. The whole thing is plain PHP and
        MySQL with no framework, no build step, and no third-party JavaScript. Every
        page loads from your own server and nothing else.
    </p>
</div>

<?php require BASE_PATH . '/src/views/footer.php'; ?>