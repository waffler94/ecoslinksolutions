<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ );
$dotenv->load();

session_start();

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

function base_url() {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'];
    $dir    = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    return "$scheme://$host$dir";
}

function respond($isAjax, $success, $message = '') {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
    } else {
        $_SESSION['form_flash'] = ['success' => $success, 'message' => $message];
        header('Location: ' . base_url() . '/#contact-us');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    respond($isAjax, false, 'Method not allowed');
}

// CSRF check
if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
    http_response_code(403);
    respond($isAjax, false, 'Invalid request.');
}

// Rate limiting — max 3 submissions per 10 minutes per session
$now = time();
$_SESSION['submissions'] = array_filter(
    $_SESSION['submissions'] ?? [],
    fn($t) => $now - $t < 600
);
if (count($_SESSION['submissions']) >= 3) {
    respond($isAjax, false, 'Too many submissions. Please try again later.');
}
$_SESSION['submissions'][] = $now;

// Sanitize inputs
$name    = trim(strip_tags($_POST['name'] ?? ''));
$email   = trim(strip_tags($_POST['email'] ?? ''));
$phone   = trim(strip_tags($_POST['phone'] ?? ''));
$subject = trim(strip_tags($_POST['subject'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

$missing = [];
if (!$name)    $missing[] = 'Name';
if (!$email)   $missing[] = 'Email';
if (!$phone)   $missing[] = 'Phone Number';
if (!$message) $missing[] = 'Message';
if ($missing) {
    respond($isAjax, false, 'Missing required fields: ' . implode(', ', $missing) . '.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond($isAjax, false, 'Invalid email address.');
}

$mail = new PHPMailer(true);

// Brevo SMTP credentials

try {

    function env( $key, $default = null ) {
        return $_ENV[ $key ] ?? $default;
    }

    $mail->isSMTP();
    $mail->SMTPDebug  = 2;
    $mail->Debugoutput = 'error_log';

    $mail->Host       = env( 'MAIL_HOST', 'smtp-relay.brevo.com' );
    $mail->SMTPAuth   = true;
    $mail->Username   = env( 'BREVO_SMTP_USER' );
    $mail->Password   = env( 'BREVO_SMTP_KEY' );
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = env( 'MAIL_PORT', 587 );

    $mail->setFrom(
        env( 'MAIL_FROM' ),
        env( 'MAIL_FROM_NAME' )
    );

    $mail->addAddress( env( 'MAIL_TO' ) );
    $mail->addReplyTo( $email, $name );

    $mail->Subject = $subject ?: 'Contact Form Enquiry';
    $mail->Body    = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

    $mail->send();

    $_SESSION['csrf_token'] = bin2hex( random_bytes( 32 ) );

    if ( $isAjax ) {
        header( 'Content-Type: application/json' );
        echo json_encode( [
            'success' => true,
            'csrf_token' => $_SESSION['csrf_token']
        ] );
        exit;
    } else {
        $_SESSION['form_flash'] = [
            'success' => true,
            'message' => 'Thanks for your submission, we will be in touch shortly.'
        ];
        header( 'Location: ' . base_url() . '/#contact-us' );
        exit;
    }

} catch (Exception $e) {
    respond($isAjax, false, 'Mailer error: ' . $e->getMessage());
}
