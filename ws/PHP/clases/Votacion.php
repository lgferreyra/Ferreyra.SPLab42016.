<?php
require_once"accesoDatos.php";
class Votacion
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
  	public $dni;
  	public $sexo;
  	public $partido;

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetId()
	{
		return $this->id;
	}
	public function GetDni()
	{
		return $this->dni;
	}
	public function GetSexo()
	{
		return $this->sexo;
	}
    public function GetPartido()
    {
        return $this->partido;
    }

	public function SetId($valor)
	{
		$this->id = $valor;
	}
	public function SetDni($valor)
	{
		$this->dni = $valor;
	}
	public function SetSexo($valor)
	{
		$this->sexo = $valor;
	}
    public function SetPartido($valor)
    {
        $this->partido = $valor;
    }
//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($dni=NULL)
	{
		if($dni != NULL){
			$obj = Votacion::TraerUna($id);
			
			$this->partido = $obj->partido;
			$this->sexo = $obj->sexo;
			$this->id = $id;
            $this->dni = $obj->dni;
		}
	}

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function TraerUna($idParametro) 
	{	


		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from votaciones where id =:id");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$personaBuscada= $consulta->fetchObject('votacion');
		return $personaBuscada;	
					
	}
	
	public static function TraerTodas()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from votaciones");
		$consulta->execute();			
		$arrVotaciones= $consulta->fetchAll(PDO::FETCH_CLASS, "votacion");	
		return $arrVotaciones;
	}
	
	public static function Borrar($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from votaciones WHERE id=:id");
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}
	
	public static function Modificar($votacion)
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update votaciones 
            set
            dni=:dni,
            partido=:partido,
            sexo=:sexo
            WHERE id=:id");
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta->bindValue(':id',$votacion['id'], PDO::PARAM_INT);
        $consulta->bindValue(':dni', $votacion['dni'], PDO::PARAM_STR);
        $consulta->bindValue(':partido', $votacion['partido'], PDO::PARAM_STR);
        $consulta->bindValue(':sexo', $votacion['sexo'], PDO::PARAM_STR);
        return $consulta->execute();
	}

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//

	public static function Insertar($votacion)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into votaciones (dni,partido,sexo)values(:dni,:partido,:sexo)");
        $consulta->bindValue(':dni', $votacion['dni'], PDO::PARAM_STR);
        $consulta->bindValue(':partido', $votacion['partido'], PDO::PARAM_STR);
        $consulta->bindValue(':sexo', $votacion['sexo'], PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}	
}
