<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Honeypot check — bots fill hidden fields, humans don't
if (!empty($_POST['website'])) {
    echo json_encode(['success' => true]); // Silently discard
    exit;
}

// CSRF check
if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// Rate limiting — max 3 submissions per 10 minutes per session
$now = time();
$_SESSION['submissions'] = array_filter(
    $_SESSION['submissions'] ?? [],
    fn($t) => $now - $t < 600
);
if (count($_SESSION['submissions']) >= 3) {
    echo json_encode(['success' => false, 'message' => 'Too many submissions. Please try again later.']);
    exit;
}
$_SESSION['submissions'][] = $now;

// Sanitize inputs
$name    = trim(strip_tags($_POST['name'] ?? ''));
$email   = trim(strip_tags($_POST['email'] ?? ''));
$phone   = trim(strip_tags($_POST['phone'] ?? ''));
$subject = trim(strip_tags($_POST['subject'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

if (!$name || !$email || !$phone || !$message) {
    echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'mail.ecoslinksolutions.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info.ecoslinksolutions.com';
    $mail->Password   = 'YOUR_SMTP_PASSWORD';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // use ENCRYPTION_SMTPS for port 465
    $mail->Port       = 465;

    $mail->setFrom('YOUR_SMTP_USERNAME', 'Ecos Link Solutions');
    $mail->addAddress('info@ecoslinksolutions.com');
    $mail->addReplyTo($email, $name);

    $mail->Subject = $subject ?: 'Contact Form Enquiry';
    $mail->Body    = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

    $mail->send();

    // Regenerate CSRF token after successful submission
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    echo json_encode(['success' => true, 'csrf_token' => $_SESSION['csrf_token']]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again later.']);
}
