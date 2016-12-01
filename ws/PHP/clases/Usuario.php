<?php 
require_once"AccesoDatos.php";
class Usuario {

	public $user;
	public $pass;
    public $dni;

	public function getUser(){
		return $this->user;
	}

	public function setUser($user){
		$this->user = $user;
	}

	public function getPass(){
		return $this->pass;
	}

	public function setPass($pass){
		$this->pass = $pass;
	}
    
    public function getDni(){
		return $this->dni;
	}

	public function setDni($dni){
		$this->dni = $dni;
	}

	public function __construct(){

	}

	public static function ValidarUsuario($user, $pass, $dni){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario where user =:user and pass = :pass and dni=:dni");
		$consulta->bindValue(':user', $user, PDO::PARAM_STR);
		$consulta->bindValue(':pass', $pass, PDO::PARAM_STR);
		$consulta->bindValue(':dni', $dni, PDO::PARAM_STR);
		$consulta->execute();
		if($consulta->rowCount()==1){
			return true;
		} else {
			return false;
		}
	}
    
    public static function InsertarUsuario($usuario) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuario (user, pass, dni) VALUES (:user,:pass,:dni)");
        $consulta->bindValue(':user', $usuario['user'], PDO::PARAM_STR);
        $consulta->bindValue(':pass', $usuario['pass'], PDO::PARAM_STR);
        $consulta->bindValue(':dni', $usuario['dni'], PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerTodosLosUsuarios()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario");
		$consulta->execute();			
		$arrPersonas= $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");	
		return $arrPersonas;
	}

	public static function BorrarUsuario($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from usuario	WHERE id=:id");
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}
}
 ?>