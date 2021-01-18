<?php  
  require "./bibliotecas/PHPMailer/Exception.php";
  require "./bibliotecas/PHPMailer/OAuth.php";
  require "./bibliotecas/PHPMailer/PHPMailer.php";
  require "./bibliotecas/PHPMailer/POP3.php";
  require "./bibliotecas/PHPMailer/SMTP.php";
 
  // Import PHPMailer classes into the global namespace
  // These must be at the top of your script, not inside a function
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  class Mensagem{

  	private $name = null;
  	private $email = null;
  	private $fone = null;
  	private $message = null;
    public $status = array('codigo_status' => null, 'descricao_status' => '' );

  	public function __get($attr){
  		return $this->$attr;
  	}

  	public function __set($attr, $value){
  		$this->$attr = $value;

  	}

  	public function validaCampos(){
  		if(empty($this->name)||empty($this->email)||empty($this->fone)||empty($this->message)){
  			return false;
  		}else{
  			return true;
  		}
  	}
  	  	
  	}

  	$mensagem = new Mensagem();

  	$mensagem->__set('name',$_POST['name']);
  	$mensagem->__set('email',$_POST['email']);
  	$mensagem->__set('fone',$_POST['fone']);
  	$mensagem->__set('message',$_POST['message']);

    echo "<br><br><br>";
  	if (!$mensagem->validaCampos()) {
  		# code...
  		$mensagem->status['descricao_status'] = "Erro, Preencha todos os Campos!";
      //header('Location: index.html');
  	}else{

      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);

      try {
          //Server settings
          $mail->SMTPDebug = false;                      // Enable verbose debug output
          $mail->isSMTP();                                            // Send using SMTP
          $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = 'trtecrecife@gmail.com';                     // SMTP username
          $mail->Password   = '';                               // SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
          $mail->Port       = 587;                                    // TCP port to connect to

          //Recipients
          $mail->setFrom('trtecrecife@gmail.com','Cliente');
          $mail->addAddress('trtecrecife@gmail.com','Trtec adim');     // Destinatario
              // Name is optional
          //$mail->addReplyTo('info@example.com', 'Information');
          //$mail->addCC('cc@example.com');
          //$mail->addBCC('bcc@example.com');

          // Attachments
          //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
          //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

          // Content conteúdo
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = "Mensagem do cliente";
          $mail->Body    = "<b>Nome:</b> ".$mensagem->__get('name').
                           "<br><b>contato :</b>".$mensagem->__get('fone').
                           "<br><b>mensagem</b> : ".$mensagem->__get('message');
          //$mail->AltBody = 'caso não possa exibir html';

          $mail->send();
          
          $mensagem->status['codigo_status'] = 1;
          $mensagem->status['descricao_status'] = 'Email enviada com Sucesso!';

      } catch (Exception $e) {

          $mensagem->status['descricao_status'] = "Não foi possivel enviar este Email: {$mail->ErrorInfo}";
      }
  		
  	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>envio Sucesso</title>
  <link rel="stylesheet" href="css/materialize.css">
  <!-- CUSTOM CSS-->
  <link rel="stylesheet" href="css/custom.css">
</head>
<body>

  <div class="row">
    <div class="col12 center">

  <?php if($mensagem->status['codigo_status'] == 1){ 

    echo "<a href='#' ><img class='teal darken-3 logo_img2' src='img/Logo.png'></a>
                <a href='index.html' data-activates='mobile-demo' class='MenuPoha button-collapse'>
                  <i class='fas fa-bars fa-5x '></i></a>";

   echo "<h6 class='green-text'><b>Mensagem Enviado Com Sucesso!<b></h6>";
   echo "<a class='btn teal darken-2' href='index.html'>Voltar</a>";

  }else{

    echo "<a href='#' ><img class='deep-orange darken-4 logo_img2' src='img/Logo.png'></a>
                <a href='index.html' data-activates='mobile-demo' class='MenuPoha button-collapse'>
                  <i class='fas fa-bars fa-5x '></i></a>";

   echo "<p class='red-text'>".$mensagem->status['descricao_status']."</p>";
   echo "<a class='btn red' href='index.html'>Voltar</a>";

  } ?>

  </div>

  </div>

</body>
</html>