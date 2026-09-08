# Handypost

A PHP/MySQL authentication system written from scratch, without a framework.

Signup, login, session management and profile editing, built to demonstrate
correct handling of the things authentication code usually gets wrong.

![Login screen](docs/login.png)

## Background

I started by reading an existing open-source PHP login system and auditing
it. It had SQL injection in every query, stored plaintext passwords on
profile update, leaked protected pages through redirects that never called
exit, and had no output escaping or CSRF protection.

Rather than patch it, I rebuilt it from scratch so I understood every line.

## Security properties

| Concern | Approach |
|---|---|
| SQL injection | PDO prepared statements, `EMULATE_PREPARES` disabled |
| Password storage | `password_hash` with `PASSWORD_DEFAULT` (bcrypt) |
| XSS | All output escaped with `htmlspecialchars`, `ENT_QUOTES` |
| CSRF | Per-session token, `hash_equals` comparison, `SameSite=Lax` |
| Session fixation | `session_regenerate_id(true)` at login and password change |
| Session theft | `HttpOnly` and `Secure` cookie flags |
| User enumeration | Identical message and timing for all login failures |
| Credential exposure | Config outside the web root and gitignored |
| Duplicate accounts | Unique index on `email`, SQLSTATE 23000 handled |
| Supply chain | No CDN, no third-party JavaScript, no external requests |

## What this project demonstrates

Each item fixes a specific vulnerability found while auditing an existing
open-source login system.

**Prepared statements.** Every query is parameterised with PDO and
`ATTR_EMULATE_PREPARES` disabled, so MySQL parses the SQL before any value
exists. The original interpolated user input into query strings, making the
login form a straight authentication bypass.

**Bcrypt hashing.** Passwords go through `password_hash` with
`PASSWORD_DEFAULT`. The hash is never sent to the browser. The original
pre-filled its profile form with the stored hash and wrote whatever came back
into the database unhashed, which locked accounts out permanently.

**Session hardening.** Session IDs are regenerated at login and on password
change, closing session fixation. Cookies are set HttpOnly, Secure and
SameSite=Lax before the session starts.

**CSRF tokens.** Every state-changing request carries a per-session token
compared with `hash_equals`, which is constant-time and so does not leak
information through response timing.

**Output escaping.** All user-supplied data is escaped at the point of
rendering with `ENT_QUOTES` set, closing stored XSS via the username field.

**No user enumeration.** Login failures return an identical message whether or
not the account exists, and verify against a decoy hash when it does not, so
the response time does not reveal which emails are registered.

## Structure

Only `public/` is web-reachable. Application code and configuration sit
outside the document root, so no misconfiguration can serve them as text.

guardpost/
├── config/
│   ├── config.example.php      
│   └── config.php              # Gitignored. 
├── database/
│   └── schema.sql              
├── public/                     
│   ├── index.php
│   ├── signup.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   ├── profile.php
│   └── assets/
│       └── css/app.css
├── src/                       
│   ├── bootstrap.php
│   ├── helpers.php
│   ├── database.php
│   ├── csrf.php
│   ├── validation.php
│   ├── users.php
│   ├── auth.php
│   └── views/
│       ├── header.php
│       └── footer.php
├── tests/
│   └── ValidationTest.php
├── docs/                       # Screenshots for the README
├── .gitignore
├── composer.json
├── phpunit.xml.dist
├── LICENSE
└── README.md

## Running locally

    git clone https://github.com/NicholasOpifeni/handypost.git
    cd handypost
    cp config/config.example.php config/config.php
    # edit config/config.php with your database credentials
    mysql -u root -p < database/schema.sql
    php -S localhost:8000 -t public

Then open http://localhost:8000

## Tests

    composer install
    ./vendor/bin/phpunit

Validation logic is written as pure functions with no database or session
dependency, so it can be unit tested without any test infrastructure.

## Known limitations

Deliberately out of scope, and what I'd add next:

- No password reset flow (requires email delivery)
- No rate limiting on login attempts (needs a persistent store, not the session)
- No email verification on signup
- No "remember me" tokens

## Credit

The audit that started this project was of [original repo and author],
MIT licensed. This implementation is my own.

## Licence

MIT