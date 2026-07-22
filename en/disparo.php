<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<?php
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);

$nomeremetente = $_POST['nome'];
$emailremetente = $_POST['email'];
$emaildestinatario = GDEST;
$comcopia = $_POST['comcopia'];
$comcopiaoculta = $_POST['comcopiaoculta'];
$empresa = $_POST['empresa'];
$verba = $_POST['verba'];
$mensagem = $_POST['message'];

$Vai = '
	<P><i>Mensagem enviada por ' . $nomeremetente . ' - ' . $emailremetente . '</i></P>
	<p><b><i>Phone: ' . $_POST['telefone'] . '</i></b></p>
	<p><b><i>Email: ' . $_POST['email'] . '</i></b></p>	
	<p><b><i>Message: ' . $mensagem . '</i></b></p>
	<hr>';


require_once("mail/class.phpmailer.php");

// Credenciais SMTP ficam em config.php (fora do git — ver config.php.example)
require_once __DIR__ . '/../config.php';

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
    $mail->Charset = "UTF-8";
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
    $mail->isHTML(true);
	$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.titan.email';	// SMTP utilizado
	$mail->Port = 465;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->setFrom('contato@globalthea.com.br', 'Site Exato');
	
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem enviada!';
		return true;
	}
}

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
//o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

$title = utf8_decode("Contato Site Exato - en-US");

if (smtpmailer($emaildestinatario, 'contato@globalthea.com.br', $title, $title, $Vai)) {
//	Header("location:http://www.dominio.com.br/obrigado.html"); // Redireciona para uma página de obrigado.
}

//die();
echo '<script>alert("Mensagem enviada com sucesso!");</script>';
$URL = 'http://' . $_SERVER['HTTP_HOST'] . '/';
echo '<meta http-equiv="refresh" content="0; url=' . $URL. '">';
die;

?>