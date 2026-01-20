<?php
// send-email.php

// 1. SET YOUR EMAIL ADDRESS HERE
$to = "kyawtheinaero@gmail.com"; 

// 2. CHECK IF REQUEST IS POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. SANITIZE & COLLECT DATA (Security First)
    $name = strip_tags(trim($_POST["name"]));
    $company = strip_tags(trim($_POST["company"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $department = strip_tags(trim($_POST["department"]));
    $message = trim($_POST["message"]);

    // 4. VALIDATION
    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo "Please complete the required fields.";
        exit;
    }

    // 5. EMAIL SUBJECT
    $subject = "New Lead: $name from $company";

    // 6. EMAIL CONTENT (HTML Format)
    $email_content = "
    <html>
    <head>
        <title>New Website Inquiry</title>
    </head>
    <body style='font-family: Arial, sans-serif;'>
        <h2 style='color: #D60000;'>New Lead from Website</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Company:</strong> $company</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Department Interest:</strong> $department</p>
        <hr>
        <p><strong>Message:</strong></p>
        <p style='background: #f4f4f4; padding: 15px;'>$message</p>
    </body>
    </html>
    ";

    // 7. HEADERS (Crucial for not going to Spam)
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Landa General Trading <noreply@landamyanmar.com.com>" . "\r\n"; 
    $headers .= "Reply-To: $email" . "\r\n";

    // 8. SEND
    if (mail($to, $subject, $email_content, $headers)) {
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>