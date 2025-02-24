<?php
require '../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../assets/vendor/PHPMailer/src/SMTP.php';
require '../assets/vendor/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$receiving_email_address = 'contato@thiagomacedo.com.br';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtém os dados do formulário enviado pelo usuário
        $from_name = $_POST['name'];
        $from_email = $_POST['email'];
        $from_company = $_POST['company'];
        $from_phone = $_POST['phone'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Cria uma instância do objeto PHPMailer
        $mail = new PHPMailer(true);

        // Define o conjunto de caracteres para UTF-8
        $mail->CharSet = 'UTF-8';

        // Configuração do SMTP
        $mail->isSMTP();
        $mail->Host       = 'mail.thiagomacedo.com.br'; // Insira o endereço do servidor SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'site.contato@thiagomacedo.com.br'; // Insira o e-mail de autenticação
        $mail->Password   = '@SITE@thiago95macedo'; // Insira a senha de autenticação
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465; // Insira a porta do servidor SMTP

        // Define o remetente e destinatário do e-mail
        $mail->setFrom('site.contato@thiagomacedo.com.br', $from_name);
        $mail->addAddress($receiving_email_address);

        // Monta o corpo do e-mail
        $email_body = "Nome: $from_name\n";
        $email_body .= "E-mail: $from_email\n";
        $email_body .= "Empresa: $from_company\n";
        $email_body .= "Telefone: $from_phone\n";
        $email_body .= "Assunto: $subject\n";
        $email_body .= "Mensagem: $message\n";

        // Define o assunto e corpo do e-mail
        $mail->Subject = "CONTATO WEBSITE | " . $subject;
        $mail->Body    = $email_body;

        // Envia o e-mail
        $mail->send();
        // Envio bem-sucedido
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        // Trata qualquer exceção ou erro ao enviar o e-mail
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erro ao enviar o e-mail.']);
    }
} else {
    // Se não for uma solicitação POST, retorna erro
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Método de solicitação inválido.']);
}
?>
